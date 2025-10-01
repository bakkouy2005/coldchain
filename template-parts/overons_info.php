<?php 
$overons_info = get_field('overons_info');

if ( $overons_info && is_array($overons_info) ) :
    $img       = isset($overons_info['img']) ? $overons_info['img'] : null;
    $title     = isset($overons_info['text']) ? $overons_info['text'] : '';
    $text_area = isset($overons_info['text_area']) ? $overons_info['text_area'] : '';
    $button    = isset($overons_info['button']) && is_array($overons_info['button']) ? $overons_info['button'] : array();
    $btn_label = isset($button['text']) ? $button['text'] : '';
    $btn_url   = isset($button['url']) ? $button['url'] : '';
?>
<section class="bg-white text-black relative min-h-[450px] md:min-h-[500px] lg:min-h-[550px] sm:flex sm:items-center overflow-hidden">

  <!-- FOTO LINKS OP DESKTOP / TABLET -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="hidden sm:block absolute top-0 left-0 h-full w-[45vw] md:w-[40vw] lg:w-[35vw]">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="h-full w-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- FOTO BOVENAAN OP MOBIEL -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="sm:hidden w-full h-48 relative mb-6">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- TEKST + KNOP -->
  <div class="container mx-auto px-6 relative z-10 sm:flex sm:items-center">
    <div class="flex flex-col justify-center max-w-2xl ml-0 sm:ml-[calc(45vw+1rem)] md:ml-[calc(45vw+2rem)] lg:ml-[calc(35vw+3rem)]">

      <?php if ($title) : ?>
      <h2 class="text-2xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-snug">
        <?php echo esc_html($title); ?>
      </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
      <div class="text-gray-800 leading-relaxed text-base sm:text-base md:text-lg mb-6">
        <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
      </div>
      <?php endif; ?>

      <?php if ($btn_label && $btn_url) : ?>
      <div>
        <a href="<?php echo esc_url($btn_url); ?>" 
           class="inline-block w-full sm:w-auto px-5 py-2 rounded-md bg-blue-900 text-white font-semibold hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 text-base text-center">
          <?php echo esc_html($btn_label); ?>
        </a>
      </div>
      <?php endif; ?>

    </div>
  </div>

</section>
<?php endif; ?>
