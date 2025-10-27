<?php
/* Template Name: sollicitatieformulier*/
get_header();

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

<script>
document.getElementById('closePopup')?.addEventListener('click', function() {
    const popup = document.getElementById('popup');
    const content = document.getElementById('popupContent');
    if (!popup || !content) return;
    content.classList.add('translate-y-10', 'opacity-0');
    content.classList.remove('translate-y-0', 'opacity-100');
    setTimeout(() => {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        location.reload();
    }, 500);
});

// Toon popup bij succesvolle Advanced Forms submissie
(function() {
    const wrapper = document.getElementById('sollicitatie-form');
    if (!wrapper) return;

    const showPopup = () => {
        const popup = document.getElementById('popup');
        const content = document.getElementById('popupContent');
        if (!popup || !content) return;
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('translate-y-10', 'opacity-0');
            content.classList.add('translate-y-0', 'opacity-100');
        }, 50);
    };

    // 1) Directe check: staat er een success-notice in de form?
    const successSelector = '.af-notice-success, .af-success, .acf-notice.-success, .acf-success-message, .message.success';
    if (wrapper.querySelector(successSelector)) {
        showPopup();
        return;
    }

    // 2) URL parameter check (bij non-AJAX submit)
    const params = new URLSearchParams(window.location.search);
    if (params.has('af_success') || params.get('submitted') === 'true') {
        showPopup();
        return;
    }

    // 3) Observeer DOM voor AJAX success meldingen
    const observer = new MutationObserver((mutations) => {
        for (const m of mutations) {
            if (m.addedNodes && m.addedNodes.length) {
                if (wrapper.querySelector(successSelector)) {
                    showPopup();
                    observer.disconnect();
                    break;
                }
            }
        }
    });
    observer.observe(wrapper, { childList: true, subtree: true });
})();
</script>




   
   
</div>

<?php

// E-mailverzending voor dit formulier wordt nu afgehandeld in functions.php via de globale AF hooks.

get_footer();

?>