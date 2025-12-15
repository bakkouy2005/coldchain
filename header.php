<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://kit.fontawesome.com/cd619e1d1d.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php 
    // Check if page has hero (homepage, contact, over ons, werken bij ons)
    $is_homepage = is_front_page() || is_page_template('template-homepage.php');
    $is_contactpage = is_page_template('template-contactpage.php');
    $is_overons = is_page_template('template-overons.php');
    $is_werkenbijons = is_page_template('template-werkenbijons.php');
    $has_hero = $is_homepage || $is_contactpage || $is_overons || $is_werkenbijons;
    
    $header_class = $has_hero ? 'fixed' : 'sticky';
    $initial_bg = $has_hero ? 'linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05))' : 'rgba(10, 19, 31, 0.98)';
    $initial_border = $has_hero ? 'rgba(255, 255, 255, 0.25)' : 'rgba(59, 130, 246, 0.3)';
    ?>
    <header class="<?php echo $header_class; ?> top-0 left-0 right-0 z-50 text-white">
        <div class="container mx-auto px-2 sm:px-4 lg:px-6 xl:px-8 py-2 sm:py-3 lg:py-4">
            <!-- Elegant glasmorphism navigation -->
            <div id="header-nav" class="relative rounded-full lg:rounded-full backdrop-blur-xl shadow-2xl transition-all duration-300" 
                 style="background: <?php echo $initial_bg; ?>; border: 1px solid <?php echo $initial_border; ?>;"
                 data-is-homepage="<?php echo $has_hero ? 'true' : 'false'; ?>">
                
                <div class="relative flex items-center justify-between py-2 sm:py-3 lg:py-4 px-3 sm:px-4 md:px-6 lg:px-8">
                    <!-- Left: Logo -->
                    <div class="flex items-center">
                        <a href="<?php echo esc_url( home_url('/') ); ?>" class="inline-flex items-center transform hover:scale-105 transition-transform duration-300" aria-label="Home">
                            <img
                                src="<?php echo esc_url( get_template_directory_uri() . '/images/logo1.svg' ); ?>"
                                alt="<?php echo esc_attr( get_bloginfo('name') ); ?> logo"
                                class="h-7 sm:h-8 md:h-10 lg:h-12 xl:h-14 w-auto drop-shadow-lg"
                            />
                        </a>
                    </div>

                    <!-- Center: Desktop navigation -->
                    <nav class="hidden lg:flex flex-1 justify-center text-xs xl:text-sm 2xl:text-base" aria-label="Primary">
                        <div class="flex items-center gap-3 xl:gap-6 2xl:gap-8">
                            <?php
                                // Get menu items
                                $menu_name = 'primary';
                                $locations = get_nav_menu_locations();
                                $menu = wp_get_nav_menu_object($locations[$menu_name]);
                                $menu_items = wp_get_nav_menu_items($menu->term_id);
                                
                                $count = 0;
                                foreach ($menu_items as $item) :
                                    $count++;
                                    ?>
                                    <a href="<?php echo esc_url($item->url); ?>" 
                                       class="relative py-1 lg:py-2 px-0.5 lg:px-1 hover:text-blue-300 transition-colors duration-300 whitespace-nowrap">
                                        <?php echo esc_html($item->title); ?>
                                    </a>
                                    <?php
                                    // Insert Diensten dropdown after 2nd item
                                    if ($count == 2) :
                                    ?>
                                        <!-- Diensten dropdown -->
                                        <div class="relative group">
                                            <a href="<?php echo esc_url( home_url('/meer-informatie') ); ?>" 
                                               class="relative py-1 lg:py-2 px-0.5 lg:px-1 hover:text-blue-300 transition-colors duration-300 flex items-center gap-0.5 whitespace-nowrap">
                                                Diensten
                                                <svg class="w-3 h-3 lg:w-4 lg:h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </a>
                                            
                                            <!-- Dropdown menu -->
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                                <div class="rounded-2xl backdrop-blur-xl shadow-2xl border border-white/20 py-3 px-2" style="background: rgba(10, 19, 31, 0.95);">
                                                    <?php
                                                    $informatie_posts = get_posts(array(
                                                        'post_type'      => 'informatie',
                                                        'posts_per_page' => -1,
                                                        'orderby'        => 'menu_order',
                                                        'order'          => 'ASC',
                                                    ));
                                                    
                                                    if ($informatie_posts) :
                                                        foreach ($informatie_posts as $post) :
                                                            setup_postdata($post);
                                                            ?>
                                                            <a href="<?php echo get_permalink($post->ID); ?>" 
                                                               class="block px-4 py-2 hover:bg-blue-500/20 rounded-lg transition-colors duration-200 text-sm">
                                                                <?php echo esc_html($post->post_title); ?>
                                                            </a>
                                                            <?php
                                                        endforeach;
                                                        wp_reset_postdata();
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endif;
                                endforeach;
                            ?>
                        </div>
                    </nav>

                    <!-- Right: CTA + Mobile hamburger -->
                    <div class="flex items-center gap-2 lg:gap-3">
                        <a href="<?php echo esc_url( home_url('/offerte-page') ); ?>" 
                           class="hidden lg:inline-block px-3 xl:px-5 2xl:px-6 py-2 xl:py-2.5 rounded-full text-xs xl:text-sm font-semibold text-white shadow-lg transform hover:scale-105 transition-all duration-300 whitespace-nowrap"
                           style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);">
                            Offerte aanvragen
                        </a>
                        <button id="mobile-nav-toggle" 
                                class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg hover:bg-white/20 transition-all duration-300" 
                                aria-expanded="false" aria-controls="mobile-nav" aria-label="Menu"
                                style="border: 1px solid rgba(255, 255, 255, 0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile nav dropdown (outside rounded container) -->
            <div id="mobile-nav" class="lg:hidden hidden mt-2" role="dialog" aria-label="Mobile menu">
                <div class="rounded-2xl backdrop-blur-xl shadow-2xl border border-white/20 px-4 py-4 text-sm"
                     style="background: rgba(10, 19, 31, 0.95);">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex flex-col gap-3',
                            'fallback_cb'    => false,
                        ) );
                    ?>
                    
                    <!-- Diensten dropdown for mobile -->
                    <div class="mt-2">
                        <button id="mobile-diensten-toggle" class="w-full text-left py-2 hover:text-blue-300 transition-colors duration-300 flex items-center justify-between">
                            <span>Diensten</span>
                            <svg class="w-4 h-4 transition-transform duration-300" id="mobile-diensten-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="mobile-diensten-menu" class="hidden pl-4 mt-2 flex flex-col gap-2">
                            <?php
                            $informatie_posts_mobile = get_posts(array(
                                'post_type'      => 'informatie',
                                'posts_per_page' => -1,
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC',
                            ));
                            
                            if ($informatie_posts_mobile) :
                                foreach ($informatie_posts_mobile as $post) :
                                    setup_postdata($post);
                                    ?>
                                    <a href="<?php echo get_permalink($post->ID); ?>" 
                                       class="block py-2 px-3 hover:bg-blue-500/20 rounded-lg transition-colors duration-200 text-sm">
                                        <?php echo esc_html($post->post_title); ?>
                                    </a>
                                    <?php
                                endforeach;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <a href="<?php echo esc_url( home_url('/offerte-page') ); ?>" 
                       class="mt-3 inline-block w-full text-center px-5 py-2.5 rounded-full text-sm font-semibold text-white shadow-lg transition-all duration-300"
                       style="background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);">
                        Offerte aanvragen
                    </a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </header>

    <script>
    (function() {
        // Mobile menu toggle
        var toggle = document.getElementById('mobile-nav-toggle');
        var menu = document.getElementById('mobile-nav');
        if (toggle && menu) {
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
        }
        
        // Mobile diensten dropdown toggle
        var dienstenToggle = document.getElementById('mobile-diensten-toggle');
        var dienstenMenu = document.getElementById('mobile-diensten-menu');
        var dienstenIcon = document.getElementById('mobile-diensten-icon');
        if (dienstenToggle && dienstenMenu) {
            dienstenToggle.addEventListener('click', function() {
                var isHidden = dienstenMenu.classList.contains('hidden');
                if (isHidden) {
                    dienstenMenu.classList.remove('hidden');
                    dienstenIcon.style.transform = 'rotate(180deg)';
                } else {
                    dienstenMenu.classList.add('hidden');
                    dienstenIcon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Smooth background change on scroll (only for homepage)
        var headerNav = document.getElementById('header-nav');
        var isHomepage = headerNav.getAttribute('data-is-homepage') === 'true';
        
        function updateHeader() {
            if (!isHomepage) return; // Skip scroll effect on non-homepage
            
            if (window.scrollY > 100) {
                // Scrolled: smooth transition to blue background
                headerNav.style.background = 'linear-gradient(135deg, rgba(10, 19, 31, 0.98), rgba(10, 19, 31, 0.95))';
                headerNav.style.borderColor = 'rgba(59, 130, 246, 0.3)';
            } else {
                // Top: transparent glasmorphism
                headerNav.style.background = 'linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05))';
                headerNav.style.borderColor = 'rgba(255, 255, 255, 0.25)';
            }
        }
        
        window.addEventListener('scroll', updateHeader);
        updateHeader(); // Initial check
    })();
    </script>