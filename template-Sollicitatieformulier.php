<?php
/* Template Name: sollicitatieformulier*/

// Verwerking van formulier
$success = false;
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verzamel velden
    $voornaam_achternaam = sanitize_text_field($_POST['voornaam_achternaam'] ?? '');
    $emailadres = sanitize_email($_POST['emailadres'] ?? '');
    $telefoonnummer = sanitize_text_field($_POST['telefoonnummer'] ?? '');
    $woonplaats = sanitize_text_field($_POST['woonplaats'] ?? '');
    $vacature_functie = sanitize_text_field($_POST['vacature_functie'] ?? '');
    $bericht = sanitize_textarea_field($_POST['bericht'] ?? '');
    $contactvoorkeur = sanitize_text_field($_POST['contactvoorkeur'] ?? '');
    $cv_document_id = 0;

    // Validatie (optioneel, uitbreidbaar)
    if (empty($voornaam_achternaam)) $errors[] = 'Naam is verplicht.';
    if (empty($emailadres) || !is_email($emailadres)) $errors[] = 'Voer een geldig e-mailadres in.';

    // Alleen PDF-bestanden toestaan bij upload
    if (isset($_FILES['cv_document']) && $_FILES['cv_document']['error'] !== 4) {
        $file_ext = strtolower(pathinfo($_FILES['cv_document']['name'], PATHINFO_EXTENSION));
        if ($file_ext !== 'pdf') {
            $errors[] = 'Alleen PDF-bestanden zijn toegestaan.';
        } else {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $uploaded = media_handle_upload('cv_document', 0);
            if (is_wp_error($uploaded)) {
                $errors[] = 'Fout bij uploaden van CV: ' . $uploaded->get_error_message();
            } else {
                $cv_document_id = $uploaded;
            }
        }
    }

    if (empty($errors)) {
        // Post aanmaken
        $post_id = wp_insert_post(array(
            'post_type' => 'sollicitatie_entry',
            'post_status' => 'publish',
            'post_title' => $voornaam_achternaam . ' - ' . $vacature_functie,
            'post_content' => $bericht,
        ));
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, 'voornaam_achternaam', $voornaam_achternaam);
            update_post_meta($post_id, 'emailadres', $emailadres);
            update_post_meta($post_id, 'telefoonnummer', $telefoonnummer);
            update_post_meta($post_id, 'woonplaats', $woonplaats);
            update_post_meta($post_id, 'vacature_functie', $vacature_functie);
            update_post_meta($post_id, 'bericht', $bericht);
            update_post_meta($post_id, 'contactvoorkeur', $contactvoorkeur);
            if ($cv_document_id) {
                update_post_meta($post_id, 'cv_document', $cv_document_id);
            }

            // E-mail naar beheerder (HTML template in offerte-stijl)
            $logo_url = get_template_directory_uri() . '/images/logo1.svg';
            $to = 'info@coldchainlogisticservices.nl';
            $bcc = array('abde.bakk013@gmail.com');
            $subject = 'Nieuwe sollicitatie: ' . $voornaam_achternaam;

            ob_start(); ?>
            <html>
            <body style="font-family: Arial, sans-serif; background: #0A131F; padding:20px;">
            <table width="100%" cellpadding="10" cellspacing="0" style="background:#fff; border-radius:8px;">
                <tr>
                    <td colspan="2" style="text-align:center; background:#004DFF; color:#fff; padding:20px;">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Coldchain Logo" width="120" style="margin-bottom:10px;">
                        <h2 style="margin:0;">Nieuwe sollicitatie</h2>
                    </td>
                </tr>
                <tr><td><strong>Naam:</strong></td><td><?php echo esc_html($voornaam_achternaam); ?></td></tr>
                <tr><td><strong>E-mail:</strong></td><td><?php echo esc_html($emailadres); ?></td></tr>
                <tr><td><strong>Telefoonnummer:</strong></td><td><?php echo esc_html($telefoonnummer); ?></td></tr>
                <tr><td><strong>Woonplaats:</strong></td><td><?php echo esc_html($woonplaats); ?></td></tr>
                <tr><td><strong>Functie:</strong></td><td><?php echo esc_html($vacature_functie); ?></td></tr>
                <tr><td><strong>Contactvoorkeur:</strong></td><td><?php echo esc_html($contactvoorkeur); ?></td></tr>
                <tr><td><strong>Bericht:</strong></td><td><?php echo nl2br(esc_html($bericht)); ?></td></tr>
                <?php if ($cv_document_id): ?>
                    <tr><td><strong>CV:</strong></td><td><a href="<?php echo esc_url(wp_get_attachment_url($cv_document_id)); ?>" target="_blank">Download PDF</a></td></tr>
                <?php endif; ?>
            </table>
            </body>
            </html>
            <?php
            $message = ob_get_clean();
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Coldchain Website <info@coldchainlogisticservices.nl>');
            foreach ($bcc as $bcc_addr) {
                $headers[] = 'Bcc: ' . $bcc_addr;
            }
            wp_mail($to, $subject, $message, $headers);

            // Bevestigingsmail naar sollicitant (offerte-stijl)
            $confirm_subject = "Bevestiging van uw sollicitatie - Coldchain Logistic Services";
            $confirm_message = '<!DOCTYPE html>
<html lang="nl" style="margin:0; padding:0;">
<head><meta charset="UTF-8" /></head>
<body style="margin:0; padding:0; background-color:#0a131f; font-family: Arial, sans-serif; color:#ffffff;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#0a131f; padding:40px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width:600px; background-color:#0a131f; border-radius:8px; text-align:center; padding: 30px;">
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <img src="' . esc_url($logo_url) . '" alt="Coldchain Logo" width="150" style="margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 22px; font-weight: 700; padding-bottom: 20px;">Beste ' . esc_html($voornaam_achternaam) . ',</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; line-height: 1.6; color: #cccccc; padding-bottom: 30px;">Bedankt voor uw sollicitatie bij Cold-chain Logistic Services. Wij hebben uw gegevens ontvangen en nemen zo spoedig mogelijk contact met u op.</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <img src="http://test.coldchainlogisticservices.nl/wp-content/uploads/2025/10/ChatGPT-Image-6-okt-2025-15_52_23.png" alt="Truck illustration" width="280" style="margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; color: #cccccc;">Met vriendelijke groet,<br>Het team van Cold-Chain Logistik Services</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px; font-size: 13px; color: #808080;">© ' . date("Y") . ' Coldchain Logistic Services. Alle rechten voorbehouden.</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
            wp_mail($emailadres, $confirm_subject, $confirm_message, $headers);

            // Redirect met success=1
            wp_safe_redirect(add_query_arg('success', '1', get_permalink()));
            exit;
        } else {
            $errors[] = 'Er is iets misgegaan met het opslaan van uw sollicitatie.';
        }
    }
}

get_header();

$vacature_id = isset($_GET['id']) ? absint($_GET['id']) : 0;
$functie = $vacature_id ? get_field('text', $vacature_id) : '';

// Verwerking van formulier
$success = false;
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verzamel velden
    $voornaam_achternaam = sanitize_text_field($_POST['voornaam_achternaam'] ?? '');
    $emailadres = sanitize_email($_POST['emailadres'] ?? '');
    $telefoonnummer = sanitize_text_field($_POST['telefoonnummer'] ?? '');
    $woonplaats = sanitize_text_field($_POST['woonplaats'] ?? '');
    $vacature_functie = sanitize_text_field($_POST['vacature_functie'] ?? '');
    $bericht = sanitize_textarea_field($_POST['bericht'] ?? '');
    $contactvoorkeur = sanitize_text_field($_POST['contactvoorkeur'] ?? '');
    $cv_document_id = 0;

    // Validatie (optioneel, uitbreidbaar)
    if (empty($voornaam_achternaam)) $errors[] = 'Naam is verplicht.';
    if (empty($emailadres) || !is_email($emailadres)) $errors[] = 'Voer een geldig e-mailadres in.';
    if (empty($cv_document_id) && isset($_FILES['cv_document']) && $_FILES['cv_document']['error'] !== 4) {
        // Bestand uploaden
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $uploaded = media_handle_upload('cv_document', 0);
        if (is_wp_error($uploaded)) {
            $errors[] = 'Fout bij uploaden van CV: ' . $uploaded->get_error_message();
        } else {
            $cv_document_id = $uploaded;
        }
    }

    if (empty($errors)) {
        // Post aanmaken
        $post_id = wp_insert_post(array(
            'post_type' => 'sollicitatie_entry',
            'post_status' => 'publish',
            'post_title' => $voornaam_achternaam . ' - ' . $vacature_functie,
            'post_content' => $bericht,
        ));
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, 'voornaam_achternaam', $voornaam_achternaam);
            update_post_meta($post_id, 'emailadres', $emailadres);
            update_post_meta($post_id, 'telefoonnummer', $telefoonnummer);
            update_post_meta($post_id, 'woonplaats', $woonplaats);
            update_post_meta($post_id, 'vacature_functie', $vacature_functie);
            update_post_meta($post_id, 'bericht', $bericht);
            update_post_meta($post_id, 'contactvoorkeur', $contactvoorkeur);
            if ($cv_document_id) {
                update_post_meta($post_id, 'cv_document', $cv_document_id);
            }

            // E-mail naar beheerder
            $to = 'info@coldchainlogisticservices.nl';
            $bcc = array('abde.bakk013@gmail.com');
            $subject = 'Nieuwe sollicitatie: ' . $voornaam_achternaam;
            $message = '<h2>Nieuwe sollicitatie</h2>';
            $message .= '<ul>';
            $message .= '<li><strong>Naam:</strong> ' . esc_html($voornaam_achternaam) . '</li>';
            $message .= '<li><strong>E-mail:</strong> ' . esc_html($emailadres) . '</li>';
            $message .= '<li><strong>Telefoonnummer:</strong> ' . esc_html($telefoonnummer) . '</li>';
            $message .= '<li><strong>Woonplaats:</strong> ' . esc_html($woonplaats) . '</li>';
            $message .= '<li><strong>Functie:</strong> ' . esc_html($vacature_functie) . '</li>';
            $message .= '<li><strong>Contactvoorkeur:</strong> ' . esc_html($contactvoorkeur) . '</li>';
            $message .= '<li><strong>Bericht:</strong> ' . nl2br(esc_html($bericht)) . '</li>';
            if ($cv_document_id) {
                $cv_url = wp_get_attachment_url($cv_document_id);
                $message .= '<li><strong>CV:</strong> <a href="' . esc_url($cv_url) . '" target="_blank">Download</a></li>';
            }
            $message .= '</ul>';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            foreach ($bcc as $bcc_addr) {
                $headers[] = 'Bcc: ' . $bcc_addr;
            }
            wp_mail($to, $subject, $message, $headers);

            // Bevestigingsmail naar sollicitant
            $bevestiging = '<h2>Bedankt voor uw sollicitatie</h2>';
            $bevestiging .= '<p>Beste ' . esc_html($voornaam_achternaam) . ',</p>';
            $bevestiging .= '<p>Uw sollicitatie is succesvol ontvangen. Wij nemen binnen 5 werkdagen contact met u op.</p>';
            $bevestiging .= '<p>Met vriendelijke groet,<br>Cold Chain Logistic Services</p>';
            wp_mail($emailadres, 'Bevestiging van uw sollicitatie', $bevestiging, array('Content-Type: text/html; charset=UTF-8'));

            // Redirect met success=1
            wp_safe_redirect(add_query_arg('success', '1', get_permalink()));
            exit;
        } else {
            $errors[] = 'Er is iets misgegaan met het opslaan van uw sollicitatie.';
        }
    }
}
?>

<div class="">


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
            <div id="sollicitatie-form" class="flex-1 space-y-6 mb-8 ">
                <?php if ($functie): ?>
                  <p class="text-white mb-6 display-none">
                    U solliciteert voor de functie: <strong><?php echo esc_html($functie); ?></strong>
                  </p>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        <?php foreach ($errors as $err): ?>
                            <p><?php echo esc_html($err); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Naam -->
                    <div class="flex flex-col">
                        <label class="block text-white mb-2" for="voornaam_achternaam">Naam*</label>
                        <input class="w-full px-4 py-3 rounded-lg bg-gray-900/70 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                               type="text" name="voornaam_achternaam" id="voornaam_achternaam"
                               value="<?php echo esc_attr($_POST['voornaam_achternaam'] ?? ''); ?>" required>
                    </div>
                    <!-- E-mail -->
                    <div class="flex flex-col">
                        <label class="block text-white mb-2" for="emailadres">E-mailadres*</label>
                        <input class="w-full px-4 py-3 rounded-lg bg-gray-900/70 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                               type="email" name="emailadres" id="emailadres"
                               value="<?php echo esc_attr($_POST['emailadres'] ?? ''); ?>" required>
                    </div>
                    <!-- Telefoon -->
                    <div class="flex flex-col">
                        <label class="block text-white mb-2" for="telefoonnummer">Telefoonnummer</label>
                        <input class="w-full px-4 py-3 rounded-lg bg-gray-900/70 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                               type="text" name="telefoonnummer" id="telefoonnummer"
                               value="<?php echo esc_attr($_POST['telefoonnummer'] ?? ''); ?>">
                    </div>
                    <!-- Woonplaats -->
                    <div class="flex flex-col">
                        <label class="block text-white mb-2" for="woonplaats">Woonplaats</label>
                        <input class="w-full px-4 py-3 rounded-lg bg-gray-900/70 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                               type="text" name="woonplaats" id="woonplaats"
                               value="<?php echo esc_attr($_POST['woonplaats'] ?? ''); ?>">
                    </div>
                    <!-- Functie (read-only) -->
                    <input type="hidden" name="vacature_functie" id="vacature_functie" value="<?php echo esc_attr($functie ?: ($_POST['vacature_functie'] ?? '')); ?>">
                    <!-- Bericht -->
                    <div class="md:col-span-2 flex flex-col">
                        <label class="block text-white mb-2" for="bericht">Bericht</label>
                        <textarea class="w-full px-4 py-3 rounded-lg bg-gray-900/70 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                                  name="bericht" id="bericht" rows="5"><?php echo esc_textarea($_POST['bericht'] ?? ''); ?></textarea>
                    </div>
                    <!-- Contactvoorkeur -->
                    <div class="md:col-span-2 flex flex-col">
    <label class="block text-white mb-2">Contactvoorkeur</label>
    <div class="flex flex-wrap gap-6 text-white">
        <?php $pref = $_POST['contactvoorkeur'] ?? ''; ?>
        <label class="inline-flex items-center gap-2">
            <input type="radio" name="contactvoorkeur" value="email"
                   <?php checked($pref, 'email'); ?>
                   class="accent-[#004DFF]">
            <span>E-mail</span>
        </label>
        <label class="inline-flex items-center gap-2">
            <input type="radio" name="contactvoorkeur" value="telefoon"
                   <?php checked($pref, 'telefoon'); ?>
                   class="accent-[#004DFF]">
            <span>Telefoon</span>
        </label>
        
        <label class="inline-flex items-center gap-2">
            <input type="radio" name="contactvoorkeur" value="whatsapp"
                   <?php checked($pref, 'whatsapp'); ?>
                   class="accent-[#004DFF]">
            <span>WhatsApp</span>
        </label>
    </div>
</div>
                    <!-- CV -->
                    <div class="flex flex-col">
                        <label class="block text-white mb-2" for="cv_document">CV uploaden*</label>
                        <input class="w-full file:mr-4 file:px-4 file:py-2 file:rounded-lg file:border-0 file:bg-[#004DFF] file:text-white file:font-semibold file:cursor-pointer bg-gray-900/70 text-gray-300 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#004DFF] focus:border-transparent transition"
                               type="file" name="cv_document" id="cv_document" accept=".pdf" required>
                        <small class="text-gray-400 mt-1">Alleen PDF-bestanden toegestaan.</small>
                    </div>
                    <!-- Verzenden -->
                    <div class="md:col-span-2">
                        <button class="w-full md:w-auto px-8 py-3 rounded-lg font-bold text-white bg-[#004DFF] hover:bg-[#FDB314] hover:text-[#0A131F] transition-colors duration-300"
                                type="submit">Verzenden</button>
                    </div>
                    <!-- Contact knoppen -->
                    
                </form>
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
                <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                    <h3 class="text-white font-semibold mb-3">Direct contact</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/31600000000" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-500 text-white font-semibold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.91 11.91 0 0012.06 0C5.44.05.1 5.39.06 12.01a11.9 11.9 0 001.65 6.06L0 24l6.12-1.6a11.94 11.94 0 005.94 1.59h.01c6.62-.03 11.96-5.37 11.99-11.99a11.9 11.9 0 00-3.54-8.52zM12.06 21.9h-.01a9.9 9.9 0 01-5.04-1.37l-.36-.21-3.64.95.97-3.55-.23-.37a9.9 9.9 0 01-1.37-5.04C2.41 6.52 6.57 2.36 12.08 2.33h.02c5.49 0 9.96 4.46 9.93 9.95-.03 5.48-4.49 9.62-9.97 9.62zm5.46-7.46c-.3-.15-1.77-.88-2.05-.98-.27-.1-.47-.15-.67.15-.2.3-.77.98-.94 1.18-.17.2-.35.23-.65.08-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.29.3-.49.1-.2.05-.38-.02-.53-.08-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.38s-1.03 1.01-1.03 2.47 1.06 2.86 1.21 3.06c.15.2 2.1 3.2 5.08 4.49.71.31 1.27.49 1.7.63.71.23 1.36.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/></svg>
                            WhatsApp
                        </a>
                        <a href="mailto:info@coldchainlogisticservices.nl"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-semibold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            E-mail
                        </a>
                    </div>
                </div>
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

// Toon popup bij succesvolle verzending via URL param
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
    // Check op ?success=1 in URL
    const params = new URLSearchParams(window.location.search);
    if (params.get('success') === '1') {
        showPopup();
        // optioneel: verwijder ?success=1 uit de URL na tonen
        window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/([&?])success=1(&|$)/, '$1').replace(/[\?&]$/, ''));
    }
})();
</script>

<script>
// === Real-time PDF-validatie bij upload ===
document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.getElementById("cv_document");
    if (!fileInput) return;

    const errorMsg = document.createElement("p");
    errorMsg.style.color = "#f87171"; // rood
    errorMsg.style.marginTop = "8px";
    errorMsg.style.display = "none";
    errorMsg.textContent = "Alleen PDF-bestanden zijn toegestaan.";
    fileInput.parentNode.appendChild(errorMsg);

    // Check bij elke wijziging
    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) {
            errorMsg.style.display = "none";
            return;
        }

        const ext = file.name.split(".").pop().toLowerCase();
        if (ext !== "pdf") {
            errorMsg.style.display = "block";
            fileInput.value = ""; // reset
        } else {
            errorMsg.style.display = "none";
        }
    });

    // Extra beveiliging: check ook bij submit
    const form = fileInput.closest("form");
    form.addEventListener("submit", (e) => {
        const file = fileInput.files[0];
        if (!file) return; // nog niets gekozen
        const ext = file.name.split(".").pop().toLowerCase();
        if (ext !== "pdf") {
            e.preventDefault();
            errorMsg.style.display = "block";
            alert("Upload alleen een PDF-bestand.");
        }
    });
});
</script>




   
   
</div>

<?php
get_footer();
?>