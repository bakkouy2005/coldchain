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
    <div class="relative z-20 flex items-center justify-start h-full">
        <div class="container mx-auto px-4 md:px-6 lg:px-8 flex flex-col justify-center h-full items-start">

            <div class="w-full max-w-full md:w-1/2 lg:w-1/2">

                <!-- TITEL -->
                <?php if ($text) : ?>
                    <h1 class="font-bold mb-4 text-white leading-tight px-2 sm:px-4 md:px-0"
                        style="font-size: clamp(22px, 4vw, 42px);">
                        <?php echo esc_html($text); ?>
                    </h1>
                <?php endif; ?>

                <!-- EERSTE TEKSTAREA -->
                <?php if ($text_area) : ?>
                    <p class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl text-white leading-relaxed px-2 sm:px-4 md:px-0 mb-4">
                        <?php echo esc_html($text_area); ?>
                    </p>
                <?php endif; ?>

                <!-- TWEEDE TEKSTAREA -->
                <?php if ($text_area2) : ?>
                    <p class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl text-white leading-relaxed px-2 sm:px-4 md:px-0 mb-4">
                        <?php echo esc_html($text_area2); ?>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<?php endif; ?>
