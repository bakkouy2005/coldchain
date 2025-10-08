<footer class="bg-[#0a131f] text-zinc-300">
  <div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10 lg:gap-12">

      <!-- Meer informatie -->
      <div>
        <h3 class="text-xl font-bold text-[#5AA3D5] mb-6">Meer informatie</h3>
        <?php
$info_pages = new WP_Query([
  'post_type'      => 'informatie',
  'posts_per_page' => -1,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);
if ($info_pages->have_posts()) :
  echo '<ul class="space-y-3 text-sm sm:text-base">';
  while ($info_pages->have_posts()) : $info_pages->the_post();
    echo '<li class="flex items-center group">
            <span class="text-[#5AA3D5] opacity-60 group-hover:opacity-100 transition-all duration-300 mr-2">→</span>
            <a href="' . get_permalink() . '" class="hover:text-[#5AA3D5] transition flex-1">' . get_the_title() . '</a>
          </li>';
  endwhile;
  echo '</ul>';
  wp_reset_postdata();
else :
  echo '<p class="text-zinc-500 text-sm">Geen informatiepagina’s beschikbaar.</p>';
endif;
        ?>
      </div>

      <!-- Navigatie -->
      <div>
        <h3 class="text-xl font-bold text-[#5AA3D5] mb-6">Navigatie</h3>
        <?php
          wp_nav_menu([
            'theme_location' => 'footer_navigation',
            'menu_class' => 'space-y-3 text-sm sm:text-base',
            'container' => false
          ]);
        ?>
      </div>

      <!-- Contact -->
      <div>
        <h3 class="text-xl font-bold text-[#5AA3D5] mb-6">Contactgegevens</h3>
        <p class="text-white font-semibold mb-2">Cool Runnings Transport BV</p>
        <p>Den Bulk 10<br>5126 PW Gilze</p>
        <p class="mt-4 font-semibold text-white">+31 (0)13 543 50 05</p>
        <p class="text-zinc-400">Bereikbaar op werkdagen van 08:00 tot 17:00</p>
        <div class="flex gap-3 mt-4">
          <a href="#" class="text-[#5AA3D5] hover:text-white"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="text-[#5AA3D5] hover:text-white"><i class="fab fa-facebook"></i></a>
        </div>
      </div>

    </div>

    <hr class="border-zinc-700 mt-10 mb-6">

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
      <div class="flex items-center gap-3">
        <img src="<?php echo esc_url( get_theme_file_uri('images/logo.svg') ); ?>" alt="<?php bloginfo('name'); ?> logo" class="h-8">
      </div>
      <p class="text-sm text-zinc-500">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Alle rechten voorbehouden.</p>
    </div>
  </div>
  <?php wp_footer(); ?>
</footer>
</body>
</html>
