<?php 
$overons_fototext = get_field('overons_fototext');

if ( $overons_fototext && is_array($overons_fototext) ) :
    $img       = $overons_fototext['img'] ?? null;        
    $text      = $overons_fototext['text'] ?? '';
    $text_area = $overons_fototext['text_area'] ?? '';
    $button    = $overons_fototext['button'] ?? ''; 
    $btn_label = isset($button['text']) ? $button['text'] : '';
    $btn_url   = isset($button['url']) ? $button['url'] : '';
?>
<section class="bg-[#0A131F] text-white relative min-h-[450px] md:min-h-[500px] lg:min-h-[550px]">

  <!-- FOTO OP MOBIEL BOVENAAN -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="block md:hidden w-full h-48 relative">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- TEKST CONTAINER -->
  <div class="container mx-auto px-0 relative z-10">
    <div class="flex flex-col md:flex-row md:gap-8 md:items-stretch">
      <!-- TEKST -->
      <div class="px-4 pt-20 pb-12   
                  md:pt-44 md:pb-24 
                  lg:pt-40 lg:pb-28 
                  flex items-center w-full md:w-1/2">
        <div class="max-w-2xl w-full">
          <?php if ($text) : ?>
            <h2 class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl font-semibold text-gray-100 mb-3 leading-snug">
              <?php echo esc_html($text); ?>
            </h2>
          <?php endif; ?>

          <?php if ($text_area) : ?>
            <div class="text-gray-200 leading-relaxed text-base sm:text-lg md:text-lg lg:text-xl mb-6">
              <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
            </div>
          <?php endif; ?>

          <!-- BUTTON -->
          <?php if ($btn_label && $btn_url) : ?>
            <div class="mt-4">
              <a href="<?php echo esc_url($btn_url); ?>" 
                 class="inline-block px-6 py-4 rounded-md bg-blue-900 text-white font-semibold hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 text-lg sm:text-xl">
                <?php echo esc_html($btn_label); ?>
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- FOTO DESKTOP / TABLET -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="hidden md:flex md:w-1/2 h-auto absolute top-0 right-0 bottom-0">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover"
      />
    </div>
  <?php endif; ?>

</section>
<?php endif; ?>
