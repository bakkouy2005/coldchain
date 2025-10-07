<?php
/**
 * Template Name: Contact
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_contact_form') {
    handle_contact_form();
}
add_action('admin_post_nopriv_send_contact_form', 'handle_contact_form');
add_action('admin_post_send_contact_form', 'handle_contact_form');

function handle_contact_form() {
    $fields = [
        'naam' => sanitize_text_field($_POST['naam'] ?? ''),
        'achternaam' => sanitize_text_field($_POST['achternaam'] ?? ''),
        'bedrijfsnaam' => sanitize_text_field($_POST['bedrijfsnaam'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'telefoon' => sanitize_text_field($_POST['telefoon'] ?? ''),
        'postcode' => sanitize_text_field($_POST['postcode'] ?? ''),
        'straat' => sanitize_text_field($_POST['straat'] ?? ''),
        'huisnummer' => sanitize_text_field($_POST['huisnummer'] ?? ''),
        'bericht' => sanitize_textarea_field($_POST['omschrijving'] ?? '')
    ];

    $admin_email = 'abde.bakk013@gmail.com';
    $subject_admin = 'Nieuwe contactaanvraag via Coldchain Website';
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Coldchain Website <info@coldchainlogisticservices.nl>',
        'Reply-To: ' . $fields['email']
    ];

    ob_start();
    ?>
    <html>
    <body style="font-family: Arial, sans-serif; background-color: #0A131F; color: white; padding: 40px;">
        <h2 style="color: #00aaff;">Nieuwe contactaanvraag</h2>
        <p><strong>Naam:</strong> <?php echo esc_html($fields['naam']); ?></p>
        <p><strong>Achternaam:</strong> <?php echo esc_html($fields['achternaam']); ?></p>
        <p><strong>Bedrijfsnaam:</strong> <?php echo esc_html($fields['bedrijfsnaam']); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($fields['email']); ?></p>
        <p><strong>Telefoon:</strong> <?php echo esc_html($fields['telefoon']); ?></p>
        <p><strong>Postcode:</strong> <?php echo esc_html($fields['postcode']); ?></p>
        <p><strong>Straat en huisnummer:</strong> <?php echo esc_html($fields['straat'] . ' ' . $fields['huisnummer']); ?></p>
        <p><strong>Bericht:</strong> <?php echo nl2br(esc_html($fields['bericht'])); ?></p>
    </body>
    </html>
    <?php
    $message_admin = ob_get_clean();

    // E-mail naar admin
    wp_mail($admin_email, $subject_admin, $message_admin, $headers);

    // Bevestigingsmail voor gebruiker
    $confirm_subject = 'Bevestiging van uw contactaanvraag - Coldchain Logistic Services';
    ob_start();
    include get_template_directory() . '/emails/contact-confirm-template.php'; // gebruik dezelfde template als offerte
    $confirm_message = ob_get_clean();
    wp_mail($fields['email'], $confirm_subject, $confirm_message, $headers);

    // Redirect naar bedanktpage
    $bedankt_page = get_page_by_path('bedankt');
    $bedankt_url = $bedankt_page ? get_permalink($bedankt_page) : home_url('/');
    echo '<!DOCTYPE html><html lang="nl"><head><meta http-equiv="refresh" content="0;url=' . esc_url($bedankt_url) . '"><script>window.location.href="' . esc_url($bedankt_url) . '";</script></head><body style="background:#0A131F;color:#fff;text-align:center;padding:50px;">U wordt doorgestuurd...<a href="' . esc_url($bedankt_url) . '" style="color:#00aaff;">Klik hier</a>.</body></html>';
    exit;
}

get_header();

// Hero ACF velden
$hero_bg     = get_field('hero_image');
$hero_title  = get_field('hero_title');
$hero_desc   = get_field('hero_description');
$hero_cards  = get_field('hero_cards');

// Contact info blokken
$contact_infos = get_field('contact_infos');
?>

<!-- HERO -->
<section class="relative bg-blue-900 text-white">
  <div class="absolute inset-0">
    <img src="<?php echo esc_url($hero_bg); ?>" alt="" class="w-full h-full object-cover">
  </div>
  <div class="absolute inset-0 bg-black/20"></div>

  <div class="relative">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-start min-h-[700px]">
        <div class="max-w-2xl text-left">
      <h2 class="text-4xl md:text-6xl font-bold mb-4">
        <?php echo esc_html($hero_title); ?>
      </h2>
      <p class="text-lg md:text-xl">
        <?php echo esc_html($hero_desc); ?>
      </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HERO CARDS -->
<?php if ($hero_cards): ?>
  <section class="relative z-10 -mt-16">
    <div class="container mx-auto px-4">
      <div class=" mx-auto grid grid-cols-1 sm:grid-cols-2 gap-10">
      <?php foreach ($hero_cards as $card): ?>
        <div class="bg-white shadow-xl p-10 md:p-12 rounded-xl text-center">
          <?php if ($card['icon_class']): ?>
            <i class="<?php echo esc_attr($card['icon_class']); ?> text-4xl md:text-5xl text-blue-600 mb-4"></i>
          <?php endif; ?>
          <h3 class="font-semibold text-2xl md:text-3xl mb-4">
            <?php echo esc_html($card['title']); ?>
          </h3>
          <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-6">
            <?php echo esc_html($card['description']); ?>
          </p>
          <?php if (!empty($card['button']['url'])): ?>
            <a href="<?php echo esc_url($card['button']['url']); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
              <?php echo esc_html($card['button']['text']); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- CONTACT INFO BLOKKEN -->
<?php if ($contact_infos): ?>
  <section class="py-12 ">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 px-4">
      <?php foreach ($contact_infos as $info): ?>
        <div class="bg-white shadow-xl p-12 rounded-md text-center">
          <?php if ($info['icon_class']): ?>
            <i class="<?php echo esc_attr($info['icon_class']); ?> text-2xl text-blue-600 mb-2"></i>
          <?php endif; ?>
          <h4 class="font-semibold mb-1">
            <?php echo esc_html($info['title']); ?>
          </h4>
          <p class="text-gray-600 text-sm">
            <?php echo esc_html($info['value']); ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<!-- CONTACT FORM -->
<section class="py-12 bg-[#0A131F] text-white">
  <div class="container mx-auto px-5">
    <h3 class="text-4xl font-bold mb-6">Neem contact met ons op</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="md:col-span-2  p-6 rounded-lg text-black">
        <form action="<?php echo esc_url( get_permalink() ); ?>" method="POST" class="space-y-4">
          <input type="hidden" name="action" value="send_contact_form">
          <div>
            <label for="naam" class="block text-sm font-semibold text-gray-700 mb-1">Naam</label>
            <input id="naam" type="text" name="naam" class="w-full p-3 rounded-md border" placeholder="Voer uw naam in" required>
          </div>
          <div>
            <label for="achternaam" class="block text-sm font-semibold text-gray-700 mb-1">Achternaam</label>
            <input id="achternaam" type="text" name="achternaam" class="w-full p-3 rounded-md border" placeholder="Voer uw achternaam in" required>
          </div>
          <div>
            <label for="bedrijfsnaam" class="block text-sm font-semibold text-gray-700 mb-1">Bedrijfsnaam</label>
            <input id="bedrijfsnaam" type="text" name="bedrijfsnaam" class="w-full p-3 rounded-md border" placeholder="Voer uw bedrijfsnaam in">
          </div>
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
            <input id="email" type="email" name="email" class="w-full p-3 rounded-md border" placeholder="Voer uw e-mail in" required>
          </div>
          <div>
            <label for="telefoon" class="block text-sm font-semibold text-gray-700 mb-1">Telefoon</label>
            <input id="telefoon" type="text" name="telefoon" class="w-full p-3 rounded-md border" placeholder="Voer uw telefoonnummer in">
          </div>
          <div>
            <label for="postcode" class="block text-sm font-semibold text-gray-700 mb-1">Postcode</label>
            <input id="postcode" type="text" name="postcode" class="w-full p-3 rounded-md border" placeholder="Voer uw postcode in">
          </div>
          <div>
            <label for="straat" class="block text-sm font-semibold text-gray-700 mb-1">Straat</label>
            <input id="straat" type="text" name="straat" class="w-full p-3 rounded-md border" placeholder="Voer uw straatnaam in">
          </div>
          <div>
            <label for="huisnummer" class="block text-sm font-semibold text-gray-700 mb-1">Huisnummer</label>
            <input id="huisnummer" type="text" name="huisnummer" class="w-full p-3 rounded-md border" placeholder="Voer uw huisnummer in">
          </div>
          <div>
            <label for="omschrijving" class="block text-sm font-semibold text-gray-700 mb-1">Omschrijving</label>
            <textarea id="omschrijving" name="omschrijving" rows="4" class="w-full p-3 rounded-md border" placeholder="Uw bericht" required></textarea>
          </div>
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Verzenden</button>
        </form>
      </div>
      <div class="bg-[#1E3264] text-white p-6 rounded-lg flex flex-col justify-between h-full">
        <div>
          <h4 class="text-xl font-bold mb-2 text-left">Liever een offerte aanvragen?</h4>
          <p class="text-sm font-bold mb-4 text-left">Klik hier voor uw aanvraag, ons plaatsingsteam stuurt u binnen één werkdag een offerte voor uw aanvraag.</p>
        </div>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path('offerte') ) ); ?>" class="mt-auto self-end text-4xl">
          <i class="fa-solid fa-arrow-right transform rotate-45"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
