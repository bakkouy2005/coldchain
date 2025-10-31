<?php
$wagenpark = get_field('ons_wagenpark'); 
if( $wagenpark ):
    $title = $wagenpark['title'] ?? '';
    $vehicles = $wagenpark['voertuigen'] ?? [];
?>
<section class="bg-gray-50 py-24">
  <div class="container mx-auto px-6">

    <!-- Titel -->
    <?php if( $title ): ?>
      <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
          <?php echo esc_html($title); ?>
        </h2>
        <div class="mx-auto h-2 w-32 bg-[#0A131F] relative overflow-hidden rounded-full">
          <div class="absolute top-0 left-0 h-2 w-1/2 bg-[#0A131F] animate-slide"></div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Grid -->
    <?php if( $vehicles ): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php foreach( $vehicles as $vehicle ): 
          $img = $vehicle['img'] ?? null;
          $name = $vehicle['name'] ?? '';
          $type = $vehicle['type'] ?? '';
          $capacity = $vehicle['capacity'] ?? '';
          $dimensions = $vehicle['dimensions'] ?? '';
        ?>
        <div class="bg-white border border-gray-200 rounded-3xl shadow-lg overflow-hidden transform hover:scale-[1.03] hover:shadow-2xl transition-all duration-400">
          
          <!-- Afbeelding of fallback truck icoon -->
          <div class="relative overflow-hidden aspect-[4/3] bg-gray-100 flex items-center justify-center">
            <?php if( $img ): ?>
              <img 
                src="<?php echo esc_url($img['url']); ?>" 
                alt="<?php echo esc_attr($img['alt'] ?? $name); ?>" 
                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
              />
            <?php else: ?>
              <!-- Font Awesome vrachtwagen icoon -->
              <i class="fa-solid fa-truck text-gray-400 text-7xl hover:text-gray-500 transition-colors duration-300"></i>
            <?php endif; ?>
          </div>

          <!-- Content -->
          <div class="p-6 space-y-3">
            <?php if( $name ): ?>
              <h3 class="text-2xl font-semibold text-gray-900"><?php echo esc_html($name); ?></h3>
            <?php endif; ?>

            <div class="space-y-1 text-gray-700 text-sm">
              <?php if( $type ): ?>
                <p><span class="font-medium">Aantal pallets:</span> <?php echo esc_html($type); ?></p>
              <?php endif; ?>

              <?php if( $capacity ): ?>
                <p><span class="font-medium">Capaciteit:</span> <?php echo esc_html($capacity); ?></p>
              <?php endif; ?>

              <?php if( $dimensions ): ?>
                <p><span class="font-medium">Afmetingen:</span> <?php echo esc_html($dimensions); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- Animatie voor accentlijn -->
<style>
@keyframes slide {
  0% { transform: translateX(-100%); }
  50% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}
.animate-slide {
  animation: slide 2.5s linear infinite;
}
</style>

<!-- Voeg Font Awesome toe (bijv. in header.php of functions.php) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-QZKLe0RqvE0O+oVgAKvQWqFrh6vJpQv85q5T1v9s9tL+Q3Wl5qS2Aq5VHu/yWQhr9g5Fz2N9OxjPdrYk1XUQ4A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php endif; ?>
