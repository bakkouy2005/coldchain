<?php 
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_opslag_form') {
    handle_opslag_form();
}

function handle_opslag_form() {
    $fields = [
        'naam' => sanitize_text_field($_POST['naam'] ?? ''),
        'bedrijf' => sanitize_text_field($_POST['bedrijf'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'telefoon' => sanitize_text_field($_POST['telefoon'] ?? ''),
        'goederen' => sanitize_text_field($_POST['goederen'] ?? ''),
        'capaciteit' => sanitize_text_field($_POST['capaciteit'] ?? ''),
        'bericht' => sanitize_textarea_field($_POST['bericht'] ?? '')
    ];

    $admin_email = 'joullutfi76@outlook.com';
    $subject_admin = 'Nieuwe opslagaanvraag via Coldchain Website';
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Coldchain Website <info@coldchainlogisticservices.nl>',
        'Reply-To: ' . $fields['email']
    ];

    ob_start();
    ?>
    <html>
    <body style="font-family: Arial, sans-serif; background-color: #0A131F; color: white; padding: 40px;">
        <h2 style="color: #00aaff;">Nieuwe opslagaanvraag</h2>
        <p><strong>Naam:</strong> <?php echo esc_html($fields['naam']); ?></p>
        <p><strong>Bedrijfsnaam:</strong> <?php echo esc_html($fields['bedrijf']); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($fields['email']); ?></p>
        <p><strong>Telefoon:</strong> <?php echo esc_html($fields['telefoon']); ?></p>
        <p><strong>Type goederen:</strong> <?php echo esc_html($fields['goederen']); ?></p>
        <p><strong>Benodigde opslagcapaciteit:</strong> <?php echo esc_html($fields['capaciteit']); ?></p>
        <p><strong>Toelichting/vraag:</strong> <?php echo nl2br(esc_html($fields['bericht'])); ?></p>
    </body>
    </html>
    <?php
    $message_admin = ob_get_clean();

    // E-mail naar admin
    wp_mail($admin_email, $subject_admin, $message_admin, $headers);

    // Bevestigingsmail voor gebruiker
    $confirm_subject = 'Bevestiging van uw opslagaanvraag - Coldchain Logistic Services';
    $logo_url = get_template_directory_uri() . '/images/logo1.svg';
    $confirm_message = '
    <html lang="nl" style="margin:0; padding:0;">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bevestiging Opslagaanvraag</title>
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
                                Beste klant,
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; font-weight: 400; line-height: 1.6; color: #cccccc; padding-bottom: 30px; max-width:480px; margin: 0 auto;">
                                Bedankt voor uw opslagaanvraag bij Cold-chain Logistic Services. Wij hebben uw aanvraag ontvangen en nemen zo snel mogelijk contact met u op.
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 30px;">
                                <img src="http://test.coldchainlogisticservices.nl/wp-content/uploads/2025/10/ChatGPT-Image-28.-Okt.-2025-14_31_36.png" alt="Truck illustration" width="280" style="display:block; border:0; outline:none; text-decoration:none; margin: 0 auto;">
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
    wp_mail($fields['email'], $confirm_subject, $confirm_message, $headers);

    // Redirect naar bedanktpage
    $bedankt_page = get_page_by_path('bedankt');
    $bedankt_url = $bedankt_page ? get_permalink($bedankt_page) : home_url('/');
    echo '<!DOCTYPE html><html lang="nl"><head><meta http-equiv="refresh" content="0;url=' . esc_url($bedankt_url) . '"><script>window.location.href="' . esc_url($bedankt_url) . '";</script></head><body style="background:#0A131F;color:#fff;text-align:center;padding:50px;">U wordt doorgestuurd...<a href="' . esc_url($bedankt_url) . '" style="color:#00aaff;">Klik hier</a>.</body></html>';
    exit;
}

$opslag_aanvraag = get_field('opslag_aanvraag');

if ( $opslag_aanvraag && is_array( $opslag_aanvraag ) ) :        
    $text       = $opslag_aanvraag['text'] ?? '';       
    $text_area  = $opslag_aanvraag['text_area'] ?? ''; 
?>

<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- 2 kolommen: tekst links - formulier rechts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

            <!-- LINKERKOLOM (nu verticaal gecentreerd) -->
            <div class="order-2 lg:order-1 flex flex-col justify-center h-full">

                <div class="max-w-xl">
                    <?php if ( $text ) : ?>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 leading-snug mb-4">
                            <?php echo esc_html( $text ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $text_area ) : ?>
                        <div class="h-1 w-16 mb-5 rounded-full" style="background-color:#243866;"></div>
                        <div class="text-base sm:text-lg md:text-xl text-slate-700 leading-relaxed">
                            <?php echo wp_kses_post( $text_area ); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- RECHTERKOLOM: Formulier -->
            <div class="order-1 lg:order-2">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 lg:p-8">

                    <!-- jouw formulier blijft exact hetzelfde -->
                    <form action="" method="post" class="space-y-6">
                        <input type="hidden" name="action" value="send_opslag_form">

                        <!-- ... NIETS AANGEPAST AAN HET FORMULIER ... -->

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Naam</label>
                                <input type="text" name="naam" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Uw naam" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Bedrijfsnaam</label>
                                <input type="text" name="bedrijf" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Uw bedrijf">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">E-mailadres</label>
                                <input type="email" name="email" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="voorbeeld@bedrijf.nl" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Telefoonnummer</label>
                                <input type="tel" name="telefoon" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="+31 6 12345678">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Type goederen</label>
                                <input type="text" name="goederen" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Bijv. koel, vries, pharma">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Benodigde opslagcapaciteit</label>
                                <input type="text" name="capaciteit" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Bijv. aantal pallets / m³">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Toelichting / vraag</label>
                            <textarea name="bericht" rows="4" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Beschrijf kort uw situatie en wensen."></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                            <p class="text-xs text-slate-500">
                                Na verzending nemen wij zo snel mogelijk contact met u op over uw aanvraag.
                            </p>
                            <button type="submit" class="rounded-full px-7 py-3 text-sm font-semibold text-white shadow-md hover:shadow-lg transition duration-200" style="background-color:#243866;">
                                Verstuur aanvraag
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<?php endif; ?>
