<?php

/**
 * Template name: Portada
 */

get_header(); 

while( have_posts() ) {
    the_post();
    get_template_part( 'partials/home', 'slider' ); 
    get_template_part( 'partials/home', 'services' ); 
    get_template_part( 'partials/home', 'developments' ); 
    get_template_part( 'partials/home', 'dream' ); 
    get_template_part( 'partials/home', 'areas' ); 
    get_template_part( 'partials/home', 'benefits' ); 
}

get_template_part( 'partials/subscription' );
?>

<?php Flaats_Functions::show_search_mobile(); ?>

<?php get_footer(); 
