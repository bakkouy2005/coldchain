<?php 
$sterke_punten = get_field('sterke_punten');

if( $sterke_punten ): 
    $title_parent    = $sterke_punten['titel'] ?? '';
    $img_parent      = $sterke_punten['img'] ?? null;
    $punten_herhaler = $sterke_punten['punten_herhaler'] ?? [];
?>
<section class="py-16 bg-white text-black relative">
  <div class="container mx-auto px-6 lg:px-8">

    <!-- Hoofdtitel (iets kleiner op iPad) -->
    <?php if($title_parent): ?>
      <h2 class="text-3xl sm:text-4xl md:text-4xl lg:text-4xl xl:text-5xl font-extrabold text-center mb-20 relative">
        <?php echo esc_html($title_parent); ?>
      </h2>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row items-start gap-12 lg:gap-20">

      <!-- Afbeelding links (groot op iPad/Air/Pro) -->
      <?php if($img_parent): ?>
        <div class="md:w-1/2 flex justify-center md:justify-end md:ml-8">
          <img src="<?php echo esc_url($img_parent['url']); ?>" 
               alt="<?php echo esc_attr($img_parent['alt']); ?>" 
               class="w-full 
                      max-w-[560px]
                      lg:max-w-[780px]   /* iPad mini / Air / Pro */
                      xl:max-w-[840px] 
                      2xl:max-w-[880px]
                      h-auto rounded-xl">
        </div>
      <?php endif; ?>

      <!-- Rechterkolom -->
      <?php if( $punten_herhaler ): ?>
        <div class="md:w-1/2 w-full relative">

          <!-- Iconen: verborgen op alle iPads, pas zichtbaar vanaf zeer brede desktops -->
          <div class="hidden 2xl:block 2xl:absolute 2xl:-top-2 2xl:left-[58%] 2xl:-translate-x-1/2">
            <div class="flex items-center gap-4 rounded-full bg-white/95 backdrop-blur-sm shadow-xl px-4 py-3">
              <!-- Warm -->
              <span class="inline-flex items-center justify-center rounded-full bg-white ring-2 ring-red-200 p-3.5">
                <i class="fa-solid fa-temperature-high text-red-500 text-4xl" aria-hidden="true"></i>
                <span class="sr-only">Hoge temperatuur</span>
              </span>
              <!-- Koud -->
              <span class="inline-flex items-center justify-center rounded-full bg-white ring-2 ring-sky-200 p-3.5">
                <i class="fa-solid fa-temperature-low text-sky-500 text-4xl" aria-hidden="true"></i>
                <span class="sr-only">Lage temperatuur</span>
              </span>
            </div>
          </div>

          <!-- Lijst -->
          <ul class="space-y-5 mt-2 md:mt-3 lg:mt-4 2xl:mt-6">
            <?php 
            $count = 0;
            foreach( $punten_herhaler as $item ): 
              if($count >= 5) break;
              $punt = $item['punten'] ?? '';
              if(!$punt) continue;
              $count++;
            ?>
              <li class="flex items-start gap-4">
                <!-- Groen check icoon -->
                <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-lg sm:text-xl leading-relaxed"><?php echo esc_html($punt); ?></p>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

    </div>

  </div>
</section>
<?php endif; ?>
