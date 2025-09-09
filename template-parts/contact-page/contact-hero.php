<?php 
$hero = get_field('contact_hero');
if( $hero ):
    $title = $hero['hero_title'];
    $subtitle = $hero['hero_subtitle'];
    $image = $hero['hero_image'];
?>
<section class="relative z-10 bg-blue-900 text-white ">
  <div class="container mx-auto grid md:grid-cols-2 gap-8 items-center">
    <div class="">
      <h2 class="text-4xl font-extrabold mb-5"><?php echo esc_html($title); ?></h2>
      <p class="text-lg opacity-90"><?php echo esc_html($subtitle); ?></p>
    </div>
    <?php if($image): ?>
    <div class="relative">
      <img class="rounded-lg shadow-lg " src="<?php echo esc_url($image['url']); ?>" alt="">
    </div>
    <?php endif; ?>
  </div>
</section>

<?php endif; ?>
