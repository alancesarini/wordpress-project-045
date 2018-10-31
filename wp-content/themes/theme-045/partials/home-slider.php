<?php 
	$mobile_detect = new Mobile_Detect();			
?>

<section class="banner clearfix">

<div id="banner" class="owl-carousel">
    
    <?php while( have_rows( '_flaats_home_slider' ) ) { the_row(); $pic = get_sub_field( 'pic' );?>
        <div class="item">
            <img src="<?php echo $pic; ?>" alt="slide">
            <div class="banner_content">
                <h2><?php echo get_sub_field( 'title' ); ?></h2>
            </div>
        </div>
    <?php } ?>
  
</div>

<div class="filter_area">
    <div class="icon_bar">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon2-<?php echo pll_current_language(); ?>.png" alt="icon2">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-best-price-<?php echo pll_current_language(); ?>.png" alt="icon3">
    </div>

    <div class="tabs clearfix">
        <h2><?php if( $mobile_detect->isMobile() ) { _e( 'BUSCAR PROMOCIONES', 'flaats' ); } else { _e( 'BUSCAR EN EL MAPA', 'flaats' ); } ?></h2>    
        <div>
            <div class="filter_div clearfix">
                <?php Flaats_Functions::render_search_developments(); ?>
            </div>
        </div>
        <h2><?php _e( 'BUSCAR LIFESTYLE', 'flaats' ); ?></h2>
        <div>
            <div class="filter_div clearfix">
                <?php Flaats_Functions::render_search_lifestyle(); ?>
            </div>
        </div>
    </div>
</div>

</section>