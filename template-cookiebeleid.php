<?php
/* Template Name: Cookiebeleid */

get_header();

?>

<div class="container mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-6"><?php the_title(); ?></h1>
    

</div>


<?php

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        the_content(); // This will render the page content and process shortcodes like [cmplz-document]
    endwhile;
endif;


?>





<?php
get_footer();
?>