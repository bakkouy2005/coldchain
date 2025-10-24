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
                    <a href="' . esc_url(get_permalink()) . '" class="hover:text-[#5AA3D5] transition flex-1">' . esc_html(get_the_title()) . '</a>
                  </li>';
          endwhile;
          echo '</ul>';
          wp_reset_postdata();
        else :
          echo '<p class="text-zinc-500 text-sm">Geen informatiepagina’s beschikbaar.</p>';
        endif;
        ?>
      </div>

      <!-- Navigatie (zelfde stijl als Meer informatie) -->
      <div>
        <h3 class="text-xl font-bold text-[#5AA3D5] mb-6">Navigatie</h3>
        <?php
        $locations = get_nav_menu_locations();
        $menu_id   = isset($locations['primary']) ? (int) $locations['primary'] : 0;

        if ($menu_id) {
          $menu_items = wp_get_nav_menu_items($menu_id);
          if ($menu_items) {
            echo '<ul class="space-y-3 text-sm sm:text-base">';
            foreach ($menu_items as $item) {
              echo '<li class="flex items-center group">
                      <span class="text-[#5AA3D5] opacity-60 group-hover:opacity-100 transition-all duration-300 mr-2">→</span>
                      <a href="' . esc_url($item->url) . '" class="hover:text-[#5AA3D5] transition flex-1">' . esc_html($item->title) . '</a>
                    </li>';
            }
            echo '</ul>';
          } else {
            echo '<p class="text-zinc-500 text-sm">Geen menu-items gevonden.</p>';
          }
        } else {
          echo '<p class="text-zinc-500 text-sm">Geen menu aan de locatie “primary” gekoppeld.</p>';
        }
        ?>
      </div>

      <!-- Contact / Bedrijfsinformatie -->
      <div>
        <h3 class="text-xl font-bold text-[#5AA3D5] mb-6">Contactgegevens</h3>

        <p class="text-white font-semibold mb-2">Cold Chain Logistic Services B.V.</p>
        <p>Mississippidreef 4<br>3565 CG Utrecht</p>

        <p class="mt-4 font-semibold text-white">+31 (0)30 123 45 67</p>
        <p class="text-zinc-400">24/7 bereikbaar</p>

        <p class="mt-4 text-sm">
          <a href="mailto:info@coldchainlogisticservices.nl" class="block hover:text-[#5AA3D5] transition">info@coldchainlogisticservices.nl</a>
          
        </p>

       
      </div>

    </div>

    <hr class="border-zinc-700 mt-10 mb-6">

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
      <div class="flex items-center gap-3">
        <img
          src="<?php echo esc_url( get_theme_file_uri('images/logo.svg') ); ?>"
          alt="<?php echo esc_attr( get_bloginfo('name') ); ?> logo"
          class="h-8"
        >
      </div>
      <p class="text-sm text-zinc-500">&copy; <?php echo esc_html( date('Y') ); ?> <?php echo esc_html( get_bloginfo('name') ); ?>. Alle rechten voorbehouden.</p>
    </div>
  </div>
  <?php wp_footer(); ?>
</footer>
</body>
</html>
