<?php 
$overonstext = get_field('overonstext');

if ( $overonstext && is_array($overonstext) ):
    $cards = isset($overonstext['cards']) && is_array($overonstext['cards']) ? $overonstext['cards'] : array();
?>
<section class="bg-[#0A131F] text-white py-24">
  <div class="container mx-auto px-4">
    <?php if ( ! empty($cards) ): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 lg:gap-20">
        <?php foreach ( $cards as $card ): 
          $title = $card['text'] ?? '';
          $body  = $card['text_area'] ?? ($card['text_erea'] ?? ($card['textarea'] ?? ''));
          if ( empty($title) && empty($body) ) continue;
        ?>
        <article class="max-w-2xl text-left">
          <?php if ( ! empty($title) ): ?>
            <h3 class="text-2xl md:text-3xl font-semibold text-white mb-3">
              <?php echo esc_html($title); ?>
            </h3>
          <?php endif; ?>
          <?php if ( ! empty($body) ): ?>
            <div class="text-gray-300 leading-relaxed text-base md:text-lg">
              <?php echo wpautop( wp_kses_post( $body ) ); ?>
            </div>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center text-gray-400">Er zijn nog geen kaarten toegevoegd.</div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
