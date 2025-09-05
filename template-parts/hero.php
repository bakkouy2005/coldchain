<?php
$hero = get_field('hero'); // Haal de hele group op
if( $hero ):
    $hero_img = $hero['hero_image'];
    $hero_title = $hero['hero_title'];
    $hero_subtitle = $hero['hero_subtitle'];
?>
    <section class="relative h-screen flex items-center justify-center text-center text-white "
        style="background-image:url('<?php echo esc_url($hero_img['url']); ?>'); background-size:cover; background-position:center;">
        
        <div class="bg-black/40 absolute inset-0"></div> <!-- overlay -->
        
        <div class="relative z-10 mb-12 sm:mb-16 lg:mb-20">
            <h1 class="font-bold font-family-impact text-[#E7E7E7] text-4xl sm:text-6xl md:text-7xl lg:text-8xl leading-tight"><?php echo esc_html($hero_title); ?></h1>
            <p class="mt-4 font-family-impact text-[#E7E7E7] text-base sm:text-lg md:text-xl lg:text-2xl max-w-3xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </section>
<?php endif; ?>
