<?php 
$overons_fototext = get_field('overons_fototext');

if ( $overons_fototext && is_array($overons_fototext) ) :
    $img       = $overons_fototext['img'] ?? null;        
    $text      = $overons_fototext['text'] ?? '';
    $text_area = $overons_fototext['text_area'] ?? '';
?>
<section class="bg-[#0A131F] text-white relative py-12 sm:py-16 md:py-20 min-h-[450px] md:min-h-[500px] lg:min-h-[550px]">

  <!-- TEKST -->
  <div class="container mx-auto px-4 relative z-10 flex items-center h-full">
    <div class="max-w-2xl pt-12 md:pt-16">
      <?php if ($text) : ?>
        <h2 class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl font-semibold text-gray-100 mb-3 leading-snug">
          <?php echo esc_html($text); ?>
        </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
        <div class="text-gray-200 leading-relaxed text-base sm:text-lg md:text-lg lg:text-xl">
          <?php echo wpautop( wp_kses_post( $text_area ) ); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- FOTO DESKTOP / TABLET -->
  <?php if ($img && ! empty($img['url'])) : ?>
    <div class="absolute top-0 right-0 h-full hidden sm:block w-[45vw] md:w-[40vw] lg:w-[35vw]">
      <img 
        src="<?php echo esc_url($img['url']); ?>" 
        alt="<?php echo esc_attr($img['alt']); ?>" 
        class="w-full h-full object-cover object-center"
      />
    </div>
  <?php endif; ?>

  <!-- FOTO MOBIEL -->
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
