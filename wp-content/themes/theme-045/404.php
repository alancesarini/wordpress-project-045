<?php get_header(); ?>

<?php
while( have_posts() ) {
    the_post();
}
?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/purchasebanner.jpg)">
	<div class="container">
    	<h1><?php _e( 'Error 404', 'project045' ); ?></h1>
    </div>
</section>

<section class="fichazona">
	<div class="container">
       <div class="row">
         <div class="titulo_area clearfix">
         	<div class="col-md-12">
            	<?php _e( 'Lo sentimos, no hemos encontrado lo que buscaba.', 'project045' ); ?>
            </div>
         </div>
       </div>      
    </div>
</section>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>