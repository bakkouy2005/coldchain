<?php 
$cards = get_field('contact_cards');
if( $cards && isset($cards['cards']) && is_array($cards['cards']) ): ?>
<section class="relative bg-gray-100 z-50 py-8 overflow-x-hidden -mt-4 sm:-mt-10 md:-mt-16 lg:-mt-24">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mt-0 sm:-mt-16 md:-mt-24 lg:-mt-32 justify-items-center md:justify-items-stretch">
        <?php foreach($cards['cards'] as $card): 
            $icon = $card['icon_class'];
            $title = $card['card_title'];
            $desc = $card['card_description'];
            $button = $card['card_button'];
        ?>
        <div class="bg-white shadow-lg rounded-lg p-5 sm:p-6 text-center w-full max-w-sm sm:max-w-md md:max-w-none mx-auto">
            <?php if($icon): ?>
                <div class="text-4xl text-blue-600 mb-4">
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                </div>
            <?php endif; ?>

            <div class="mx-auto max-w-xs sm:max-w-sm space-y-3">
            <?php if($title): ?>
                <h3 class="text-xl font-bold"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php if($desc): ?>
                <p class="text-base sm:text-[1rem] leading-relaxed opacity-90"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>

            <?php if($button && $button['button_text'] && $button['button_url']): ?>
                <a href="<?php echo esc_url($button['button_url']); ?>" 
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded">
                   <?php echo esc_html($button['button_text']); ?>
                </a>
            <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
