<?php 
$opslag_betekent = get_field('opslag_betekent');

if ( $opslag_betekent && is_array($opslag_betekent) ):

    // Haal alle velden op uit de groep
    $text       = $opslag_betekent['text'] ?? '';
    $text_area  = $opslag_betekent['text_area'] ?? '';
    $repeater   = ! empty( $opslag_betekent['repeater'] ) && is_array( $opslag_betekent['repeater'] )
                    ? $opslag_betekent['repeater']
                    : [];
    ?>

    <section class="py-16 lg:py-20" style="background-color: #0A131F;">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <!-- Titel + inleiding -->
            <?php if ( $text || $text_area ) : ?>
                <div class="max-w-3xl mb-10 lg:mb-12">
                    <?php if ( $text ) : ?>
                        <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                            <?php echo esc_html( $text ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $text_area ) : ?>
                        <div class="h-1 w-16 mb-5 rounded-full" style="background-color:#243866;"></div>
                        <div class="prose prose-slate prose-lg max-w-none text-white">
                            <?php echo wp_kses_post( $text_area ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Repeater: punten / kaarten -->
            <?php if ( ! empty( $repeater ) ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php foreach ( $repeater as $item ) :

                        $item_text      = ! empty( $item['text'] )      ? $item['text']      : '';
                        $item_text_area = ! empty( $item['text_area'] ) ? $item['text_area'] : '';
                        $item_icon      = ! empty( $item['text1'] )     ? $item['text1']     : '';

                        // sla volledig lege items over
                        if ( empty( $item_text ) && empty( $item_text_area ) && empty( $item_icon ) ) {
                            continue;
                        }
                        ?>
                        
                        <article class="h-full bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col transition duration-200 hover:shadow-md hover:-translate-y-0.5">
                            
                            <?php if ( $item_icon ) : ?>
                                <div class="mb-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl"
                                         style="background-color:#243866;">
                                        <i class="<?php echo esc_attr( $item_icon ); ?> text-white text-xl"></i>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $item_text ) : ?>
                                <h3 class="text-lg lg:text-xl font-semibold text-slate-900 mb-2 leading-snug">
                                    <?php echo esc_html( $item_text ); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ( $item_text_area ) : ?>
                                <div class="prose prose-slate prose-sm lg:prose-base max-w-none text-slate-700">
                                    <?php echo wp_kses_post( $item_text_area ); ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto"></div>
                        </article>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php
endif;
?>
