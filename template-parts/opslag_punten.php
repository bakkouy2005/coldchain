<?php 
$opslag_punten = get_field('opslag_punten');

if ( $opslag_punten && is_array( $opslag_punten ) ) :

    // Haal alle velden op uit de groep
    $text       = $opslag_punten['text'] ?? '';
    $text_area  = $opslag_punten['text_area'] ?? '';
    $img        = $opslag_punten['img'] ?? [];
    $repeater   = ! empty( $opslag_punten['repeater'] ) && is_array( $opslag_punten['repeater'] )
                    ? $opslag_punten['repeater']
                    : [];
    ?>

    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                <!-- Tekstkolom -->
                <div class="order-2 lg:order-1">
                    <?php if ( $text ) : ?>
                        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 leading-tight mb-4">
                            <?php echo esc_html( $text ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $text || $text_area ) : ?>
                        <div class="h-1 w-16 mb-6 rounded-full" style="background-color:#243866;"></div>
                    <?php endif; ?>

                    <?php if ( $text_area ) : ?>
                        <div class="prose prose-slate prose-lg max-w-none text-slate-700 mb-8">
                            <?php echo wp_kses_post( $text_area ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $repeater ) ) : ?>
                        <div class="space-y-4">
                            <?php foreach ( $repeater as $item ) :

                                $item_text      = ! empty( $item['text'] )      ? $item['text']      : '';
                                $item_text_area = ! empty( $item['text_area'] ) ? $item['text_area'] : '';

                                // sla lege items over
                                if ( empty( $item_text ) && empty( $item_text_area ) ) {
                                    continue;
                                }
                                ?>
                                
                                <div class="flex gap-3">
                                    <div class="mt-1">
                                        <span class="inline-block h-2.5 w-2.5 rounded-full" style="background-color:#243866;"></span>
                                    </div>
                                    <div>
                                        <?php if ( $item_text ) : ?>
                                            <p class="font-semibold text-slate-900">
                                                <?php echo esc_html( $item_text ); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ( $item_text_area ) : ?>
                                            <div class="text-sm text-slate-700 mt-1">
                                                <?php echo wp_kses_post( $item_text_area ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Afbeeldingskolom -->
                <div class="order-1 lg:order-2">
                    <?php if ( ! empty( $img['url'] ) ) : ?>
                        <div class="relative">
                            <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                                <img src="<?php echo esc_url( $img['url'] ); ?>" 
                                     alt="<?php echo esc_attr( $img['alt'] ?? ( $text ?: '' ) ); ?>"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

<?php
endif;
?>
