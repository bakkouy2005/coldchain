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


// Register a custom post type to persist offerte submissions in the database
add_action('init', function () {
    $labels = array(
        'name'               => __('Offertes', 'coldchain-development'),
        'singular_name'      => __('Offerte', 'coldchain-development'),
        'menu_name'          => __('Offerte aanvragen', 'coldchain-development'),
        'name_admin_bar'     => __('Offerte', 'coldchain-development'),
        'add_new'            => __('Nieuwe toevoegen', 'coldchain-development'),
        'add_new_item'       => __('Nieuwe offerte toevoegen', 'coldchain-development'),
        'new_item'           => __('Nieuwe offerte', 'coldchain-development'),
        'edit_item'          => __('Bewerk offerte', 'coldchain-development'),
        'view_item'          => __('Bekijk offerte', 'coldchain-development'),
        'all_items'          => __('Alle offertes', 'coldchain-development'),
        'search_items'       => __('Zoek offertes', 'coldchain-development'),
        'not_found'          => __('Geen offertes gevonden', 'coldchain-development'),
        'not_found_in_trash' => __('Geen offertes in prullenbak', 'coldchain-development'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-media-text',
        'supports'           => array('title', 'editor', 'custom-fields'),
    );

    register_post_type('offerte', $args);
});

// Admin meta box: show stored offerte details on the edit screen
add_action('add_meta_boxes', function () {
    add_meta_box(
        'offerte_details_box',
        __('Offerte details', 'coldchain-development'),
        function ($post) {
            if ($post->post_type !== 'offerte') { return; }

            $fields = array(
                'dienst'       => __('Dienst', 'coldchain-development'),
                'laadplaats'   => __('Laadplaats', 'coldchain-development'),
                'losplaats'    => __('Losplaats', 'coldchain-development'),
                'datum'        => __('Datum', 'coldchain-development'),
                'pallets'      => __('Pallets', 'coldchain-development'),
                'gewicht'      => __('Gewicht', 'coldchain-development'),
                'afmeting'     => __('Afmeting', 'coldchain-development'),
                'omschrijving' => __('Omschrijving', 'coldchain-development'),
                'email'        => __('E-mail', 'coldchain-development'),
                'telefoon'     => __('Telefoon', 'coldchain-development'),
                'start_datum'  => __('Start datum', 'coldchain-development'),
                'eind_datum'   => __('Eind datum', 'coldchain-development'),
            );

            echo '<div class="p-4">';
            echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
            foreach ($fields as $key => $label) {
                $raw = get_post_meta($post->ID, $key, true);
                $value = $raw === '' ? '—' : $raw;
                $value_display = nl2br(esc_html($value));
                echo '<div class="bg-white rounded border border-gray-200 p-3">';
                echo '<div class="text-xs uppercase tracking-wide text-gray-500 mb-1">' . esc_html($label) . '</div>';
                echo '<div class="text-sm text-gray-900">' . $value_display . '</div>';
                if ($key === 'email' && is_email($raw)) {
                    $mailto = 'mailto:' . rawurlencode($raw);
                    echo '<div class="mt-2">';
                    echo '<a href="' . esc_url($mailto) . '" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded bg-blue-600 text-white hover:bg-blue-700">';
                    echo '<span>Quick reply</span>';
                    echo '</a>';
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
            echo '<p class="mt-3 text-gray-500 text-xs">' . esc_html__('Deze gegevens zijn alleen-lezen en komen uit de ingestuurde aanvraag.', 'coldchain-development') . '</p>';
            echo '</div>';
        },
        'offerte',
        'normal',
        'high'
    );
});

// Admin list columns: show key offerte fields in the list table
add_filter('manage_offerte_posts_columns', function ($columns) {
    // Keep checkbox and title, then add custom columns
    $new = array();
    foreach ($columns as $k => $v) {
        $new[$k] = $v;
        if ($k === 'title') {
            $new['dienst']   = __('Dienst', 'coldchain-development');
            $new['datum']    = __('Datum', 'coldchain-development');
            $new['email']    = __('E-mail', 'coldchain-development');
            $new['telefoon'] = __('Telefoon', 'coldchain-development');
        }
    }
    return $new;
});

add_action('manage_offerte_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'dienst':
            echo esc_html(get_post_meta($post_id, 'dienst', true));
            break;
        case 'datum':
            echo esc_html(get_post_meta($post_id, 'datum', true));
            break;
        case 'email':
            $email = get_post_meta($post_id, 'email', true);
            if ($email && is_email($email)) {
                $mailto = 'mailto:' . rawurlencode($email);
                echo '<a href="' . esc_url($mailto) . '" class="button button-small">' . esc_html($email) . '</a>';
            } else {
                echo esc_html($email);
            }
            break;
        case 'telefoon':
            echo esc_html(get_post_meta($post_id, 'telefoon', true));
            break;
    }
}, 10, 2);

// Make some columns sortable
add_filter('manage_edit-offerte_sortable_columns', function ($columns) {
    $columns['datum'] = 'datum';
    $columns['dienst'] = 'dienst';
    return $columns;
});

add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query()) { return; }
    if ($query->get('post_type') !== 'offerte') { return; }

    $orderby = $query->get('orderby');
    if ($orderby === 'datum') {
        $query->set('meta_key', 'datum');
        $query->set('orderby', 'meta_value');
    } elseif ($orderby === 'dienst') {
        $query->set('meta_key', 'dienst');
        $query->set('orderby', 'meta_value');
    }
});

// Load Tailwind in admin only on Offerte edit screen (not list) for meta box UI
add_action('admin_enqueue_scripts', function () {
    $screen = get_current_screen();
    if (!$screen) { return; }
    if ($screen->post_type !== 'offerte') { return; }
    if ($screen->base !== 'post') { return; }
    wp_enqueue_script('tailwind-cdn-admin', 'https://cdn.tailwindcss.com', array(), null, false);
});

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

add_filter('af/field/value/name=vacature_functie', function($value, $field, $form, $args) {
    if (isset($_GET['id'])) {
        $vacature_id = absint($_GET['id']);
        if ($vacature_id) {
            return get_the_title($vacature_id);
        }
    }
    return $value;
}, 10, 4);


