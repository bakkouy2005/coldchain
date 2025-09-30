<footer class="bg-zinc-900 text-zinc-300">
  <div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 lg:gap-12">
      
      <!-- Contact -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Contact</h3>
        <ul class="space-y-3 text-sm sm:text-base">
          <li>Telefoonnummer <a href="tel:+311234567890" class="hover:text-white">012 345 678 90</a></li>
          <li>E-mail <a href="mailto:info@cold-chain.nl" class="hover:text-white">info@cold-chain.nl</a></li>
          <li><a href="#" class="hover:text-white">Facebook</a></li>
          <li><a href="#" class="hover:text-white">Instagram</a></li>
          <li class="pt-2 text-zinc-400">kvk123456789</li>
          <li class="text-zinc-400">BTW123456789</li>
        </ul>
      </div>

      <!-- Transport -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Transport</h3>
        <ul class="space-y-3 text-sm sm:text-base">
          <li>Koeling</li>
          <li>Vries</li>
          <li>Diepvries</li>
          <li>Aangepaste wensen</li>
        </ul>
      </div>

      <!-- Vacatures -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Vacatures</h3>
        <ul class="space-y-5">
        <?php
  $vacatures = new WP_Query(array(
    'post_type' => 'vacature', // aangepast naar jouw plugin post type
    'posts_per_page' => 3
  ));
  if ($vacatures->have_posts()) :
    while ($vacatures->have_posts()) : $vacatures->the_post();
?>
  <li class="flex gap-3 sm:gap-4">
  <?php 
$img = get_field('img'); 
if ($img) : ?>
  <img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>" 
       alt="<?php echo esc_attr($img['alt']); ?>" 
       class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover flex-shrink-0">
<?php endif; ?>
    <div>
      <p class="text-white font-medium leading-tight text-sm sm:text-base"><?php the_title(); ?></p>
      <p class="text-zinc-400 text-xs sm:text-sm"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
    </div>
  </li>
<?php
    endwhile;
    wp_reset_postdata();
  else :
    echo '<li class="text-zinc-400">Geen vacatures beschikbaar</li>';
  endif;
?>
        </ul>
      </div>

      <!-- Nieuwsbrief -->

        <div>
         <h3 class="text-xl font-bold text-white mb-6">Nieuwsbrief</h3>
         <div class="flex flex-col md:block lg:flex gap-3"> <!-- block alleen bij md (iPad) -->
         <form action="#" method="post" class="flex-1">
         <label for="footer-email" class="sr-only">E-mail adres</label>
          <input
          id="footer-email"
          name="email"
          type="email"
          required
          placeholder="E-mail adres"
        class="w-full px-4 py-3 rounded-lg bg-white text-zinc-900 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm sm:text-base"
      >
    </form>
         <button
            type="submit"
            form="footer-email"
             class="w-full mt-2 md:mt-0 lg:w-auto px-5 py-3 rounded-lg bg-blue-900 text-white font-medium hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm sm:text-base"
             >
             Versturen
         </button>
       </div>
     </div>



    </div>

    <!-- Divider -->
    <hr class="border-zinc-700 mt-10 mb-6">

    <!-- Bottom bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
      <div class="flex items-center gap-3">
        <img src="<?php echo esc_url( get_theme_file_uri('images/logo.svg') ); ?>" alt="<?php bloginfo('name'); ?> logo" class="h-8">
        <span class="sr-only"><?php bloginfo('name'); ?></span>
      </div>
      <p class="text-sm text-zinc-500">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>
</body>
</html>
