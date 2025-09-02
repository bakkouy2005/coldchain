<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="border-b">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex-1 flex items-center">
                    <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { the_custom_logo(); } else { ?>
                        <a href="<?php echo esc_url( home_url('/') ); ?>" class="text-xl font-semibold">Coldchain</a>
                    <?php } ?>
                </div>

                <nav class="flex-1">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex justify-center gap-6',
                            'fallback_cb'    => false,
                        ) );
                    ?>
                </nav>

                <div class="flex-1 flex justify-end">
                    <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Contact</a>
                </div>
            </div>
        </div>
    </header>
    