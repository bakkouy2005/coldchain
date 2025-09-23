<?php 
$vacature_info = get_field('vacature_info');
$max_words = 50; // aantal woorden zichtbaar voor "Lees meer"

if( $vacature_info ):
    $text = $vacature_info['text'] ?? '';
    $text_area = $vacature_info['text_area'] ?? '';
    $button = $vacature_info['button'] ?? '';
?>
<section class="relative bg-[#101E31] overflow-hidden">
  <div class="container mx-auto px-6 md:px-12 py-16">

    <!-- Subtiele lijn boven de content -->
    <div class="border-t border-gray-300 w-11/12 mx-0 mb-8"></div>

    <!-- Wrapper -->
    <div class="flex flex-col space-y-6">

      <!-- Titel -->
      <?php if( !empty($text) ): ?>
        <h2 class="text-2xl md:text-4xl font-extrabold text-[#CACFD6] leading-tight text-left">
          <?php echo esc_html($text); ?>
        </h2>
      <?php endif; ?>

      <!-- Tekst met lees meer/minder -->
      <?php if( !empty($text_area) ): ?>
        <?php 
        $words = explode(' ', wp_strip_all_tags($text_area));
        $short_text = implode(' ', array_slice($words, 0, $max_words));
        $is_truncated = count($words) > $max_words;
        ?>
        <div class="relative text-base md:text-lg text-[#CACFD6] leading-relaxed">
          <?php if ( $is_truncated ): ?>
            <!-- Korte tekst -->
            <div class="text-area-short">
              <?php echo wp_kses_post($short_text); ?>...
            </div>
            <!-- Volledige tekst -->
            <div class="text-area-full hidden">
              <?php echo wp_kses_post($text_area); ?>
            </div>
            <!-- Knop -->
            <button class="mt-2 text-blue-600 font-semibold hover:underline read-more-btn">
              Lees meer
            </button>
          <?php else: ?>
            <!-- Als de tekst kort is: toon direct alles zonder knop -->
            <div>
              <?php echo wp_kses_post($text_area); ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- Professionele gradient-knop -->
      <?php if( !empty($button) && !empty($button['url']) && !empty($button['text']) ): ?>
        <a href="<?php echo esc_url($button['url']); ?>" 
           class="inline-block bg-gradient-to-r from-[#FBBF24] to-[#F59E0B] text-[#243866] font-semibold px-8 py-4 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 w-max text-left">
          <?php echo esc_html($button['text']); ?>
        </a>
      <?php endif; ?>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.read-more-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
          const container = btn.parentElement;
          const shortText = container.querySelector('.text-area-short');
          const fullText = container.querySelector('.text-area-full');

          shortText.classList.toggle('hidden');
          fullText.classList.toggle('hidden');

          // Toggle knop tekst
          if (btn.innerText === "Lees meer") {
            btn.innerText = "Lees minder";
          } else {
            btn.innerText = "Lees meer";
          }
        });
      });
    });
  </script>
</section>
<?php endif; ?>
