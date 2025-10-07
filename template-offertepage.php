<?php
if (function_exists('ob_start')) ob_start();
/**
 * Template Name: Offerte page
 */

if (!session_id()) session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offerte_step'])) {
    $step = intval($_POST['offerte_step']);

    if ($step === 1) {
        $_SESSION['offerte'] = array_map('sanitize_text_field', [
            'dienst'        => $_POST['dienst'],
            'laadplaats'    => $_POST['laadplaats'],
            'losplaats'     => $_POST['losplaats'],
            'datum'         => $_POST['datum'],
            'pallets'       => $_POST['pallets'],
            'gewicht'       => $_POST['gewicht'],
            'afmeting'      => $_POST['afmeting'],
            'omschrijving'  => $_POST['omschrijving'],
        ]);
        $current_step = 2;
    } elseif ($step === 2) {
        $_SESSION['offerte'] = array_merge($_SESSION['offerte'], [
            'email'      => sanitize_email($_POST['email']),
            'telefoon'   => sanitize_text_field($_POST['telefoon']),
            'start_datum'=> sanitize_text_field($_POST['start_datum']),
            'eind_datum' => sanitize_text_field($_POST['eind_datum']),
        ]);

        $offerte = $_SESSION['offerte'];

        // 1) Save to database as custom post type 'offerte'
        $title_email = !empty($offerte['email']) ? $offerte['email'] : 'onbekend';
        $title_time  = current_time('mysql');
        $post_id = wp_insert_post(array(
            'post_type'   => 'offerte',
            'post_status' => 'private',
            'post_title'  => sprintf('Offerte van %s (%s)', $title_email, $title_time),
            'post_content'=> '',
        ));
        if ($post_id && !is_wp_error($post_id)) {
            foreach ($offerte as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
        }

        // 2) Email recipient and subject
        $to = get_field('email_ontvanger', 'option') ?: get_bloginfo('admin_email');
        $subject = "Nieuwe offerte aanvraag van " . $offerte['email'];

        ob_start(); ?>
        <html>
        <body style="font-family: Arial, sans-serif; background: #f9f9f9; padding:20px;">
        <table width="100%" cellpadding="10" cellspacing="0" style="background:#fff; border-radius:8px;">
            <tr><td colspan="2" style="text-align:center; font-size:20px; font-weight:bold; color:#1e3a8a;">Offerte aanvraag</td></tr>
            <?php foreach($offerte as $key => $value): ?>
                <tr><td><strong><?= ucfirst(str_replace('_',' ',$key)) ?>:</strong></td><td><?= esc_html($value) ?></td></tr>
            <?php endforeach; ?>
        </table>
        </body>
        </html>
        <?php

        $message = ob_get_clean();
        $headers = [
            "Content-Type: text/html; charset=UTF-8",
            "From: Coldchain Website <info@coldchainlogisticservices.nl>",
            "Reply-To: " . sanitize_email($offerte['email'])
        ];

        // Stuur naar ontvanger
        wp_mail($to, $subject, $message, $headers);

        // Kopie naar testadres
        wp_mail('abde.bakk013@gmail.com', $subject, $message, $headers);

        // Bevestigingsmail naar gebruiker
        $logo_url = get_template_directory_uri() . '/images/logo.svg';
        $confirm_subject = "Bevestiging van uw offerte aanvraag - Coldchain Logistic Services";
        $confirm_message = '<!DOCTYPE html>
<html lang="nl" style="margin:0; padding:0;">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bevestiging Offerte Aanvraag</title>
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
                            Bedankt voor uw aanvraag bij Cold-chain Logistic Services. Wij hebben uw aanvraag ontvangen en nemen zo snel mogelijk contact met u op.
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

        wp_mail($offerte['email'], $confirm_subject, $confirm_message, $headers);

        unset($_SESSION['offerte']);

        $success = true;

        // Redirect to Bedankt page (prefer by template, fallback by slug)
        $bedankt_url = null;
        $bedankt_page = get_pages([
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'template-bedanktpage.php',
            'number'     => 1,
        ]);
        if (!empty($bedankt_page)) {
            $bedankt_url = get_permalink($bedankt_page[0]->ID);
        } else {
            $by_slug = get_page_by_path('bedankt');
            if ($by_slug) {
                $bedankt_url = get_permalink($by_slug->ID);
            }
        }
        if ($bedankt_url) {
            if (ob_get_length()) ob_end_clean();
            header("Location: " . $bedankt_url);
            exit;
        }
    }
} else {
    $current_step = 1;
}

get_header(); 
?>

<section class="bg-[#0A131F] text-white py-12">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl md:text-4xl font-bold mb-4"><?php the_field('pagina_titel'); ?></h1>
    <p class="mb-6"><?php the_field('intro_tekst'); ?></p>

    <?php if (!empty($success)) : ?>
        <div class="bg-green-100 text-green-800 p-4 rounded">
            ✅ <?php the_field('success_bericht'); ?>
        </div>
    <?php else : ?>
        <form id="offerte-form" method="POST" class="space-y-6 text-white">
            <input type="hidden" name="offerte_step" value="<?php echo $current_step; ?>">

            <?php if ($current_step === 1) : ?>
                <h2 class="text-sm font-medium mb-2">Stap 1 van 2</h2>
                <div class="flex items-center mb-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full w-1/2"></div>
                    </div>
                </div>

                <h3 class="text-2xl md:text-3xl font-semibold mb-3"><?php the_field('stap_1_titel'); ?></h3>

                <div class="space-y-4">
                    <select name="dienst" class="w-full p-3 rounded" required>
                        <option value=""><?php the_field('selecteer_dienst_placeholder'); ?></option>
                        <?php if(have_rows('diensten')): while(have_rows('diensten')): the_row(); ?>
                            <option value="<?= esc_attr(get_sub_field('dienst_naam')) ?>"><?= esc_html(get_sub_field('dienst_naam')) ?></option>
                        <?php endwhile; endif; ?>
                    </select>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="laadplaats" placeholder="<?php the_field('laadplaats_placeholder'); ?>" class="p-3 rounded" required>
                        <input type="text" name="losplaats" placeholder="<?php the_field('losplaats_placeholder'); ?>" class="p-3 rounded" required>
                    </div>

                    <input type="date" name="datum" class="p-3 rounded w-full" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" name="pallets" placeholder="<?php the_field('pallets_placeholder'); ?>" class="p-3 rounded" required>
                        <input type="number" name="gewicht" placeholder="<?php the_field('gewicht_placeholder'); ?>" class="p-3 rounded" required>
                    </div>

                    <input type="text" name="afmeting" placeholder="<?php the_field('afmeting_placeholder'); ?>" class="w-full p-3 rounded">
                    <textarea name="omschrijving" placeholder="<?php the_field('omschrijving_placeholder'); ?>" class="w-full p-3 rounded min-h-[140px]"></textarea>
                </div>

                <button type="submit" class="bg-blue-800 text-white px-6 py-3 rounded hover:bg-blue-800">Volgende</button>

            <?php elseif ($current_step === 2) : ?>
                <h2 class="text-xl font-semibold mb-4">Stap 2 van 2</h2>
                <div class="flex items-center mb-6">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full w-full"></div>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="email" name="email" placeholder="<?php the_field('email_placeholder'); ?>" class="w-full p-3 rounded" required>
                    <input type="text" name="telefoon" placeholder="<?php the_field('telefoon_placeholder'); ?>" class="w-full p-3 rounded" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="date" name="start_datum" class="p-3 rounded" required>
                        <input type="date" name="eind_datum" class="p-3 rounded" required>
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="window.history.back()" class="bg-gray-200 text-black px-6 py-3 rounded hover:bg-gray-300">Vorige</button>
                    <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded hover:bg-blue-800">Verstuur</button>
                </div>
            <?php endif; ?>
        </form>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
