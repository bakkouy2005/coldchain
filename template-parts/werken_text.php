<?php 
$werken_text = get_field('werken_text');

if ( $werken_text && is_array($werken_text) ) :
    $img       = $werken_text['img'] ?? null;        
    $text      = $werken_text['text'] ?? '';
    $text_area = $werken_text['text_area'] ?? '';
    $cards     = $werken_text['cards'];
?>
<section class="bg-white text-black py-16 md:py-24">
  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

    <!-- Tekst links -->
    <div>
      <?php if ($text) : ?>
        <h2 class="text-2xl md:text-3xl font-bold mb-4">
          <?php echo esc_html($text); ?>
        </h2>
      <?php endif; ?>

      <?php if ($text_area) : ?>
        <div class="text-gray-800 leading-relaxed text-base md:text-lg">
          <?php echo wpautop( wp_kses_post($text_area) ); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Cards rechts -->
    <?php if ($cards) : ?>
      <!-- houdt 2 kolommen vanaf tablet/laptop; pas gerust aan naar jouw wens -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-2">
        <?php foreach ($cards as $card) : ?>
          <?php if (!empty($card['text'])) : ?>
            <!-- min-w-0 is essentieel om wrappen toe te laten in flex-context -->
            <div class="flex items-center gap-3 min-w-0 transition-all duration-300 ease-in-out">
              <i class="fa-solid fa-check text-green-600 flex-none"></i>
              <!-- Tablet (sm/md): forceer woordbreking; Laptop/Desktop (lg+): weer normaal -->
              <p class="w-full max-w-full min-w-0 text-lg md:text-xl text-gray-900 font-medium break-words">
                <?php echo esc_html($card['text']); ?>
              </p>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>
