<?php
$hero = get_field('hero'); // Haal de hele group op
if( $hero ):
    $hero_img = $hero['hero_image'];
    $hero_title = $hero['hero_title'];
    $text_img1 = $hero['text_img1'];
    $text_img2 = $hero['text_img2'];
    $button1 = $hero['button1'];
    $button2 = $hero['button2'];
    $repeater = $hero['repeater'];
?>
    <section class="relative min-h-[60vh] sm:min-h-[65vh] md:min-h-[70vh] lg:min-h-[95vh] xl:min-h-[90vh] flex items-center justify-center text-center text-white py-12 lg:py-16 bg-[#0A131F]">
        
        <!-- Hero image met elegante vorm -->
        <div class="absolute inset-0 m-3 sm:m-4 md:m-6 lg:m-5 xl:m-6 shadow-2xl z-10 rounded-[20px] sm:rounded-[24px] md:rounded-[28px] lg:rounded-[32px] overflow-hidden bg-cover bg-center"
             style="background-image:url('<?php echo esc_url($hero_img['url']); ?>');">
            <div class="bg-black/30 absolute inset-0"></div> <!-- subtle overlay -->
        </div>
        
        <div class="relative z-10 mb-8 sm:mb-10 md:mb-12 lg:mb-12 xl:mb-14 px-4 sm:px-6 md:px-8 lg:px-10 xl:px-16 max-w-6xl mx-auto w-full">
            <h1 class="font-bold text-[#E7E7E7] text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl 2xl:text-6xl tracking-wide mb-6 sm:mb-8 md:mb-10 lg:mb-12 break-words leading-snug -tracking-tight font-sans transition-all duration-500 ease-out">
                <?php 
                // Split title into words
                $words = explode(' ', $hero_title);
                $total_words = count($words);
                $word_count = 0;
                
                foreach ($words as $index => $word) : 
                    $word_count++;
                    echo '<span class="inline">' . esc_html($word) . '</span> ';
                    
                    if ($word_count === 3 && !empty($text_img1['url'])) : ?>
                        <img src="<?php echo esc_url($text_img1['url']); ?>" 
                             alt="<?php echo esc_attr($text_img1['alt'] ?? ''); ?>"
                             class="inline-block align-middle w-10 h-10 sm:w-14 sm:h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 xl:w-24 xl:h-24 2xl:w-28 2xl:h-28 object-cover rounded-lg sm:rounded-xl shadow-2xl transform hover:scale-110 transition-transform duration-300 mx-1 sm:mx-2">
                    <?php endif;
                    
                    if ($word_count === 6 && !empty($text_img2['url'])) : ?>
                        <img src="<?php echo esc_url($text_img2['url']); ?>" 
                             alt="<?php echo esc_attr($text_img2['alt'] ?? ''); ?>"
                             class="inline-block align-middle w-10 h-10 sm:w-14 sm:h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 xl:w-24 xl:h-24 2xl:w-28 2xl:h-28 object-cover rounded-lg sm:rounded-xl shadow-2xl transform hover:scale-110 transition-transform duration-300 mx-1 sm:mx-2">
                    <?php endif;
                endforeach; ?>
            </h1>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 md:gap-6 justify-center items-center mt-24 sm:mt-32 md:mt-40 lg:mt-48 xl:mt-56 transition-all duration-500 ease-out">
                <?php if ( $button1 && is_array($button1) ) : 
                    $btn1_url = $button1['url1'] ?? '';
                    $btn1_text = $button1['text1'] ?? '';
                    if ( $btn1_url && $btn1_text ) :
                ?>
                    <!-- Button 1: Glanzend met gradient -->
                    <a href="<?php echo esc_url( $btn1_url ); ?>" 
                       target="<?php echo esc_attr( $button1['target'] ?? '_self' ); ?>"
                       class="group relative px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base md:text-lg font-bold text-white rounded-full overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl min-w-[180px] sm:min-w-[200px] w-full sm:w-auto max-w-[280px] sm:max-w-none"
                       style="background: linear-gradient(135deg, #243866 0%, #1e2f52 100%); box-shadow: 0 10px 25px rgba(36, 56, 102, 0.4);">
                        <span class="relative z-10"><?php echo esc_html( $btn1_text ); ?></span>
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 transform -skew-x-12"></div>
                    </a>
                <?php endif; endif; ?>

                <?php if ( $button2 && is_array($button2) ) : 
                    $btn2_url = $button2['url2'] ?? '';
                    $btn2_text = $button2['text2'] ?? '';
                    if ( $btn2_url && $btn2_text ) :
                ?>
                    <!-- Button 2: Doorzichtig met border en glasmorphism -->
                    <a href="<?php echo esc_url( $btn2_url ); ?>" 
                       target="<?php echo esc_attr( $button2['target'] ?? '_self' ); ?>"
                       class="group relative px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base md:text-lg font-bold text-white rounded-full overflow-hidden transition-all duration-300 hover:scale-105 min-w-[180px] sm:min-w-[200px] w-full sm:w-auto max-w-[280px] sm:max-w-none"
                       style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 2px solid rgba(255, 255, 255, 0.3); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                        <span class="relative z-10 drop-shadow-lg"><?php echo esc_html( $btn2_text ); ?></span>
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                <?php endif; endif; ?>
            </div>
        </div>

        <!-- Repeater Cards - rechtsonder gepositioneerd -->
        <?php if ( $repeater && is_array($repeater) && count($repeater) > 0 ) : ?>
            <div class="absolute bottom-4 right-4 lg:bottom-6 lg:right-6 xl:bottom-8 xl:right-8 z-20 hidden lg:flex flex-col gap-3 lg:gap-4 max-w-[280px] lg:max-w-sm transition-all duration-500 ease-out">
                <?php foreach ( $repeater as $item ) : 
                    $img3 = $item['img3'] ?? [];
                    $text3 = $item['text3'] ?? '';
                    $text_area3 = $item['text_area3'] ?? '';
                    
                    // Skip lege items
                    if ( empty($img3) && empty($text3) && empty($text_area3) ) continue;
                ?>
                    <div class="group relative bg-white/95 backdrop-blur-md rounded-xl md:rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                        <!-- Gradient overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative p-4 md:p-6">
                            <!-- Image -->
                            <?php if ( ! empty($img3['url']) ) : ?>
                                <div class="mb-3 md:mb-4 overflow-hidden rounded-lg md:rounded-xl">
                                    <img src="<?php echo esc_url($img3['url']); ?>" 
                                         alt="<?php echo esc_attr($img3['alt'] ?? $text3); ?>"
                                         class="w-full h-24 md:h-32 object-cover transform transition-transform duration-700 group-hover:scale-110">
                                </div>
                            <?php endif; ?>

                            <!-- Text3 (Titel) -->
                            <?php if ( $text3 ) : ?>
                                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 transform transition-all duration-300 group-hover:text-blue-600">
                                    <?php echo esc_html($text3); ?>
                                </h3>
                                <div class="w-12 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mb-2 md:mb-3 transform transition-all duration-500 group-hover:w-full"></div>
                            <?php endif; ?>

                            <!-- Text Area3 (Beschrijving) -->
                            <?php if ( $text_area3 ) : ?>
                                <div class="text-xs md:text-sm text-gray-600 leading-relaxed line-clamp-3 transition-colors duration-300 group-hover:text-gray-800">
                                    <?php echo wp_kses_post($text_area3); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Decorative corner accent -->
                        <div class="absolute top-0 right-0 w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-400/20 to-transparent rounded-bl-full transform transition-all duration-500 group-hover:scale-150"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>
