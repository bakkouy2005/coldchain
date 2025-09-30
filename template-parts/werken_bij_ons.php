<?php 
$werken_bij_ons = get_field('werken_bij_ons');

if ( $werken_bij_ons && is_array($werken_bij_ons) ) :
    $img       = $werken_bij_ons['img'] ?? null;        
    $title     = $werken_bij_ons['text'] ?? '';
    $text_area = $werken_bij_ons['text_area'] ?? '';
    $button    = isset($werken_bij_ons['button']) && is_array($werken_bij_ons['button']) ? $werken_bij_ons['button'] : [];
    $btn_label = $button['text'] ?? '';
    $btn_url   = $button['url'] ?? '';
?>
<section class="bg-[#0A131F] text-white relative overflow-hidden py-16 sm:py-20 md:py-24 lg:py-28 min-h-[450px] md:min-h-[500px] lg:min-h-[550px]">

  <!-- Tekst links -->
  <div class="container mx-auto px-4 relative z-10 flex items-center h-full">
    <div class="max-w-xl">
      <?php if ($title) : ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 leading-snug ">
          <?php echo esc_html($title); ?>
        </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
        <div class="text-gray-200 leading-relaxed text-base sm:text-lg md:text-lg lg:text-xl mb-6">
          <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
        </div>
      <?php endif; ?>

      <?php if ($btn_label && $btn_url) : ?>
        <a href="<?php echo esc_url($btn_url); ?>" 
           class="inline-block px-6 py-3 rounded-lg bg-white text-blue-900 font-semibold hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white mt-6">
          <?php echo esc_html($btn_label); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Afbeelding rechts (volledige hoogte) -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="absolute top-0 right-0 h-full hidden sm:block w-[45vw] md:w-[40vw] lg:w-[35vw]">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- Afbeelding bovenaan op mobiel -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="w-full h-48 sm:hidden">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

</section>
<?php endif; ?>
