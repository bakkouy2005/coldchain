<?php
$hero = get_field('hero'); // Haal de hele group op
if( $hero ):
    $hero_img = $hero['hero_image'];
    $hero_title = $hero['hero_title'];
    $hero_subtitle = $hero['hero_subtitle'];
?>
    <section class="relative min-h-[65vh] md:min-h-[70vh] lg:min-h-[75vh] flex items-center justify-center text-center text-white "
        style="background-image:url('<?php echo esc_url($hero_img['url']); ?>'); background-size:cover; background-position:center;">
        
        <div class="bg-black/40 absolute inset-0"></div> <!-- overlay -->
        
        <div class="relative z-10 mb-10 sm:mb-14 lg:mb-16">
            <h1 class="font-bold font-family-impact text-[#E7E7E7] break-words leading-tight text-xl sm:text-4xl md:text-6xl lg:text-8xl tracking-wide sm:tracking-wider lg:tracking-widest"><?php echo esc_html($hero_title); ?></h1>
            <p class="mt-2 font-family-impact text-[#E7E7E7] leading-snug text-base sm:text-xl md:text-3xl lg:text-4xl max-w-4xl mx-auto tracking-normal sm:tracking-wide md:tracking-wider"><?php echo esc_html($hero_subtitle); ?></p>
        </div>
    </section>
<?php endif; ?>
