<?php 
$overons_fototext = get_field('overons_fototext');

if ( $overons_fototext && is_array($overons_fototext) ) :
    $img       = isset($overons_fototext['img']) ? $overons_fototext['img'] : null;        
    $text      = isset($overons_fototext['text']) ? $overons_fototext['text'] : '';
    $text_area = isset($overons_fototext['text_area']) ? $overons_fototext['text_area'] : '';
?>
<section class="bg-blue-900 text-white overflow-hidden ">
  <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-16 relative">

    <!-- Extra brede foto links -->
    <?php if ($img && is_array($img) && ! empty($img['url'])) : ?>
      <div class="relative w-full flex justify-start md:justify-end overflow-hidden md:order-2">
        <img 
          src="<?php echo esc_url($img['url']); ?>" 
          alt="<?php echo esc_attr($img['alt']); ?>" 
          class="w-80 sm:w-[500px] md:w-[850px] lg:w-[900px] h-64 sm:h-80 md:h-[650px] lg:h-[700px] object-cover md:ml-auto
                 
                 shadow-lg transition-all duration-500"
        />
      </div>
    <?php endif; ?>

    <!-- Tekst dichterbij foto -->
    <div class="container mx-auto px-4 md:pl-36 lg:pl-64 xl:pl-[380px] 2xl:pl-[520px] flex flex-col justify-center mt-8 md:mt-0 md:order-1">
      <?php if ($text) : ?>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">
          <?php echo esc_html($text); ?>
        </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
        <p class="text-base sm:text-lg md:text-lg leading-relaxed max-w-xl">
          <?php echo esc_html($text_area); ?>
        </p>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php endif; ?>
