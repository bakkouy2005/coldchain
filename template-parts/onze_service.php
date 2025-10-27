<?php 
$onze_service = get_field('onze_service');

if ( $onze_service && is_array($onze_service) ):
    $title  = $onze_service['title'] ?? '';
    $cards  = isset($onze_service['cards']) && is_array($onze_service['cards']) ? array_slice($onze_service['cards'], 0, 2) : array();
    $button = isset($onze_service['button']) && is_array($onze_service['button']) ? $onze_service['button'] : array();
    $btn_label = $button['text'] ?? '';
    $btn_url   = $button['url'] ?? '';
?>
<section class="bg-[#0A131F] text-white py-24">
  <div class="container mx-auto px-6 lg:px-12">
    
    <?php if ( ! empty($title) ): ?>
      <h2 class="text-4xl md:text-5xl font-bold text-center mb-16">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ( ! empty($cards) ): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 items-start">
        <?php foreach ( $cards as $index => $card ): 
          $card_title = $card['text'] ?? '';
          $card_body  = $card['text_area'] ?? ($card['text_erea'] ?? ($card['textarea'] ?? ''));
          if ( empty($card_title) && empty($card_body) ) continue;
        ?>
        <article class="max-w-2xl text-left">
          <?php if ( ! empty($card_title) ): ?>
            <h3 class="text-2xl md:text-3xl font-semibold mb-4 text-white">
              <?php echo esc_html($card_title); ?>
            </h3>
          <?php endif; ?>
          <?php if ( ! empty($card_body) ): ?>
            <div class="text-gray-300 leading-relaxed text-base md:text-lg">
              <?php echo wpautop( wp_kses_post( $card_body ) ); ?>
            </div>
          <?php endif; ?>

          <?php if ( $index === 1 && ! empty($btn_label) && ! empty($btn_url) ): ?>
            <div class="mt-8">
              <a href="<?php echo esc_url($btn_url); ?>" 
                 class="inline-block bg-[#243866] hover:bg-[#2f4da1] transition-colors duration-300 text-white font-medium px-6 py-3 rounded-full text-base md:text-lg shadow-md hover:shadow-lg">
                 <?php echo esc_html($btn_label); ?>
              </a>
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
