<?php
/* Template Name: sollicitatieformulier*/
get_header();

// === Eigen formulierverwerking voor sollicitatieformulier ===
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['email']) || isset($_POST['voornaam_achternaam']))) {
    // DEBUG: toon alle onbewerkte POST-data
    echo '<pre style="color:white;">'; print_r($_POST); echo '</pre>';
    // Verzamel en sanitize invoervelden
    $vacature_functie   = isset($_POST['vacature_functie']) ? sanitize_text_field($_POST['vacature_functie']) : '';
    $naam               = isset($_POST['voornaam_achternaam']) ? sanitize_text_field($_POST['voornaam_achternaam']) : '';
    $email              = isset($_POST['emailadres']) ? sanitize_email($_POST['emailadres']) : (isset($_POST['email']) ? sanitize_email($_POST['email']) : '');
    $woonplaats         = isset($_POST['woonplaats']) ? sanitize_text_field($_POST['woonplaats']) : '';
    $telefoonnummer     = isset($_POST['telefoonnummer']) ? sanitize_text_field($_POST['telefoonnummer']) : '';
    $bericht            = isset($_POST['bericht']) ? sanitize_text_field($_POST['bericht']) : '';
    $contactvoorkeur    = isset($_POST['contactvoorkeur']) ? sanitize_text_field($_POST['contactvoorkeur']) : '';
    $cv_document        = isset($_POST['cv_document']) ? sanitize_text_field($_POST['cv_document']) : '';

    // Bouw HTML mailbericht (zelfde stijl als offerte)
    ob_start();
    ?>
    <html>
    <body style="font-family: Arial, sans-serif; background: #0a131f; padding:20px;">
    <table width="100%" cellpadding="10" cellspacing="0" style="background:#fff; border-radius:8px;">
        <tr>
            <td colspan="2" style="text-align:center; font-size:20px; font-weight:bold; color:#1e3a8a; background:#004DFF;">Nieuwe sollicitatie</td>
        </tr>
        <?php if ($vacature_functie): ?>
            <tr><td><strong>Vacature functie:</strong></td><td><?= esc_html($vacature_functie) ?></td></tr>
        <?php endif; ?>
        <?php if ($naam): ?>
            <tr><td><strong>Naam:</strong></td><td><?= esc_html($naam) ?></td></tr>
        <?php endif; ?>
        <?php if ($email): ?>
            <tr><td><strong>E-mail:</strong></td><td><?= esc_html($email) ?></td></tr>
        <?php endif; ?>
        <?php if ($woonplaats): ?>
            <tr><td><strong>Woonplaats:</strong></td><td><?= esc_html($woonplaats) ?></td></tr>
        <?php endif; ?>
        <?php if ($telefoonnummer): ?>
            <tr><td><strong>Telefoonnummer:</strong></td><td><?= esc_html($telefoonnummer) ?></td></tr>
        <?php endif; ?>
        <?php if ($contactvoorkeur): ?>
            <tr><td><strong>Contactvoorkeur:</strong></td><td><?= esc_html($contactvoorkeur) ?></td></tr>
        <?php endif; ?>
        <?php if ($cv_document): ?>
            <tr><td><strong>CV Document:</strong></td><td><?= esc_html($cv_document) ?></td></tr>
        <?php endif; ?>
        <?php if ($bericht): ?>
            <tr><td><strong>Bericht:</strong></td><td><?= nl2br(esc_html($bericht)) ?></td></tr>
        <?php endif; ?>
    </table>
    </body>
    </html>
    <?php
    $message = ob_get_clean();

    // Mail instellingen
    $to = 'info@coldchainlogisticservices.nl';
    $bcc = 'abde.bakk013@gmail.com';
    $subject = 'Nieuwe sollicitatie van ' . ($naam ? $naam : 'onbekend');
    $headers = [
        "Content-Type: text/html; charset=UTF-8",
        "From: Coldchain Website <info@coldchainlogisticservices.nl>",
        ($email ? "Reply-To: " . $email : "")
    ];

    // Stuur mail naar beheerder en BCC
    wp_mail([$to, $bcc], $subject, $message, $headers);

    // Bevestigingsmail naar sollicitant
    $logo_url = get_template_directory_uri() . '/images/logo.svg';
    $confirm_subject = "Bevestiging van uw sollicitatie - Coldchain Logistic Services";
    $confirm_message = '<!DOCTYPE html>
<html lang="nl" style="margin:0; padding:0;">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bevestiging Sollicitatie</title>
</head>
<body style="margin:0; padding:0; background-color:#0a131f; font-family: Arial, sans-serif; color:#ffffff;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#0a131f; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background-color:#0a131f; border-radius:8px; text-align:center; padding: 30px;">
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <img src="' . esc_url($logo_url) . '" alt="Coldchain Logo" width="150" style="display:block; border:0; outline:none; text-decoration:none; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 26px; font-weight: 700; padding-bottom: 20px;">
                            Beste ' . esc_html($naam ? $naam : 'kandidaat') . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; font-weight: 400; line-height: 1.6; color: #cccccc; padding-bottom: 30px; max-width:480px; margin: 0 auto;">
                            Bedankt voor uw sollicitatie bij Cold-chain Logistic Services. Wij hebben uw sollicitatie ontvangen en nemen zo spoedig mogelijk contact met u op.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <img src="http://test.coldchainlogisticservices.nl/wp-content/uploads/2025/10/ChatGPT-Image-6-okt-2025-15_52_23.png" alt="Truck illustration" width="280" style="display:block; border:0; outline:none; text-decoration:none; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; font-weight: 400; color: #cccccc; padding-bottom: 10px;">
                            Met vriendelijke groet,<br>
                            Het team van Cold-Chain Logistik Services
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; color: #808080;">
                            Als u nog vragen hebt neem dan contact op met: <a href="mailto:info@coldchailogistikservices.nl" style="color: #808080; text-decoration: none;">info@coldchailogistikservices.nl</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 30px; border-top:1px solid #1f2a47; font-size: 14px; color: #666e85;">
                            &copy; ' . date("Y") . ' Coldchain Logistic Services. Alle rechten voorbehouden.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';
    if ($email) {
        wp_mail($email, $confirm_subject, $confirm_message, $headers);
    }
    $success = true;
}

/**
 * HTML e-mailtemplate voor sollicitaties.
 * Gebruik: cc_get_solicitatie_email_html( [ 'naam' => 'Voornaam Achternaam', 'functie' => 'Functie', 'email' => 'kandidaat@example.com', 'telefoon' => '0612345678', 'bericht' => 'Korte motivatie' ] );
 */
if ( ! function_exists( 'cc_get_solicitatie_email_html' ) ) {
    function cc_get_solicitatie_email_html( $data = array() ) {
        $defaults = array(
            'naam'     => 'Onbekende kandidaat',
            'functie'  => 'Onbekende functie',
            'email'    => '-',
            'telefoon' => '-',
            'bericht'  => '',
        );
        $d = array_merge( $defaults, array_map( 'wp_kses_post', (array) $data ) );

        ob_start();
        ?>
        <!doctype html>
        <html lang="nl">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Nieuwe sollicitatie</title>
            <style>
                .wrapper{max-width:640px;margin:0 auto;background:#0A131F;color:#E5E7EB;font-family:Arial,Helvetica,sans-serif;border-radius:12px;overflow:hidden;border:1px solid #1f2937}
                .header{background:#004DFF;padding:20px 24px}
                .header h1{margin:0;color:#fff;font-size:20px}
                .content{padding:24px}
                .row{margin:0 0 10px}
                .label{color:#93c5fd;font-weight:bold}
                .val{color:#E5E7EB}
                .cta{display:inline-block;margin-top:18px;padding:10px 16px;background:#FDB314;color:#111827;text-decoration:none;border-radius:8px;font-weight:bold}
                .footer{padding:16px 24px;color:#9CA3AF;font-size:12px;border-top:1px solid #1f2937}
            </style>
        </head>
        <body style="background:#0b1220;padding:24px">
            <div class="wrapper">
                <div class="header">
                    <h1>Nieuwe sollicitatie ontvangen</h1>
                </div>
                <div class="content">
                    <div class="row"><span class="label">Kandidaat:</span> <span class="val"><?php echo esc_html( $d['naam'] ); ?></span></div>
                    <div class="row"><span class="label">Functie:</span> <span class="val"><?php echo esc_html( $d['functie'] ); ?></span></div>
                    <div class="row"><span class="label">E-mail:</span> <span class="val"><?php echo esc_html( $d['email'] ); ?></span></div>
                    <div class="row"><span class="label">Telefoon:</span> <span class="val"><?php echo esc_html( $d['telefoon'] ); ?></span></div>
                    <?php if ( ! empty( $d['bericht'] ) ) : ?>
                        <div class="row"><span class="label">Bericht:</span><br> <div class="val"><?php echo nl2br( esc_html( $d['bericht'] ) ); ?></div></div>
                    <?php endif; ?>
                    <a class="cta" href="<?php echo esc_url( home_url('/') ); ?>">Bekijk in admin</a>
                </div>
                <div class="footer">
                    Deze e-mail is automatisch gegenereerd door de website.
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

/**
 * Testmail trigger: voeg `?send_test_mail=1` toe aan de URL van deze pagina om een testmail te sturen.
 * Verstuurt naar het door de gebruiker opgegeven testadres.
 */
$cc_test_mail_sent = false;
if ( isset( $_GET['send_test_mail'] ) && '1' === $_GET['send_test_mail'] ) {
    $to       = 'abde.bakk013@gmail.com';
    $subject  = 'Test: Sollicitatie e-mailtemplate';
    // Gebruik de functie: vul met demogegevens
    $body     = cc_get_solicitatie_email_html( array(
        'naam'     => 'Test Kandidaat',
        'functie'  => isset( $functie ) && $functie ? $functie : 'Chauffeur (test)',
        'email'    => 'test.kandidaat@example.com',
        'telefoon' => '0612345678',
        'bericht'  => 'Dit is een testbericht om te controleren of het sjabloon goed binnenkomt.',
    ) );
    $headers  = array(
        'Content-Type: text/html; charset=UTF-8',
        // Pas de afzender aan naar je domein/mailbox:
        'From: Cold Chain Recruitment <noreply@' . preg_replace( '/^www\./', '', parse_url( home_url(), PHP_URL_HOST ) ) . '>',
        'Reply-To: no-reply@' . preg_replace( '/^www\./', '', parse_url( home_url(), PHP_URL_HOST ) ),
    );
    $cc_test_mail_sent = wp_mail( $to, $subject, $body, $headers );
}


$vacature_id = isset($_GET['id']) ? absint($_GET['id']) : 0;
$functie = $vacature_id ? get_field('text', $vacature_id) : '';




?>

<div class="">

<?php if ( isset( $cc_test_mail_sent ) && $cc_test_mail_sent ) : ?>
    <div style="background:#D1FAE5;color:#065F46;padding:12px 16px;margin:12px;border:1px solid #10B981;border-radius:8px">
        Testmail is verzonden naar <strong>abde.bakk013@gmail.com</strong>.
    </div>
<?php elseif ( isset( $_GET['send_test_mail'] ) && '1' === $_GET['send_test_mail'] ) : ?>
    <div style="background:#FEE2E2;color:#991B1B;padding:12px 16px;margin:12px;border:1px solid #FCA5A5;border-radius:8px">
        Versturen van de testmail is niet gelukt. Controleer server mailinstellingen.
    </div>
<?php endif; ?>


<!-- Hele pagina achtergrond -->
<div class="w-full min-h-screen flex flex-col bg-[#0A131F]">

    <!-- Container uitgelijnd met header/footer -->
    <div class="container mx-auto px-4 py-12 flex-1">

        <?php
        $sollicitatieformulier = get_field('sollicitatieformulier');

        $text1 = $sollicitatieformulier['text1'] ?? '';
        $text_area1 = $sollicitatieformulier['text_area1'] ?? '';
        $img = $sollicitatieformulier['img'] ?? '';
        $text2 = $sollicitatieformulier['text2'] ?? '';
        $text_area2 = $sollicitatieformulier['text_area2'] ?? '';
        ?>

        <!-- Titel en beschrijving -->
        <?php if($text1): ?>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">U gaat  solliciteren</h2>
        <?php endif; ?>
        <?php if($text_area1): ?>
            <p class="text-gray-300 mb-10 text-lg md:text-xl"><?php echo esc_html($text_area1); ?></p>
        <?php endif; ?>

        <!-- Formulier + afbeelding rechts -->
        <div class="md:flex md:gap-8 items-start">

            <!-- Formuliervelden links -->
            <div id="sollicitatie-form" class="flex-1 space-y-6 mb-8">
            <?php if ($functie): ?>
  <p class="text-white mb-6">
    U solliciteert voor de functie: <strong><?php echo esc_html($functie); ?></strong>
  </p>
<?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="bg-green-100 text-green-800 p-4 rounded">
                        ✅ Uw sollicitatie is succesvol verzonden. We nemen spoedig contact op.
                    </div>
                <?php endif; ?>
                <?php if ( function_exists('advanced_form') ) { advanced_form('form_68cd65b633b84', array(
        'values' => array(
            'vacature_functie' => $functie, // hier vullen we hem automatisch
        ),)); } ?>
            </div>

            <!-- Afbeelding + tip rechts -->
            <div class="mt-6 md:mt-0 md:w-1/3 space-y-6">
                <?php if($img): ?>
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-auto">
                    </div>
                <?php endif; ?>

                <?php if($text2 || $text_area2): ?>
                    <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                        <?php if($text2): ?>
                            <h3 class="text-white font-semibold mb-2 text-lg"><?php echo esc_html($text2); ?></h3>
                        <?php endif; ?>
                        <?php if($text_area2): ?>
                            <p class="text-gray-300 text-sm"><?php echo esc_html($text_area2); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Popup Modal -->
<div id="popup" class="fixed inset-0 bg-[#0A131F] bg-opacity-95 hidden items-center justify-center z-50 transition-opacity duration-500 ease-out">
    <div id="popupContent" class="transform translate-y-10 opacity-0 rounded-lg shadow-lg max-w-md w-full p-6 text-center border border-gray-700 transition-all duration-500 ease-out">
        <!-- Blauw vinkje -->
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-[#004DFF]" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M20.707 5.293a1 1 0 010 1.414L10.414 17l-5.121-5.121a1 1 0 011.414-1.414L10.414 14.172l9.879-9.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4">Bedankt - Uw sollicitatie is verzonden</h2>
        <p class="text-gray-300 mb-6">We sturen u een bevestiging per e-mail. Wij nemen binnen 5 werkdagen contact met u op.</p>
        <button id="closePopup" class="px-6 py-2 rounded-lg font-bold text-white bg-[#004DFF] hover:bg-[#FDB314] transition-colors duration-300">Sluiten</button>
    </div>
</div>






   
   
</div>

<?php
get_footer();
?>