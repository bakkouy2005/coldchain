<?php 
$overons = get_field('overons');

if( $overons ) :
    $img       = $overons['img'];         
    $text      = $overons['text'];       
    $text_area = $overons['text_area']; 
?>
<section 
    class="w-full min-h-[400px] sm:min-h-[500px] md:min-h-[650px] bg-center bg-cover bg-no-repeat relative flex items-center"
    style="background-image: url('<?php echo esc_url($img['url']); ?>');"
>
    <!-- Overlay voor betere leesbaarheid -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- Tekst netjes binnen de wrapper -->
    <div class="relative container mx-auto px-5 py-12 text-left">
        <?php if ($text) : ?>
            <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-4 text-gray-100">
                <?php echo esc_html($text); ?>
            </h1>
        <?php endif; ?>

        <?php if ($text_area) : ?>
            <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-200 max-w-3xl">
                <?php echo esc_html($text_area); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
