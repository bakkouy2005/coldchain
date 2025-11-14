<?php



$algemene_voorwaarden_info = get_field('algemene_voorwaarden_info');

if ( $algemene_voorwaarden_info ) {

    $intro_text = ! empty( $algemene_voorwaarden_info['text'] ) ? $algemene_voorwaarden_info['text'] : '';
    $repeater    = ! empty( $algemene_voorwaarden_info['repeater'] ) && is_array( $algemene_voorwaarden_info['repeater'] )
                   ? $algemene_voorwaarden_info['repeater']
                   : array();

    // Container met padding en max-width
    echo '<section class="py-12 lg:py-16 bg-gray-50">';
        echo '<div class="max-w-7xl mx-auto px-6 lg:px-8">';
            
            // Intro tekst bovenaan (gecentreerd en responsive)
            if ( $intro_text ) {
                echo '<div class="max-w-3xl mx-auto mb-12 text-center">';
                    echo '<div class="prose prose-lg mx-auto text-gray-700">' . wp_kses_post( $intro_text ) . '</div>';
                echo '</div>';
            }

            // Grid met repeater items (responsive: 1, 2, of 3 kolommen)
            if ( count( $repeater ) ) {
                echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">';

                foreach ( $repeater as $item ) {
                    $item_text = ! empty( $item['text'] ) ? $item['text'] : '';
                    $item_url  = ! empty( $item['url'] ) ? $item['url'] : '';

                    echo '<div class="flex flex-col">';
                        // Titel met oranje accent - grotere tekst
                        if ( $item_text ) {
                            echo '<h3 class="text-2xl lg:text-3xl font-bold tracking-tight uppercase text-gray-900 mb-4">' . esc_html( $item_text ) . '</h3>';
                            // Oranje divider met kleur #243866
                            echo '<div class="w-16 h-1 mb-6" style="background-color: #243866;"></div>';
                        }

                        // Link(s) onderaan - grotere en beter leesbare tekst
                        if ( $item_url ) {
                            $href = esc_url( $item_url );
                            // Toon alleen de bestandsnaam of laatste deel van URL voor betere leesbaarheid
                            $display_text = basename( parse_url( $item_url, PHP_URL_PATH ) );
                            if ( empty( $display_text ) ) {
                                $display_text = $item_url;
                            }
                            
                            echo '<div class="mt-auto">';
                                echo '<a class="inline-flex items-center text-base lg:text-lg font-medium text-gray-800 hover:text-orange-600 transition-colors duration-200 underline" href="' . $href . '" target="_blank" rel="noopener noreferrer">';
                                    echo esc_html( $display_text );
                                    // Optioneel: voeg een icoon toe
                                    echo '<svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>';
                                echo '</a>';
                            echo '</div>';
                        }
                    echo '</div>';
                }

                echo '</div>'; // grid
            }
            
        echo '</div>'; // container
    echo '</section>';
}
?>