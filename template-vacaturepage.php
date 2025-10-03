<?php
/* Template Name: vacatures_overzicht */
get_header();



// Load selected vacature by ID from query string
$vacature_id = isset($_GET['id']) ? absint($_GET['id']) : 0;
$vacature_post = $vacature_id ? get_post($vacature_id) : null;

// Validate post existence and type
if (!$vacature_post || 'vacature' !== get_post_type($vacature_post)) {
  // Option A: show 404
  status_header(404);
  nocache_headers();
  include get_query_template('404');
  exit;
}

// Prepare global $post so ACF get_field() and template tags read from this vacature
setup_postdata($vacature_post);
?>

<div class="">
    <?php 
    // ===== Hero from plugin fields only =====
    $img = get_field('img', $vacature_post->ID);
    $text = get_field('text', $vacature_post->ID);
    $location = '';
    $plugin_location = get_field('location', $vacature_post->ID);
    if (empty($plugin_location)) { $plugin_location = get_field('locatie', $vacature_post->ID); }
    if (!empty($plugin_location)) {
      if (is_array($plugin_location)) {
        if (!empty($plugin_location['address'])) { $location = $plugin_location['address']; }
        elseif (!empty($plugin_location['label'])) { $location = $plugin_location['label']; }
        else {
          $parts = array_filter(array_map(function($v){ return is_string($v) ? trim($v) : ''; }, $plugin_location));
          $location = implode(', ', $parts);
        }
      } else { $location = $plugin_location; }
    }
    $resolved_url = '';
    $plugin_button = get_field('button', $vacature_post->ID);
    $plugin_button_url = get_field('button_url', $vacature_post->ID);
    if (!empty($plugin_button_url) && is_string($plugin_button_url)) { $resolved_url = $plugin_button_url; }
    elseif (is_array($plugin_button) && !empty($plugin_button['url'])) { $resolved_url = $plugin_button['url']; }
    elseif (is_string($plugin_button)) { $resolved_url = $plugin_button; }
    $has_hero = !empty($img) || !empty($text) || !empty($location) || !empty($resolved_url);
    if ($has_hero) :
    ?>
    <section class="relative bg-[#0A131F] overflow-hidden ">
      <div class="container mx-auto relative z-10 px-6 md:px-12 py-16">
        <div class="w-full md:w-1/2">
          <div class="max-w-full sm:max-w-xl md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-white space-y-8 pr-4 sm:pr-8 md:pr-12 lg:pr-16 xl:pr-20">
            <?php if($text): ?>
              <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight"><?php echo esc_html($text); ?></h2>
            <?php endif; ?>
            <?php if($location): ?>
              <div class="flex items-start space-x-4 opacity-90">
                <i class="fa-solid fa-location-dot text-white text-2xl flex-shrink-0"></i>
                <div class="flex-1 text-base md:text-lg leading-relaxed"><?php echo wp_kses_post($location); ?></div>
              </div>
            <?php endif; ?>
            <?php if($resolved_url): ?>
              <a href="<?php echo site_url('/solicitatie-formulier?id=' . $vacature_post->ID); ?>"
     class="inline-block bg-gradient-to-r from-[#FBBF24] to-[#F59E0B] text-[#243866] font-semibold px-8 py-4 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300">
     Solliciteer nu
  </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php if(!empty($img) && !empty($img['url'])): ?>
        <!-- Mobile/Tablet image -->
        <div class="block md:hidden mt-6">
          <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-56 sm:h-64 object-cover rounded-lg">
        </div>
      <?php endif; ?>
      <?php if(!empty($img) && !empty($img['url'])): ?>
        <div class="absolute top-0 right-0 h-full hidden md:block md:w-2/5 lg:w-[550px] xl:w-[650px]">
          <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-full object-cover">
        </div>
      <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php 
    // ===== Inlined from template-parts/vacature_text.php =====
    // Read fields directly from the vacature plugin (top-level fields)
    $text1 = get_field('text1', $vacature_post->ID);
    $repeater1 = get_field('repeater1', $vacature_post->ID);
    $text2 = get_field('text2', $vacature_post->ID);
    $repeater2 = get_field('repeater2', $vacature_post->ID);

        // Normalize repeater item keys so they render even if plugin uses different names
    if (is_array($repeater1)) {
      $repeater1 = array_values(array_filter(array_map(function($row){
        if (!is_array($row)) return null;
        $textVal = isset($row['item']) ? trim((string)$row['item']) : '';
        if ($textVal === '') return null;
        return array('text_area1' => $textVal, 'icon_class' => '');
      }, $repeater1)));
    }
    if (is_array($repeater2)) {
      $repeater2 = array_values(array_filter(array_map(function($row){
        if (!is_array($row)) return null;
        $textVal = isset($row['item']) ? trim((string)$row['item']) : '';
        if ($textVal === '') return null;
        return array('text_area2' => $textVal, 'icon_class' => '');
      }, $repeater2)));
    }

    $__has_text_section = !empty($text1) || (!empty($repeater1) && is_array($repeater1)) || !empty($text2) || (!empty($repeater2) && is_array($repeater2));
    if ($__has_text_section): ?>
    <section class="relative bg-[#101E31] overflow-hidden">
      <div class="container mx-auto px-6 md:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16">
          <div>
            <?php if( !empty($text1) ): ?>
              <h3 class="text-center md:text-left text-2xl md:text-3xl font-bold text-white mb-6 md:mb-8"><?php echo esc_html($text1); ?></h3>
            <?php endif; ?>
            <?php if( !empty($repeater1) && is_array($repeater1) ): ?>
              <div class="space-y-3 md:space-y-4">
                <?php foreach( $repeater1 as $item ): 
                  $text_area1 = $item['text_area1'] ?? '';
                  if(empty($text_area1)) continue;
                ?>
                  <p class="text-[#CACFD6] text-base md:text-lg leading-relaxed"><?php echo wp_kses_post($text_area1); ?></p>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <?php if( !empty($text2) ): ?>
              <h3 class="text-center md:text-left text-2xl md:text-3xl font-bold text-white mb-6 md:mb-8"><?php echo esc_html($text2); ?></h3>
            <?php endif; ?>
            <?php if( !empty($repeater2) && is_array($repeater2) ): ?>
              <div class="space-y-3 md:space-y-4">
                <?php foreach( $repeater2 as $item ): 
                  $text_area2 = $item['text_area2'] ?? '';
                  if(empty($text_area2)) continue;
                ?>
                  <p class="text-[#CACFD6] text-base md:text-lg leading-relaxed"><?php echo wp_kses_post($text_area2); ?></p>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php 
    // ===== Inlined from template-parts/vacature_info.php =====
    
    $text_area = get_field('text_area', $vacature_post->ID);
    $button = get_field('button', $vacature_post->ID);
    $max_words = 50;

    $__has_info_section = !empty($text) || !empty($text_area) || !empty($button);
    if ($__has_info_section):
    ?>

    <section class="relative bg-[#101E31] overflow-hidden">
      <div class="container mx-auto px-6 md:px-12 py-16">
        <div class="border-t border-gray-300 w-11/12 mx-0 mb-8"></div>
        <div class="flex flex-col space-y-6">
         
            <h2 class="text-2xl md:text-4xl font-extrabold text-[#CACFD6] leading-tight text-left">Vacature informatie</h2>
          
          <?php if( !empty($text_area) ): ?>
            <?php 
              $words = explode(' ', wp_strip_all_tags($text_area));
              $short_text = implode(' ', array_slice($words, 0, $max_words));
              $is_truncated = count($words) > $max_words;
            ?>
            <div class="relative text-base md:text-lg text-[#CACFD6] leading-relaxed">
              <?php if ( $is_truncated ): ?>
                <div class="text-area-short"><?php echo wp_kses_post($short_text); ?>...</div>
                <div class="text-area-full hidden"><?php echo wp_kses_post($text_area); ?></div>
                <button class="mt-2 text-blue-600 font-semibold hover:underline read-more-btn">Lees meer</button>
              <?php else: ?>
                <div><?php echo wp_kses_post($text_area); ?></div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if( !empty($button) && !empty($button['url']) ): ?>
            <a href="<?php echo esc_url($button['url']); ?>" class="inline-block bg-gradient-to-r from-[#FBBF24] to-[#F59E0B] text-[#243866] font-semibold px-8 py-4 rounded-xl shadow-lg hover:scale-105 transition-transform duration-300 w-max text-left">Soliciteer nu</a>
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
              btn.innerText = btn.innerText === 'Lees meer' ? 'Lees minder' : 'Lees meer';
            });
          });
        });
      </script>
    </section>

    <?php endif; ?>
    <?php get_template_part('template-parts/vacatures'); ?>
  </div>

<?php
// Reset global post
wp_reset_postdata();
get_footer();

?>