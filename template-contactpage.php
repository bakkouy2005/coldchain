<?php
/**
 * Template Name: Contact
 */
get_header();

// Hero ACF velden
$hero_bg     = get_field('hero_image');
$hero_title  = get_field('hero_title');
$hero_desc   = get_field('hero_description');
$hero_cards  = get_field('hero_cards');

// Contact info blokken
$contact_infos = get_field('contact_infos');

// Formulier
$form_shortcode = get_field('contact_form_shortcode');
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
<section class="py-12 bg-blue-900 text-white">
  <div class="container mx-auto px-5">
    <div class=" mx-auto">
    <h3 class="text-4xl font-bold mb-6">Neem contact met ons op</h3>
      <div class=" p-6 rounded-lg shadow-lg">
      <?php if ($form_shortcode): ?>
        <?php echo do_shortcode($form_shortcode); ?>
      <?php else: ?>
        <form class="space-y-4">
          <div>
            <label class="block text-sm mb-1">Naam</label>
            <input type="text" class="w-full p-2 rounded-md text-black" placeholder="Voer uw naam in">
          </div>
          <div>
            <label class="block text-sm mb-1">E-mail</label>
            <input type="email" class="w-full p-2 rounded-md text-black" placeholder="Voer uw e-mail in">
          </div>
          <div>
            <label class="block text-sm mb-1">Omschrijving</label>
            <textarea class="w-full p-2 rounded-md text-black" rows="4" placeholder="Uw bericht"></textarea>
          </div>
          <button type="submit" class="bg-blue-600 px-6 py-2 rounded-md hover:bg-blue-700">Verzenden</button>
        </form>
      <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
