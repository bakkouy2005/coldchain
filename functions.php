<?php

// Theme setup: supports and menus
function coldchain_theme_setup() {
    // Title tag managed by WordPress
    add_theme_support( 'title-tag' );

    // Featured images
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup support
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'coldchain' ),
        'footer'  => __( 'Footer Menu', 'coldchain' ),
    ) );
}
add_action( 'after_setup_theme', 'coldchain_theme_setup' );

// Enqueue styles and scripts
function coldchain_enqueue_assets() {
    // Main stylesheet (WordPress handles versioning with file modification time if not provided)
    wp_enqueue_style( 'coldchain-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'coldchain_enqueue_assets' );
?>

<?php 
/**
 * Theme setup

 */

// Zorg dat WordPress theme ondersteunt
function coldchain_development_setup() {
    add_theme_support( 'title-tag' ); // Laat WordPress de titel beheren
    add_theme_support( 'custom-logo' ); // Logo ondersteuning
    add_theme_support( 'post-thumbnails' ); // Uitgelichte afbeeldingen

    // Menu locaties
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'coldchain-development' ),
    ) );
}
add_action( 'after_setup_theme', 'coldchain_development_setup' );

// CSS en JS toevoegen
function coldchain_development_assets() {
    // Tailwind via officiële CDN (in de <head>)
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );

    // Je eigen theme CSS (style.css)
    wp_enqueue_style( 'mijn-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );

    // Theme JavaScript (character limit & counters)
    $theme_js_path = get_stylesheet_directory() . '/js/java.js';
    $theme_js_uri  = get_stylesheet_directory_uri() . '/js/java.js';
    $theme_js_ver  = file_exists( $theme_js_path ) ? filemtime( $theme_js_path ) : null;
    wp_enqueue_script( 'coldchain-main-js', $theme_js_uri, array(), $theme_js_ver, true );
}
add_action( 'wp_enqueue_scripts', 'coldchain_development_assets' );

function theme_enqueue_swiper() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], null);
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_swiper');


// Tailwind classes for active menu item
add_filter( 'nav_menu_link_attributes', function( $atts, $item ) {
    $active_classes = 'text-blue-500';
    $base_classes = 'text-white hover:text-blue-400 transition-colors';

    $item_classes = is_array( $item->classes ) ? $item->classes : array();
    $is_active = in_array( 'current-menu-item', $item_classes, true )
        || in_array( 'current_page_item', $item_classes, true )
        || in_array( 'current-menu-ancestor', $item_classes, true )
        || in_array( 'current_page_ancestor', $item_classes, true )
        || in_array( 'current-menu-parent', $item_classes, true );

    $existing = isset( $atts['class'] ) ? trim( $atts['class'] ) : '';
    $atts['class'] = trim( $existing . ' ' . ( $is_active ? $active_classes : $base_classes ) );

    return $atts;
}, 10, 2 );

add_action('acf/init', 'mijn_acf_form_init');
function mijn_acf_form_init() {
    // Zorg dat scripts/styles van ACF form worden geladen
    acf_form_head();
}

add_filter('af/field/value/name=vacature_functie', function($value, $field, $form, $args) {
    if (isset($_GET['id'])) {
        $vacature_id = absint($_GET['id']);
        if ($vacature_id) {
            return get_the_title($vacature_id);
        }
    }
    return $value;
}, 10, 4);


