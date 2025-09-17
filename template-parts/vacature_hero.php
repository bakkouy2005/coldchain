<?php 
$vacature_hero = get_field('vacature_hero');

if( $vacature_hero ) :
    $img       = $vacature_hero['img'];         
    $text      = $vacature_hero['text'];       
    $text_area = $vacature_hero['text_area']; 
    $button    = $vacature_hero['button']; // hierin zit 'text' en 'url'
?>

<section class="relative bg-[#243866] overflow-hidden">
  <div class="container mx-auto relative z-10 px-6 md:px-12 py-16">
    <div class="max-w-3xl text-white space-y-8">

      <!-- Titel -->
      <?php if($text): ?>
        <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">
          <?php echo esc_html($text); ?>
        </h2>
      <?php endif; ?>

      <!-- Tekst met icoon netjes uitgelijnd -->
      <?php if($text_area): ?>
        <div class="flex items-start space-x-4 opacity-90">
          <!-- Icoon uitgelijnd met eerste regel van de tekst -->
          <i class="fa-solid fa-location-dot text-white text-2xl flex-shrink-0"></i>
          <div class="flex-1 text-base md:text-lg leading-relaxed">
            <?php echo wp_kses_post($text_area); ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- Professionele gradient-knop -->
      <?php if($button && $button['url'] && $button['text']): ?>
        <a href="<?php echo esc_url($button['url']); ?>" 
           class="inline-block bg-gradient-to-r from-[#FBBF24] to-[#F59E0B] text-[#243866] font-semibold px-8 py-4 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300">
          <?php echo esc_html($button['text']); ?>
        </a>
      <?php endif; ?>

    </div>
  </div>

  <!-- Afbeelding rechts tegen de rand -->
  <?php if($img): ?>
    <div class="absolute top-0 right-0 h-full hidden md:block">
      <img src="<?php echo esc_url($img['url']); ?>" 
           alt="<?php echo esc_attr($img['alt']); ?>" 
           class="h-full object-cover">
    </div>
  <?php endif; ?>
</section>

<?php 
endif; 
?>
