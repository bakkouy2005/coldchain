<?php 
$werken_bij_ons = get_field('werken_bij_ons');

if ( $werken_bij_ons && is_array($werken_bij_ons) ) :
    $img       = $werken_bij_ons['img'] ?? null;        
    $title     = $werken_bij_ons['text'] ?? '';
    $text_area = $werken_bij_ons['text_area'] ?? '';
    // Button via ACF niet meer nodig

    // Vind de pagina met het vacature overzicht template en gebruik die URL altijd
    $overview_page_url = '';
    $vacature_overzicht_pages = get_pages([
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'template-vacature-overzicht.php',
        'post_status'=> 'publish',
        'number'     => 1,
    ]);
    if (!empty($vacature_overzicht_pages)) {
        $overview_page_url = trailingslashit(get_permalink($vacature_overzicht_pages[0]->ID)) . '#vacature_overzicht_hero';
    }
?>
<section class="bg-[#0A131F] text-white relative overflow-hidden min-h-[450px] md:min-h-[500px] lg:min-h-[550px] sm:flex sm:items-center">

  <!-- Tekst (altijd zichtbaar, op mobiel boven) -->
  <div class="container mx-auto px-4 relative z-10 flex items-center h-full">
    <div class="max-w-xl sm:max-w-[55%] md:max-w-[60%] lg:max-w-xl py-12 sm:py-16 md:py-20">
      <?php if ($title) : ?>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 leading-snug">
          <?php echo esc_html($title); ?>
        </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
        <div class="text-gray-200 leading-relaxed text-lg sm:text-xl md:text-xl lg:text-2xl mb-6">
          <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
        </div>
      <?php endif; ?>

      <?php if ($overview_page_url) : ?>
        <a href="<?php echo esc_url($overview_page_url); ?>" 
           class="inline-block px-6 py-3 rounded-lg bg-white text-blue-900 font-semibold hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white mt-6">
          <?php echo esc_html__('Bekijk vacatures', 'coldchain-development'); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Afbeelding rechts op tablet/desktop -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="hidden sm:block absolute top-0 right-0 h-full w-[45vw] md:w-[40vw] lg:w-[35vw]">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- Afbeelding onderaan op mobiel -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="sm:hidden w-full h-48">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

</section>
<?php endif; ?>
