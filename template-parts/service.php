<?php 
$services = get_field('services');
if( $services ): 
    $section_title = $services['section_title'];
    $cards = $services['cards'];
?>
<section class="py-12 sm:py-16 bg-[#0a131f] text-white text-center">
  <div class="container mx-auto px-4">
    <?php if($section_title): ?>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 sm:mb-10"><?php echo esc_html($section_title); ?></h2>
    <?php endif; ?>

    <?php if($cards): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php foreach( $cards as $card ): 
                $icon_class = $card['icon_class'];
                $title = $card['title'];
                $desc = $card['description'];
                $button = $card['button'];
            ?>
            <div class="relative overflow-hidden bg-white text-black rounded-xl shadow p-6 sm:p-8 flex flex-col min-h-[280px] text-left -m-[1px]">
                <!-- Blauwe diagonale strook rechts -->
                <div aria-hidden="true" class="pointer-events-none absolute top-[-5rem] bottom-[-5rem] right-[-5rem] w-56 bg-[#166ADF] skew-x-[-18deg]"></div>

                <!-- Icoon in de blauwe strook -->
                <?php if($icon_class): ?>
                    <div class="absolute right-6 top-6 text-white/95 text-4xl sm:text-5xl rotate-[-15deg] drop-shadow">
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    </div>
                <?php endif; ?>

                <!-- Inhoud links -->
                <?php if($title): ?>
                    <h3 class="font-bold text-[22px] sm:text-2xl leading-tight mb-3 sm:mb-4 pr-20">
                        <?php echo esc_html($title); ?>
                    </h3>
                <?php endif; ?>

                <?php if($desc): ?>
                    <p class="text-[#141414]/80 text-[15px] sm:text-base leading-[1.7] mb-6 pr-24 max-w-[42ch]">
                        <?php echo esc_html($desc); ?>
                    </p>
                <?php endif; ?>

                <?php if($button && !empty($button['text']) && !empty($button['url'])): ?>
                    <a href="<?php echo esc_url($button['url']); ?>"
                       class="inline-block self-start bg-[#166ADF] text-white font-semibold rounded-md px-5 py-3 text-sm sm:text-base shadow hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-[#5AA3D5] focus:ring-offset-2 focus:ring-offset-white transition">
                        <?php echo esc_html($button['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
