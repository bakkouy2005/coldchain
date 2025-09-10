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
          <li class="flex gap-3 sm:gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac1.jpg') ); ?>" alt="Vacature 1" class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover flex-shrink-0">
            <div>
              <p class="text-white font-medium leading-tight text-sm sm:text-base">Vacature 1</p>
              <p class="text-zinc-400 text-xs sm:text-sm">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
          <li class="flex gap-3 sm:gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac2.jpg') ); ?>" alt="Vacature 2" class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover flex-shrink-0">
            <div>
              <p class="text-white font-medium leading-tight text-sm sm:text-base">Vacature 2</p>
              <p class="text-zinc-400 text-xs sm:text-sm">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
          <li class="flex gap-3 sm:gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac3.jpg') ); ?>" alt="Vacature 3" class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover flex-shrink-0">
            <div>
              <p class="text-white font-medium leading-tight text-sm sm:text-base">Vacature 3</p>
              <p class="text-zinc-400 text-xs sm:text-sm">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
        </ul>
      </div>

      <!-- Nieuwsbrief -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Nieuwsbrief</h3>
        <form action="#" method="post" class="flex flex-col sm:flex-row sm:flex-wrap gap-3">
          <label for="footer-email" class="sr-only">E-mail adres</label>
          <input
            id="footer-email"
            name="email"
            type="email"
            required
            placeholder="E-mail adres"
            class="flex-1 min-w-0 px-4 py-3 rounded-lg bg-white text-zinc-900 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm sm:text-base"
          >
          <button
            type="submit"
            class="flex-shrink-0 px-5 py-3 rounded-lg bg-blue-900 text-white font-medium hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm sm:text-base"
          >
            Versturen
          </button>
        </form>
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
