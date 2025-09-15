<?php
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

        $headers = ["Content-Type: text/html; charset=UTF-8"];
        wp_mail($to, $subject, ob_get_clean(), $headers);

        unset($_SESSION['offerte']);

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
            wp_safe_redirect($bedankt_url);
            exit;
        }
        $success = true;
    }
} else {
    $current_step = 1;
}

get_header(); 
?>

<section class="bg-blue-900 text-white py-12">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl md:text-4xl font-bold mb-4"><?php the_field('pagina_titel'); ?></h1>
    <p class="mb-6"><?php the_field('intro_tekst'); ?></p>

    <?php if (!empty($success)) : ?>
        <div class="bg-green-100 text-green-800 p-4 rounded">
            ✅ <?php the_field('success_bericht'); ?>
        </div>
    <?php else : ?>
        <form method="POST" class="space-y-6 text-white">
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
                    <select name="dienst" class="w-full p-3 border rounded bg-white text-black" required>
                        <option value=""><?php the_field('selecteer_dienst_placeholder'); ?></option>
                        <?php if(have_rows('diensten')): while(have_rows('diensten')): the_row(); ?>
                            <option value="<?= esc_attr(get_sub_field('dienst_naam')) ?>"><?= esc_html(get_sub_field('dienst_naam')) ?></option>
                        <?php endwhile; endif; ?>
                    </select>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="laadplaats" placeholder="<?php the_field('laadplaats_placeholder'); ?>" class="p-3 border rounded bg-white text-black" required>
                        <input type="text" name="losplaats" placeholder="<?php the_field('losplaats_placeholder'); ?>" class="p-3 border rounded bg-white text-black" required>
                    </div>

                    <input type="date" name="datum" class="p-3 border rounded bg-white text-black w-full" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" name="pallets" placeholder="<?php the_field('pallets_placeholder'); ?>" class="p-3 border rounded bg-white text-black" required>
                        <input type="number" name="gewicht" placeholder="<?php the_field('gewicht_placeholder'); ?>" class="p-3 border rounded bg-white text-black" required>
                    </div>

                    <input type="text" name="afmeting" placeholder="<?php the_field('afmeting_placeholder'); ?>" class="w-full p-3 border rounded bg-white text-black">
                    <textarea name="omschrijving" placeholder="<?php the_field('omschrijving_placeholder'); ?>" class="w-full p-3 border rounded bg-white text-black min-h-[140px]"></textarea>
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
                    <input type="email" name="email" placeholder="<?php the_field('email_placeholder'); ?>" class="w-full p-3 border rounded" required>
                    <input type="text" name="telefoon" placeholder="<?php the_field('telefoon_placeholder'); ?>" class="w-full p-3 border rounded" required>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="date" name="start_datum" class="p-3 border rounded" required>
                        <input type="date" name="eind_datum" class="p-3 border rounded" required>
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
