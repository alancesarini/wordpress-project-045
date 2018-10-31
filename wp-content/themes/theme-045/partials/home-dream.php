<?php

$url_video = get_field( '_flaats_home_video' );

while( have_rows( '_flaats_home_dream' ) ) {
    the_row();
    $dream_title1 = get_sub_field( 'title1' );
    $dream_title2 = get_sub_field( 'title2' );
    $dream_text = get_sub_field( 'text' );
    $dream_image = get_sub_field( 'background' );
}

?>


<section class="costa_del_sol">
	<div class="container">
    	<div class="video">
        	<div class="video_area">
            	<iframe width="100%" height="530" src="<?php echo $url_video; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="costa_bg">
    <div class="container">
    	<h3><?php echo $dream_title1; ?> </h3>
        <h2><?php echo $dream_title2; ?></h2>
        <?php echo wpautop( $dream_text ); ?>
        <a href="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'areas-es'; else echo 'areas'; ?>"><?php _e( 'VER AREAS', 'flaats' ); ?></a>
        </div>
    </div>
</section>
