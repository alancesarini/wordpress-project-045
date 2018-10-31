<?php 

/**
 * Template name: Noticias
 */

get_header(); 

?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/banner-news.jpg)">
	<div class="container">
    	<h1><?php _e( 'Noticias', 'flaats' ); ?></h1>
    </div>
</section>

<section class="grideview_area">
	<div class="container">
        
        <div id="propertylist" class="row list-group">

        <?php
		$paged = ( intval( get_query_var( 'paged' ) ) > 0 ? intval( get_query_var( 'paged' ) ) : 1 );         
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $paged
        ); 
        $query = new WP_Query( $args );
        while( $query->have_posts() ) { $query->the_post(); 
        ?>
        <a href="<?php the_permalink(); ?>">
        <div class="post-in-list  col-xs-4 col-lg-4 aos-init" data-aos="fade-up" data-aos-duration="2000">
            <div class="thumbnail clearfix">
            <div class="propertyimg">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="caption">
                <span><?php the_time( 'j M Y' ); ?></span>
                <h2><?php the_title(); ?></h2>
                <p><?php echo Flaats_Functions::get_excerpt( get_the_ID() ); ?></p>
               <ul>
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-comments.png" alt="icon"> <?php echo get_comments_number( get_the_ID() ); ?></li>
               </ul>
            </div>
          </div>
        </div>
        </a>
        <?php } ?>
                
       </div>
       
       <div class="row">
       	<div class="pagination">
           <?php if( function_exists( 'wp_pagenavi' ) ) wp_pagenavi( array( 'query' => $query ) ); ?>
        </div>
       </div>
        
    </div>
</section>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>