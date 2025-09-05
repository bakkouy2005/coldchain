<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://kit.fontawesome.com/cd619e1d1d.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class=" bg-[#1A1A1E] text-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <div class="flex-1 flex items-center">
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="inline-flex items-center">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.svg' ); ?>" alt="Coldchain" class="h-15 w-auto" />
                    </a>
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
                    <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Meld je nu aan!</a>
                </div>
            </div>
        </div>
    </header>
    