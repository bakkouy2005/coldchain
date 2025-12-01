<?php
$opslag_info = get_field('opslag_info');

if ( $opslag_info && ! empty( $opslag_info['repeater'] ) && is_array( $opslag_info['repeater'] ) ) :

    $repeater = $opslag_info['repeater'];
    ?>
    
    <section class="py-14 lg:py-20" style="background-color:#0A131F;">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                <?php foreach ( $repeater as $item ) :

                    $item_text      = ! empty( $item['text'] )      ? $item['text']      : '';
                    $item_text_area = ! empty( $item['text_area'] ) ? $item['text_area'] : '';
                    $item_icon      = ! empty( $item['text1'] )     ? $item['text1']     : '';

                    // sla lege items over
                    if ( empty( $item_text ) && empty( $item_text_area ) && empty( $item_icon ) ) {
                        continue;
                    }
                    ?>
                    
                    <article class="h-full bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-7 flex flex-col transition duration-200 hover:shadow-md hover:-translate-y-0.5">
                        
                        <?php if ( $item_icon ) : ?>
                            <div class="mb-5">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl"
                                     style="background-color:#243866;">
                                    <i class="<?php echo esc_attr( $item_icon ); ?> text-white text-xl"></i>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( $item_text ) : ?>
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 mb-4 leading-snug">
                                <?php echo esc_html( $item_text ); ?>
                            </h3>
                            <div class="h-0.5 w-12 mb-4 rounded-full" style="background-color:#243866;"></div>
                        <?php endif; ?>

                        <?php if ( $item_text_area ) : 
                            // Tel aantal woorden in text_area
                            $word_count = str_word_count( wp_strip_all_tags( $item_text_area ) );
                            $is_long = $word_count > 25; // Meer dan 25 woorden = te lang
                            
                            // Genereer unieke ID voor dit item
                            $unique_id = 'text-' . md5( $item_text . $item_text_area );
                        ?>
                            <div class="text-base sm:text-lg md:text-xl text-slate-700 leading-relaxed mb-4 flex-grow">
                                <?php if ( $is_long ) : ?>
                                    <!-- Verkorte versie (eerste 20 woorden) -->
                                    <div id="<?php echo $unique_id; ?>-short" class="text-content-short">
                                        <?php 
                                        $words = explode(' ', wp_strip_all_tags( $item_text_area ) );
                                        $short_text = implode(' ', array_slice($words, 0, 20)) . '...';
                                        echo wp_kses_post( wpautop( $short_text ) );
                                        ?>
                                    </div>
                                    <!-- Volledige versie (verborgen) -->
                                    <div id="<?php echo $unique_id; ?>-full" class="text-content-full hidden">
                                        <?php echo wp_kses_post( $item_text_area ); ?>
                                    </div>
                                <?php else : ?>
                                    <!-- Korte tekst, geen knop nodig -->
                                    <?php echo wp_kses_post( $item_text_area ); ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ( $is_long ) : ?>
                                <!-- Lees meer knop - altijd onderaan -->
                                <button 
                                    onclick="toggleText('<?php echo $unique_id; ?>')"
                                    id="<?php echo $unique_id; ?>-btn"
                                    class="inline-flex items-center mt-auto text-sm font-medium transition-colors duration-200 hover:underline"
                                    style="color: #243866;">
                                    <span id="<?php echo $unique_id; ?>-btn-text">Lees meer</span>
                                    <svg class="ml-1 w-4 h-4" id="<?php echo $unique_id; ?>-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="mt-auto"></div>
                    </article>

                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <script>
    function toggleText(id) {
        const shortDiv = document.getElementById(id + '-short');
        const fullDiv = document.getElementById(id + '-full');
        const btnText = document.getElementById(id + '-btn-text');
        const icon = document.getElementById(id + '-icon');
        
        if (fullDiv.classList.contains('hidden')) {
            // Toon volledige tekst
            shortDiv.classList.add('hidden');
            fullDiv.classList.remove('hidden');
            btnText.textContent = 'Lees minder';
            icon.style.transform = 'rotate(180deg)';
        } else {
            // Toon verkorte tekst
            fullDiv.classList.add('hidden');
            shortDiv.classList.remove('hidden');
            btnText.textContent = 'Lees meer';
            icon.style.transform = 'rotate(0deg)';
        }
    }
    </script>

<?php
endif;
?>
