<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://kit.fontawesome.com/cd619e1d1d.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="bg-[#1A1A1E] text-white">
        <div class="container mx-auto px-3 sm:px-4 lg:px-6">
            <div class="flex items-center justify-between py-3 sm:py-4">
                <!-- Left: Logo (smaller on mobile) -->
                <div class="flex items-center">
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="inline-flex items-center" aria-label="Home">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.svg' ); ?>" alt="Coldchain" class="h-6 sm:h-8 md:h-10 lg:h-12 w-auto" />
                    </a>
                </div>

                <!-- Center: Desktop navigation -->
                <nav class="hidden lg:flex flex-1 justify-center text-[10px] sm:text-xs md:text-sm lg:text-base xl:text-lg" aria-label="Primary">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex items-center gap-6',
                            'fallback_cb'    => false,
                        ) );
                    ?>
                </nav>

                <!-- Right: CTA + Mobile hamburger -->
                <div class="flex items-center gap-3">
                    <a href="<?php echo esc_url( home_url('/offerte-page') ); ?>" class="hidden lg:inline-block bg-blue-600 text-white px-3 sm:px-4 py-2 rounded text-sm sm:text-base hover:bg-blue-700">Offerte aanrvagen</a>
                    <button id="mobile-nav-toggle" class="lg:hidden inline-flex items-center justify-center p-2 rounded border border-white/20 hover:bg-white/10" aria-expanded="false" aria-controls="mobile-nav" aria-label="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile nav -->
            <div id="mobile-nav" class="lg:hidden hidden pb-3 sm:pb-4 text-sm sm:text-base" role="dialog" aria-label="Mobile menu">
                <div class="border-t border-white/10 pt-4">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex flex-col gap-3',
                            'fallback_cb'    => false,
                        ) );
                    ?>
                    <a href="<?php echo esc_url( home_url('/offerte-page/') ); ?>" class="mt-3 inline-block w-full text-center bg-blue-600 text-white px-3 sm:px-4 py-2 rounded text-sm sm:text-base hover:bg-blue-700">Offerte aanrvagen</a>
                </div>
            </div>
        </div>
    </header>

    <script>
    (function() {
        var toggle = document.getElementById('mobile-nav-toggle');
        var menu = document.getElementById('mobile-nav');
        if (!toggle || !menu) return;
        toggle.addEventListener('click', function() {
            var isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
            } else {
                menu.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    })();
    </script>