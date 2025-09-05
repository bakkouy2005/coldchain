<?php 
$overons = get_field('overons');

if( $overons ) :
    $img = $overons['img'];         
    $text = $overons['text'];       
    $text_area = $overons['text_area']; 
?>
<section class="bg-blue-900 text-white overflow-hidden ">
  <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-16 relative">

    <!-- Extra brede foto links -->
    <?php if ($img) : ?>
      <div class="relative w-full flex justify-start overflow-hidden">
        <img 
          src="<?php echo esc_url($img['url']); ?>" 
          alt="<?php echo esc_attr($img['alt']); ?>" 
          class="w-80 sm:w-[500px] md:w-[850px] lg:w-[900px] h-64 sm:h-80 md:h-[650px] lg:h-[700px] object-cover
                 rounded-tl-[20%] rounded-tr-[60%] rounded-br-[25%] rounded-bl-[50%] 
                 shadow-lg transition-all duration-500"
        />
      </div>
    <?php endif; ?>

    <!-- Tekst dichterbij foto -->
    <div class="flex flex-col justify-center mt-8 md:mt-0 md:-ml-28 lg:-ml-32 px-4 md:px-0">
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
