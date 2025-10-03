<?php 
$services = get_field('services');
if( $services ): 
    $section_title = $services['section_title'];
    $cards = $services['cards'];
?>
<section class="py-12 sm:py-16 bg-[#1A1A1E] text-white text-center">
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
            <div class="bg-white text-black rounded-xl shadow p-4 sm:p-6 flex flex-col">
                <?php if($icon_class): ?>
                    <div class="text-blue-800 text-5xl mb-4">
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    </div>
                <?php endif; ?>

                <?php if($title): ?>
                    <h2 class="font-bold mb-2 sm:mb-3 text-xl sm:text-2xl lg:text-3xl"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if($desc): ?>
                    <p class="mb-4 sm:mb-6 flex-1 text-[#14141491] text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed"><?php echo esc_html($desc); ?></p>
                <?php endif; ?>

                <?php if($button && $button['text'] && $button['url']): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" 
                       class="mt-auto inline-block bg-blue-800 text-white px-3 py-2 sm:px-4 sm:py-2 rounded text-sm sm:text-base">
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
