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