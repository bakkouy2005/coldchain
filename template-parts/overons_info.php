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
<section class="bg-white text-black overflow-hidden py-16">
  <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-16 relative">

    <?php if ($img && is_array($img) && ! empty($img['url'])) : ?>
    <div class="relative w-full h-full flex justify-start overflow-hidden">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-80 sm:w-[500px] md:w-[850px] lg:w-[900px] h-64 sm:h-80 md:h-[650px] lg:h-[700px] object-cover"
      />
    </div>
    <?php endif; ?>

    <div class="container mx-auto px-4 md:pl-6 lg:pl-8 xl:pl-10 flex flex-col justify-center md:order-2 max-w-2xl">
      <?php if ($title) : ?>
      <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4">
        <?php echo esc_html($title); ?>
      </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
      <div class="text-gray-800 leading-relaxed text-base md:text-[15px] mb-6">
        <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
      </div>
      <?php endif; ?>

      <?php if ($btn_label && $btn_url) : ?>
      <a href="<?php echo esc_url($btn_url); ?>" class="inline-flex items-center px-5 py-3 rounded bg-blue-900 text-white font-medium hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 w-max">
        <?php echo esc_html($btn_label); ?>
      </a>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php endif; ?>


