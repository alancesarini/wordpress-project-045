<?php 

/**
 * Template name: Búsqueda de áreas
 */

get_header(); 

while( have_posts() ) {
    the_post();
}


$query = Project045_Zona::get_search_results();

$array_zones = array();
while( $query->have_posts() ) {
    $query->the_post();
    $array_zones[] = Project045_Zona::get_zone_data( get_the_ID() );    			
}	


?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/areabanner.jpg)">
	<div class="container">
    	<h1><?php the_title(); ?></h1>
    </div>
</section>

<?php Project045_Functions::render_search( 2 ); ?>

<section class="areas_section">
	<div class="container">

       <?php foreach( $array_zones as $zone ) { ?> 	

       <div class="row">
       		<div class="areas_row clearfix aos-init" data-aos="fade-up" data-aos-duration="2000">
            	<div class="col-md-6">
                    <a href="<?php echo $zone['url']; ?>"><img src="<?php echo $zone['thumbnail_list']; ?>" alt="<?php echo $zone['name']; ?>"></a>
                </div>
                <div class="col-md-6">
                	<div class="area_review clearfix">
                        <a href="<?php echo $zone['url']; ?>"><h2><?php echo $zone['name']; ?></h2></a>
                        <ul class="clearfix">
                                <?php foreach( $zone['lifestyle'] as $text => $value ) { ?>
                                    <li>
                                        <?php echo $text; ?>:
                                        <?php for( $i = 1; $i <= $value; $i++ ) { ?>
                                            <span class="star star-active"><i class="fa fa-star"></i></span>
                                        <?php } ?>
                                        <?php for( $i = ($value+1); $i <= 5; $i++ ) { ?>
                                            <span class="star"><i class="fa fa-star"></i></span>
                                        <?php } ?>    
                                    </li>
                                <?php } ?>
                        </ul>
                        <a href="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'promociones'; else echo 'developments'; ?>?z=<?php echo $zone['id']; ?>" class="zonadev"><?php _e( 'VER PROMOCIONES', 'project045' ); ?></a>
                        <a href="<?php echo $zone['url']; ?>" class="zona"><?php _e( 'CONOCER LA ZONA', 'project045' ); ?></a>
                    </div>
                </div>
            </div>
       </div>

       <?php } ?> 
       
       <div class="row">
       	<div class="pagination">
           <?php if( function_exists( 'wp_pagenavi' ) ) wp_pagenavi( array( 'query' => $query ) ); ?>
        </div>
       </div>
        
    </div>
</section>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>