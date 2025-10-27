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
            <div id="sollicitatie-form" class="flex-1 space-y-6 mb-8">
                <?php if ($functie): ?>
                  <p class="text-white mb-6">
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
                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-white mb-2" for="voornaam_achternaam">Naam*</label>
                        <input class="w-full px-4 py-2 rounded bg-gray-800 text-white" type="text" name="voornaam_achternaam" id="voornaam_achternaam" value="<?php echo esc_attr($_POST['voornaam_achternaam'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="emailadres">E-mailadres*</label>
                        <input class="w-full px-4 py-2 rounded bg-gray-800 text-white" type="email" name="emailadres" id="emailadres" value="<?php echo esc_attr($_POST['emailadres'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="telefoonnummer">Telefoonnummer</label>
                        <input class="w-full px-4 py-2 rounded bg-gray-800 text-white" type="text" name="telefoonnummer" id="telefoonnummer" value="<?php echo esc_attr($_POST['telefoonnummer'] ?? ''); ?>">
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="woonplaats">Woonplaats</label>
                        <input class="w-full px-4 py-2 rounded bg-gray-800 text-white" type="text" name="woonplaats" id="woonplaats" value="<?php echo esc_attr($_POST['woonplaats'] ?? ''); ?>">
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="vacature_functie">Functie</label>
                        <input class="w-full px-4 py-2 rounded bg-gray-800 text-white" type="text" name="vacature_functie" id="vacature_functie" value="<?php echo esc_attr($functie ?: ($_POST['vacature_functie'] ?? '')); ?>" readonly>
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="bericht">Bericht</label>
                        <textarea class="w-full px-4 py-2 rounded bg-gray-800 text-white" name="bericht" id="bericht" rows="4"><?php echo esc_textarea($_POST['bericht'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="contactvoorkeur">Contactvoorkeur</label>
                        <select class="w-full px-4 py-2 rounded bg-gray-800 text-white" name="contactvoorkeur" id="contactvoorkeur">
                            <option value="">Geen voorkeur</option>
                            <option value="email" <?php selected($_POST['contactvoorkeur'] ?? '', 'email'); ?>>E-mail</option>
                            <option value="telefoon" <?php selected($_POST['contactvoorkeur'] ?? '', 'telefoon'); ?>>Telefoon</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-white mb-2" for="cv_document">CV uploaden*</label>
                        <input class="w-full text-white" type="file" name="cv_document" id="cv_document" accept=".pdf,.doc,.docx,.odt,.txt" required>
                    </div>
                    <div>
                        <button class="px-6 py-2 rounded-lg font-bold text-white bg-[#004DFF] hover:bg-[#FDB314] transition-colors duration-300" type="submit">Verzenden</button>
                    </div>
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




   
   
</div>

<?php
get_footer();
?>