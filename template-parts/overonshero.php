<?php 
$overons = get_field('overons');

if( $overons ) :
    $img       = $overons['img'];         
    $text      = $overons['text'];       
    $text_area = $overons['text_area']; 
?>
<section 
    class="w-full h-[650px] bg-center bg-cover bg-no-repeat relative"
    style="background-image: url('<?php echo esc_url($img['url']); ?>');"
>
    <!-- Overlay voor betere leesbaarheid -->
    <div class="absolute inset-0 bg-black/25"></div>

    <!-- Tekst netjes binnen de wrapper -->
    <div class="relative flex items-center h-full">
        <div class="container mx-auto text-left pl-5">
            <?php if ($text) : ?>
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-bold mb-4 text-gray-100">
                    <?php echo esc_html($text); ?>
                </h1>
            <?php endif; ?>

            <?php if ($text_area) : ?>
                <p class="text-xl sm:text-2xl md:text-3xl text-gray-200">
                    <?php echo esc_html($text_area); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
