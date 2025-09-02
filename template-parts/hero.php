<?php
$hero = get_field('hero'); // Haal de hele group op
if( $hero ):
    $hero_img = $hero['hero_image'];
    $hero_title = $hero['hero_title'];
    $hero_subtitle = $hero['hero_subtitle'];
?>
    <section class="relative h-screen flex items-center justify-center text-center text-white"
        style="background-image:url('<?php echo esc_url($hero_img['url']); ?>'); background-size:cover; background-position:center;">
        
        <div class="bg-black/40 absolute inset-0"></div> <!-- overlay -->
        
        <div class="relative z-10">
            <h1 class="text-5xl font-bold"><?php echo esc_html($hero_title); ?></h1>
            <p class="mt-4 text-xl"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </section>
<?php endif; ?>
