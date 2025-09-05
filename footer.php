<?php
wp_footer();
?>
<footer class="bg-zinc-900 text-zinc-300">
  <div class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
      <!-- Contact -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Contact</h3>
        <ul class="space-y-3">
          <li>Telefoonnummer <a href="tel:+311234567890" class="hover:text-white">012 345 678 90</a></li>
          <li>E-mail <a href="mailto:info@cold-chain.nl" class="hover:text-white">info@cold-chain.nl</a></li>
          <li><a href="#" class="hover:text-white">Facebook</a></li>
          <li><a href="#" class="hover:text-white">Instagram</a></li>
          <li class="pt-2 text-sm text-zinc-400">kvk123456789</li>
          <li class="text-sm text-zinc-400">BTW123456789</li>
        </ul>
      </div>

      <!-- Transport -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Transport</h3>
        <ul class="space-y-3">
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
          <li class="flex gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac1.jpg') ); ?>" alt="Vacature 1" class="w-16 h-16 rounded-lg object-cover">
            <div>
              <p class="text-white font-medium leading-tight">Vacature 1</p>
              <p class="text-sm text-zinc-400">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
          <li class="flex gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac2.jpg') ); ?>" alt="Vacature 2" class="w-16 h-16 rounded-lg object-cover">
            <div>
              <p class="text-white font-medium leading-tight">Vacature 2</p>
              <p class="text-sm text-zinc-400">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
          <li class="flex gap-4">
            <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/vac3.jpg') ); ?>" alt="Vacature 3" class="w-16 h-16 rounded-lg object-cover">
            <div>
              <p class="text-white font-medium leading-tight">Vacature 3</p>
              <p class="text-sm text-zinc-400">Nam, verum veriae repro ellam, volenihicid et,</p>
            </div>
          </li>
        </ul>
      </div>

      <!-- Nieuwsbrief -->
      <div>
        <h3 class="text-xl font-bold text-white mb-6">Nieuwsbrief</h3>
        <form action="#" method="post" class="flex gap-3">
          <label for="footer-email" class="sr-only">E-mail adres</label>
          <input
            id="footer-email"
            name="email"
            type="email"
            required
            placeholder="E-mail adres"
            class="flex-1 px-4 py-3 rounded-lg bg-white text-zinc-900 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-600"
          >
          <button
            type="submit"
            class="px-5 py-3 rounded-lg bg-blue-900 text-white font-medium hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600"
          >
            versturen
          </button>
        </form>
      </div>
    </div>

    <!-- Divider -->
    <hr class="border-zinc-700 mt-10 mb-6">

    <!-- Bottom bar -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/logo.svg') ); ?>" alt="<?php bloginfo('name'); ?> logo" class="h-8">
        <span class="sr-only"><?php bloginfo('name'); ?></span>
      </div>
      <p class="text-sm text-zinc-500">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>
</body>
</html>


</body>
</html>

