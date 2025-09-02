<?php 
/**
 * Theme setup

 */

// Zorg dat WordPress theme ondersteunt
function coldchain_development_setup() {
    add_theme_support( 'title-tag' ); // Laat WordPress de titel beheren
    add_theme_support( 'custom-logo' ); // Logo ondersteuning
    add_theme_support( 'post-thumbnails' ); // Uitgelichte afbeeldingen
}
add_action( 'after_setup_theme', 'coldchain_development_setup' );

// CSS en JS toevoegen
function coldchain_development_assets() {
    wp_enqueue_style( 'mijn-style', get_stylesheet_uri() ); // style.css
}
add_action( 'wp_enqueue_scripts', 'coldchain_development_assets' );