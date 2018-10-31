<?php

$args = array(
    'post_type' => 'zona',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'lang' => pll_current_language()    
);
$query = new WP_Query( $args );
$zones = array();
while( $query->have_posts() ) {
    $query->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    $permalink = get_the_permalink();
    if( has_post_thumbnail( get_the_ID() ) ) {
        $thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'zone-slider' );
        $zones[] = array( 'id' => $id,  'title' => $title, 'permalink' => $permalink, 'thumbnail' => $thumbnail );
    }
}
wp_reset_postdata();


?>


<section class="homearea">
	<div class="container">
    	<h2><span class="notranslate">dream<strong>homes</strong></span> <em><?php _e( 'areas', 'flaats' ); ?></em></h2>
        
        <div id="homeareas" class="owl-carousel">
            <?php foreach( $zones as $zone ) { ?>
                <div class="item">
                <div class="col-md-12">
                <div class="homeimg">
                    <a href="<?php echo $zone['permalink']; ?>"><img src="<?php echo $zone['thumbnail']; ?>" alt="<?php echo $zone['title']; ?>"></a>
                    <h3><?php echo $zone['title']; ?></h3>
                    </div>
                    <h4><a href="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'promociones'; else echo 'developments'; ?>?z=<?php echo $zone['id']; ?>"><?php _e( 'VER PROMOCIONES', 'flaats' ); ?></a></h4>
                </div>
                </div>
            <?php } ?>
        
        </div>
    </div>
</section>