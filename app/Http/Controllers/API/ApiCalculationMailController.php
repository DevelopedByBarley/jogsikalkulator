<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Services\CalculationMailBuilder;
use Core\Log;
use Core\Mailer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * A kalkuláció kiküldése a felhasználó által megadott email címre.
 *
 * A kliens csak a NYERS számokat küldi, a levél HTML-jét mi állítjuk elő
 * (CalculationMailBuilder + emails/calculation view). Így a POST body nem
 * tud tetszőleges tartalmat a nevünkben kiküldeni.
 */
class ApiCalculationMailController extends ApiController
{
    /** Egy session ennyi levelet küldhet az alábbi időablakban. */
    private const RATE_LIMIT = 5;
    private const RATE_WINDOW_SECONDS = 3600;

    public function send(): JsonResponse
    {
        $payload = json_decode((string) file_get_contents('php://input'), true);

        if (!is_array($payload)) {
            return $this->error('Érvénytelen kérés.');
        }

        $email = trim((string) ($payload['email'] ?? ''));

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->error('Adj meg egy érvényes e-mail címet.');
        }

        // A GDPR pipa jogalap: enélkül nem küldünk levelet.
        if (($payload['gdpr'] ?? false) !== true) {
            return $this->error('Az adatkezelési nyilatkozat elfogadása kötelező.');
        }

        if (!is_array($payload['calculation'] ?? null)) {
            return $this->error('Hiányzó kalkuláció.');
        }

        if (!$this->underRateLimit()) {
            return $this->error('Túl sok kérés. Kérlek, próbáld újra később.', 429);
        }

        $calc   = CalculationMailBuilder::normalize($payload['calculation']);
        $school = CalculationMailBuilder::normalizeSchool($payload['school'] ?? null);

        try {
            Mailer::send(
                $email,
                sprintf('A jogsi kalkulációd – "%s" kategória', $calc['category']),
                CalculationMailBuilder::render($calc, $school)
            );
        } catch (Throwable $e) {
            // A kliensnek nem adjuk vissza az SMTP hibát, de naplózzuk.
            Log::error('[calculation-mail] küldés sikertelen: ' . $e->getMessage());

            return $this->error('Nem sikerült elküldeni a levelet. Kérlek, próbáld újra később.', 500);
        }

        $this->recordSend();

        return $this->success(null, 'Elküldtük a kalkulációt a megadott e-mail címre.');
    }

    /**
     * Session alapú korlát: nem tökéletes védelem (a session eldobható),
     * de a triviális visszaéléstől megvéd. Igazi védelem a reCAPTCHA lesz.
     */
    private function underRateLimit(): bool
    {
        return count($this->recentSends()) < self::RATE_LIMIT;
    }

    private function recordSend(): void
    {
        $sends   = $this->recentSends();
        $sends[] = time();

        \Core\Session::put('calc_mail_sends', $sends);
    }

    /** @return array<int> az időablakon belüli küldések időbélyegei */
    private function recentSends(): array
    {
        $sends = \Core\Session::get('calc_mail_sends', []);

        if (!is_array($sends)) {
            return [];
        }

        $cutoff = time() - self::RATE_WINDOW_SECONDS;

        return array_values(array_filter(
            $sends,
            static fn($ts) => is_int($ts) && $ts > $cutoff
        ));
    }
}
