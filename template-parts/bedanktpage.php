<?php 
$bedankt_pagina = get_field('bedankt_pagina');

if ( $bedankt_pagina && is_array($bedankt_pagina) ) :
    $img        = $bedankt_pagina['img'] ?? null;         
    $text       = $bedankt_pagina['text'] ?? '';       
    $text_area  = $bedankt_pagina['text_area'] ?? ''; 
    $text_area2 = $bedankt_pagina['text_area2'] ?? ''; 
?>
<section 
    class="w-full h-[650px] bg-center bg-cover relative"
    style="background-image: url('<?php echo esc_url($img['url'] ?? ''); ?>');"
>
    <!-- Blauwe overlay -->
    <div class="absolute inset-y-0 left-0 w-full md:w-1/2 z-10 pointer-events-none"
         style="background-color: rgba(2, 77, 146, 0.27);"></div>

    <!-- Content wrapper -->
    <div class="relative z-20 flex items-center h-full">
        <div class="container mx-auto px-4 md:px-6 lg:px-8 flex flex-col justify-center h-full">

            <!-- TITEL -->
            <?php if ($text) : ?>
                <h1 class="font-bold mb-2 text-white leading-tight max-w-full 
                           ml-4 sm:ml-6 md:ml-0 lg:max-w-[50%] -ml-8"
                    style="font-size: 45px;">
                    <?php echo esc_html($text); ?>
                </h1>
            <?php endif; ?>

            <!-- EERSTE TEKSTAREA -->
            <?php if ($text_area) : ?>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl text-white leading-relaxed max-w-full
                          ml-4 sm:ml-6 md:ml-0 lg:max-w-[50%] -ml-8 mb-8">
                    <?php echo esc_html($text_area); ?>
                </p>
            <?php endif; ?>

            <!-- TWEEDE TEKSTAREA -->
            <?php if ($text_area2) : ?>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl text-white leading-relaxed max-w-full
                          ml-4 sm:ml-6 md:ml-0 lg:max-w-[50%] -ml-8 mt-4">
                    <?php echo esc_html($text_area2); ?>
                </p>
            <?php endif; ?>

        </div>
    </div>
</section>
<?php endif; ?>
