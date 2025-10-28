<?php 
$transport_tekst = get_field('transport_tekst');

if ( $transport_tekst && is_array($transport_tekst) ):
    $title = $transport_tekst['title'] ?? '';
    $cards = isset($transport_tekst['cards']) && is_array($transport_tekst['cards']) ? array_slice($transport_tekst['cards'], 0, 2) : array(); // max 2 kaarten
?>
<section class="bg-white text-black py-24">
  <div class="container mx-auto px-4 overflow-hidden"> <!-- voorkomt spill buiten container -->

    <?php if ( ! empty($title) ): ?>
      <h2 class="text-4xl md:text-5xl font-bold text-center mb-16 break-words hyphens-auto">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ( ! empty($cards) ): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 items-start">
        <?php foreach ( $cards as $index => $card ): 
          $card_title = $card['text'] ?? '';
          $card_body  = $card['text_area'] ?? ($card['text_erea'] ?? ($card['textarea'] ?? ''));
          if ( empty($card_title) && empty($card_body) ) continue;

          // Marges per kant voor wat balans
          $margin = $index % 2 === 0 ? 'md:pr-12' : 'md:pl-12';
        ?>
        <article class="max-w-2xl text-left <?php echo esc_attr($margin); ?> min-w-0 overflow-hidden"> <!-- min-w-0 is key in grid/flex -->
          <?php if ( ! empty($card_title) ): ?>
            <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-4 break-words hyphens-auto">
              <?php echo esc_html($card_title); ?>
            </h3>
          <?php endif; ?>
          <?php if ( ! empty($card_body) ): ?>
            <div class="text-gray-800 leading-relaxed text-base md:text-lg whitespace-normal break-words hyphens-auto">
              <?php echo wpautop( wp_kses_post( $card_body ) ); ?>
            </div>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center text-gray-500">Er zijn nog geen kaarten toegevoegd.</div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>
