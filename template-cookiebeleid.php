<?php
/* Template Name: Cookiebeleid */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        the_content(); // This will render the page content and process shortcodes like [cmplz-document]
    endwhile;
endif;

get_footer();