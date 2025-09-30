<?php
// Vacatures query
$args = array(
  'post_type'      => 'vacature',
  'posts_per_page' => 8,
  'orderby'        => 'date',
  'order'          => 'DESC',
);
$vacatures = new WP_Query($args);

if ($vacatures->have_posts()) :
  $is_slider = $vacatures->post_count > 3; // slider alleen bij meer dan 3
?>
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-center mb-12 text-gray-700">
      Vacatures
    </h2>

    <?php if ($is_slider): ?>
      <!-- SLIDER -->
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php while ($vacatures->have_posts()) : $vacatures->the_post(); ?>
            <?php
              $img       = get_field('img');
              $text      = get_field('text');
              $text_area = get_field('text_area');
              $button    = get_field('button');
            ?>
            <div class="swiper-slide py-3">
              <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-[600px]">
                <?php if ($img) : ?>
                  <div class="h-48 w-full overflow-hidden">
                    <img src="<?php echo esc_url($img['url']); ?>" 
                         alt="<?php echo esc_attr($img['alt']); ?>" 
                         class="w-full h-full object-cover">
                  </div>
                <?php endif; ?>

                <div class="p-6 flex flex-col flex-grow">
                  <?php if ($text) : ?>
                    <h3 class="text-xl font-semibold mb-3"><?php echo esc_html($text); ?></h3>
                  <?php endif; ?>

                  <?php if ($text_area) : ?>
                    <p class="text-gray-600 mb-6 flex-grow line-clamp-5 overflow-hidden text-ellipsis">
                      <?php echo esc_html( wp_trim_words( $text_area, 30, '...' ) ); ?>
                    </p>
                  <?php endif; ?>

                  <?php if ($button) : ?>
                    <a href="<?php echo site_url('/vacatures-pagina?id=' . get_the_ID()); ?>"
   class="mt-auto inline-block bg-blue-900 text-white font-medium px-5 py-3 rounded-lg shadow hover:bg-blue-800 transition duration-300 ease-in-out">
   Bekijk vacature
</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <!-- Navigatie -->
        <div class="swiper-pagination mt-6"></div>
        <div class="swiper-button-prev w-12 h-12 rounded-full bg-black/80 hover:bg-black text-white flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-arrow-left"></i>
        </div>
        <div class="swiper-button-next w-12 h-12 rounded-full bg-black/80 hover:bg-black text-white flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-arrow-right"></i>
        </div>
        <style>.swiper-button-prev::after, .swiper-button-next::after { content: '' !important; }</style>
      </div>

      <script>
        (function(){
          function loadScript(src){
            return new Promise(function(resolve){
              var s=document.createElement('script'); s.src=src; s.async=true; s.onload=resolve; document.head.appendChild(s);
            });
          }
          function loadCss(href){
            return new Promise(function(resolve){
              if (document.querySelector('link[href*="swiper-bundle.min.css"]')) return resolve();
              var l=document.createElement('link'); l.rel='stylesheet'; l.href=href; l.onload=resolve; document.head.appendChild(l);
            });
          }
          function init(){
            if (!window.Swiper) return;
            document.querySelectorAll('.swiper').forEach(function(el){
              if (el.__inited) return; el.__inited = true;
              new Swiper(el, {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 24,
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
                navigation: { nextEl: el.querySelector('.swiper-button-next'), prevEl: el.querySelector('.swiper-button-prev') },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
              });
            });
          }
          (async function(){
            if (!window.Swiper) {
              await loadCss('https://unpkg.com/swiper@9/swiper-bundle.min.css');
              await loadScript('https://unpkg.com/swiper@9/swiper-bundle.min.js');
            }
            init();
          })();
        })();
      </script>

    <?php else: ?>
      <!-- GRID -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
        <?php while ($vacatures->have_posts()) : $vacatures->the_post(); ?>
          <?php
            $img       = get_field('img');
            $text      = get_field('text');
            $text_area = get_field('text_area');
            $button    = get_field('button');
          ?>
          <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-[600px]">
            <?php if ($img) : ?>
              <div class="h-48 w-full overflow-hidden">
                <img src="<?php echo esc_url($img['url']); ?>" 
                     alt="<?php echo esc_attr($img['alt']); ?>" 
                     class="w-full h-full object-cover">
              </div>
            <?php endif; ?>

            <div class="p-6 flex flex-col flex-grow">
              <?php if ($text) : ?>
                <h3 class="text-xl font-semibold mb-3"><?php echo esc_html($text); ?></h3>
              <?php endif; ?>

              <?php if ($text_area) : ?>
                <p class="text-gray-600 mb-6 flex-grow line-clamp-5 overflow-hidden text-ellipsis">
                  <?php echo esc_html( wp_trim_words( $text_area, 30, '...' ) ); ?>
                </p>
              <?php endif; ?>

              <?php if ($button) : ?>
                <a href="<?php echo esc_url($button['url']); ?>"
                   target="<?php echo esc_attr($button['target']); ?>"
                   class="mt-auto inline-block bg-blue-900 text-white font-medium px-5 py-3 rounded-lg shadow hover:bg-blue-800 transition duration-300 ease-in-out">
                  <?php echo esc_html($button['title']); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; wp_reset_postdata(); ?>