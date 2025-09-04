<?php 
$services = get_field('services');
if( $services ): 
    $section_title = $services['section_title'];
    $cards = $services['cards'];
?>
<section class="py-16 bg-[#1A1A1E] text-white text-center">
    <?php if($section_title): ?>
        <h2 class="text-2xl font-bold mb-10"><?php echo esc_html($section_title); ?></h2>
    <?php endif; ?>

    <?php if($cards): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php foreach( $cards as $card ): 
                $icon_class = $card['icon_class'];
                $title = $card['title'];
                $desc = $card['description'];
                $button = $card['button'];
            ?>
            <div class="bg-white text-black rounded-xl shadow p-6 flex flex-col">
                <?php if($icon_class): ?>
                    <div class="text-blue-800 text-5xl mb-4">
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    </div>
                <?php endif; ?>

                <?php if($title): ?>
                    <h3 class="font-bold text-lg mb-2"><?php echo esc_html($title); ?></h3>
                <?php endif; ?>

                <?php if($desc): ?>
                    <p class="text-sm mb-4 flex-1 text-[#141414]"><?php echo esc_html($desc); ?></p>
                <?php endif; ?>

                <?php if($button && $button['text'] && $button['url']): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" 
                       class="mt-auto inline-block bg-blue-800 text-white px-4 py-2 rounded">
                        <?php echo esc_html($button['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php endif; ?>

