<?php
/**
 * A kalkulációt tartalmazó email törzse.
 *
 * Levelezőkliensre készül (Gmail, Outlook), ezért table layout és inline
 * style: a <style> blokkot és a flexboxot sok kliens eldobja.
 *
 * @var string $category  pl. "B"
 * @var array  $groups    CalculationMailBuilder::groups() kimenete
 * @var int    $total     végösszeg forintban
 * @var array|null $school  ['name' => string, 'period' => ?string, 'metrics' => [...]]
 */

use App\Services\CalculationMailBuilder as Calc;

$e = static fn(string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jogsi kalkuláció</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9;">
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f1f5f9; padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600"
                   style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden; font-family:Arial, Helvetica, sans-serif;">

                <!-- Fejléc -->
                <tr>
                    <td style="padding:24px; background:#0f172a;">
                        <div style="color:#ffffff; font-size:18px; font-weight:700;">Jogsikalkulátor</div>
                        <div style="color:#94a3b8; font-size:13px; margin-top:4px;">
                            <?= $e('A(z) "' . $category . '" kategóriás jogosítvány várható költsége') ?>
                        </div>
                    </td>
                </tr>

                <!-- Végösszeg -->
                <tr>
                    <td style="padding:24px 24px 8px; text-align:center;">
                        <div style="color:#64748b; font-size:13px;">Teljes becsült költség</div>
                        <div style="color:#0f172a; font-size:32px; font-weight:700; margin-top:4px;">
                            <?= $e(Calc::ft($total)) ?>
                        </div>
                    </td>
                </tr>

                <!-- Bontás -->
                <tr>
                    <td style="padding:16px 24px 24px;">

                        <?php foreach ($groups as $group): ?>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                   style="border-collapse:collapse; margin-bottom:16px; border:1px solid #e2e8f0; border-radius:6px;">
                                <tr>
                                    <td style="padding:10px 16px; background:#f8fafc; color:#0f172a; font-size:13px; font-weight:700; letter-spacing:0.3px;">
                                        <?= $e($group['title']) ?>
                                    </td>
                                    <td style="padding:10px 16px; background:#f8fafc; color:#0f172a; font-size:13px; font-weight:700; text-align:right; white-space:nowrap;">
                                        <?= $e(Calc::ft($group['total'])) ?>
                                    </td>
                                </tr>
                                <?php foreach ($group['rows'] as $row): ?>
                                    <tr>
                                        <td style="padding:8px 16px; border-bottom:1px solid #f1f5f9; color:#475569; font-size:14px;">
                                            <?= $e($row['label']) ?>
                                            <?php if (isset($row['hint'])): ?>
                                                <div style="color:#94a3b8; font-size:12px; margin-top:2px;">
                                                    <?= $e($row['hint']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding:8px 16px; border-bottom:1px solid #f1f5f9; color:#0f172a; font-size:14px; font-weight:600; text-align:right; white-space:nowrap;">
                                            <?= $e(Calc::ft($row['value'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endforeach; ?>

                        <!-- Összesen -->
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                               style="border-collapse:collapse; background:#0f172a; border-radius:6px;">
                            <tr>
                                <td style="padding:14px 16px; color:#ffffff; font-size:15px; font-weight:700;">ÖSSZESEN</td>
                                <td style="padding:14px 16px; color:#ffffff; font-size:15px; font-weight:700; text-align:right; white-space:nowrap;">
                                    <?= $e(Calc::ft($total)) ?>
                                </td>
                            </tr>
                        </table>

                        <!-- Autósiskola mutatói (csak ha választott iskolát) -->
                        <?php if ($school !== null): ?>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"
                                   style="border-collapse:collapse; margin-top:20px; background:#eef8f0; border:1px solid #c7e6cd; border-radius:6px;">
                                <tr>
                                    <td colspan="2" style="padding:12px 16px 4px; color:#2f6b3a; font-size:13px; font-weight:700;">
                                        <?= $e($school['name']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:0 16px 8px; color:#6b8a71; font-size:12px;">
                                        <?= $e('Hatósági mutatók a választott kategóriában'
                                            . ($school['period'] !== null ? ' - ' . $school['period'] : '')) ?>
                                    </td>
                                </tr>
                                <?php
                                $metricLabels = [
                                    'vsm_theory'    => 'Vizsga Sikerességi Mutató (VSM) - Elmélet',
                                    'vsm_traffic'   => 'Vizsga Sikerességi Mutató (VSM) - Forgalom',
                                    'ako_practical' => 'Átlagos Képzési Óraszám (ÁKÓ) - Gyakorlat',
                                ];
                                ?>
                                <?php foreach ($metricLabels as $key => $label): ?>
                                    <tr>
                                        <td style="padding:8px 16px; border-bottom:1px solid #d7ecdb; color:#4a5568; font-size:14px;">
                                            <?= $e($label) ?>
                                        </td>
                                        <td style="padding:8px 16px; border-bottom:1px solid #d7ecdb; color:#2f6b3a; font-size:14px; font-weight:700; text-align:right; white-space:nowrap;">
                                            <?= $e(Calc::percent($school['metrics'][$key] ?? null)) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>

                    </td>
                </tr>

                <!-- Lábléc -->
                <tr>
                    <td style="padding:16px 24px 24px; border-top:1px solid #e2e8f0; color:#94a3b8; font-size:12px; line-height:1.5;">
                        Ez egy tájékoztató jellegű becslés a megadott árak alapján, nem minősül ajánlatnak.
                        A levelet a Jogsikalkulátor küldte, mert valaki ezt az e-mail címet adta meg a kalkuláció mentésekor.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
