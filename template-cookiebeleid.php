<?php
/* Template Name: Cookiebeleid */

get_header();

?>

<div class="">
    <?php> get_title() ?>

</div>

<?php

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        the_content(); // This will render the page content and process shortcodes like [cmplz-document]
    endwhile;
endif;

get_footer();