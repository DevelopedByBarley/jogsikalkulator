<?php

declare(strict_types=1);

namespace Core;

use RuntimeException;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class Mailer
{
    private static ?SymfonyMailer $instance = null;

    private static function instance(): SymfonyMailer
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $cfg = config('mailer.mailers.smtp');
        if (!is_array($cfg)) {
            throw new RuntimeException('Mailer SMTP config is missing.');
        }

        $host       = $cfg['host']       ?? '127.0.0.1';
        $port       = (int) ($cfg['port'] ?? 25);
        $username   = $cfg['username']   ?? null;
        $password   = $cfg['password']   ?? null;
        $encryption = $cfg['encryption'] ?? null;

        $scheme = $encryption === 'ssl' ? 'smtps' : 'smtp';

        if ($username && $password) {
            $dsn = sprintf('%s://%s:%s@%s:%d', $scheme, urlencode((string) $username), urlencode((string) $password), $host, $port);
        } else {
            $dsn = sprintf('%s://%s:%d', $scheme, $host, $port);
        }

        self::$instance = new SymfonyMailer(Transport::fromDsn($dsn));

        return self::$instance;
    }

    public static function send(string $to, string $subject, string $html, ?string $toName = null): void
    {
        $fromAddress = config('mailer.from.address', 'noreply@example.com');
        $fromName    = config('mailer.from.name', '');

        $email = (new Email())
            ->from($fromName ? "{$fromName} <{$fromAddress}>" : $fromAddress)
            ->to($toName ? "{$toName} <{$to}>" : $to)
            ->subject($subject)
            ->html($html);

        self::instance()->send($email);
    }
}
