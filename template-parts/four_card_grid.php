<?php 
$four_card_grid = get_field('four_card_grid');

if ( $four_card_grid && is_array($four_card_grid) ) :
    $title = $four_card_grid['title'] ?? '';         
    $cards = $four_card_grid['cards'] ?? []; 
?>
<section class="my-16">
  <div class="container mx-auto px-4 md:px-6 lg:px-8">

    <!-- Titel -->
    <?php if ($title): ?>
      <h2 class="text-center font-extrabold text-3xl md:text-4xl mb-10">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <!-- Kaarten -->
    <?php if ($cards && is_array($cards)) : ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php 
        $variants = [
          ['icon' => 'bg-blue-600',  'card' => 'bg-blue-50'],
          ['icon' => 'bg-green-600', 'card' => 'bg-green-50'],
          ['icon' => 'bg-amber-500', 'card' => 'bg-amber-50'],
          ['icon' => 'bg-teal-600',  'card' => 'bg-teal-50'],
        ];
        $i = 0;

        foreach ($cards as $card) :
          $v = $variants[$i % 4]; $i++;
          $card_title = $card['text'] ?? '';
          $card_text  = $card['text_area'] ?? '';
          $icon_class = $card['icon_class'] ?? '';
        ?>
          <article class="rounded-2xl p-8 md:p-10 shadow-inner ring-1 ring-black/5 transition-transform duration-300 hover:scale-[1.03] <?php echo esc_attr($v['card']); ?>">
            <div class="w-14 h-14 rounded-xl grid place-items-center mb-5 text-white <?php echo esc_attr($v['icon']); ?>">
              <?php if ($icon_class): ?>
                <i class="<?php echo esc_attr($icon_class); ?> text-2xl" aria-hidden="true"></i>
              <?php endif; ?>
            </div>

            <?php if ($card_title): ?>
              <h3 class="font-extrabold text-lg md:text-xl mb-3">
                <?php echo esc_html($card_title); ?>
              </h3>
            <?php endif; ?>

            <?php if ($card_text): ?>
              <p class="text-base md:text-lg leading-relaxed text-neutral-800">
                <?php echo wp_kses($card_text, ['br'=>[], 'strong'=>[], 'em'=>[]]); ?>
              </p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>
