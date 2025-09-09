<?php 
$overonstext = get_field('overonstext');

if ( $overonstext && is_array($overonstext) ):
    $cards = isset($overonstext['cards']) && is_array($overonstext['cards']) ? $overonstext['cards'] : array();
?>
<section class="bg-white text-black overflow-hidden py-16">
    <div class="container mx-auto px-4">
        <?php if ( ! empty($cards) ): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 lg:gap-20">
            <?php $index = 0; foreach ( $cards as $card ): 
                $title = isset($card['text']) ? $card['text'] : '';
                $body  = isset($card['text_area']) ? $card['text_area'] : ( isset($card['text_erea']) ? $card['text_erea'] : ( isset($card['textarea']) ? $card['textarea'] : '' ) );
                if ( empty($title) && empty($body) ) { continue; }
                $article_classes = 'p-0 max-w-2xl';
                if ( $index === 1 ) {
                    $article_classes .= ' md:pl-10 lg:pl-16';
                }
            ?>
            <article class="<?php echo esc_attr($article_classes); ?>">
                <?php if ( ! empty($title) ): ?>
                <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-3">
                    <?php echo esc_html($title); ?>
                </h3>
                <?php endif; ?>
                <?php if ( ! empty($body) ): ?>
                <div class="text-gray-800 leading-relaxed text-base md:text-[15px]">
                    <?php echo wpautop( wp_kses_post( $body ) ); ?>
                </div>
                <?php endif; ?>
            </article>
            <?php $index++; endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center text-gray-500">Er zijn nog geen kaarten toegevoegd.</div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
