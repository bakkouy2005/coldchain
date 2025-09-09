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

}
add_action( 'wp_enqueue_scripts', 'coldchain_development_assets' );



