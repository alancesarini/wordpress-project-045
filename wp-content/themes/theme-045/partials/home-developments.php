<?php

$promo_big = get_field( '_flaats_home_promo_big' );
$promos = get_field( '_flaats_home_promos' );

$data_big = Flaats_Development::get_development_data( $promo_big );
$data_small1 = Flaats_Development::get_development_data( $promos[0] );
$data_small2 = Flaats_Development::get_development_data( $promos[1] );
$data_small3 = Flaats_Development::get_development_data( $promos[2] );

?>

<?php if( $promo_big != false && $promos != false ) { ?>

<section class="section_development">
	<div class="container">
    <h1><span class="notranslate">dream<strong>homes</strong></span> <span><?php _e( 'promociones', 'flaats' ); ?></span></h1>
    	<div class="row">
        	<div class="col-md-8 aos-init" data-aos="fade-left" data-aos-duration="2000">
            	<div class="section_development_img">
                	<img src="<?php echo $data_big['thumbnail_featured_big']; ?>" alt="<?php echo $data_big['name']; ?>">
                    <div class="section_development_details">
                    	<h2><span class="notranslate"><?php echo $data_big['name']; ?></span></h2>
                        <h3><span class="notranslate"><?php echo $data_big['zone']; ?></span></h3>
                        <ul>
                        	<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon10.png" alt="price"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_big['price_min']; ?></li>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon11.png" alt="rooms"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_big['rooms_min']; ?> <?php _e( 'habitaciones', 'flaats' ); ?></li>
                        </ul>
                    </div>
                    <div class="heartsymbol">
                        <?php the_favorites_button( $promo_big ); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 aos-init" data-aos="fade-right" data-aos-duration="2000">
            	<div class="section_development_img">
                	<img src="<?php echo $data_small1['thumbnail_featured_small']; ?>" alt="<?php echo $data_small1['name']; ?>">
                    <div class="section_development_details">
                    	<h2><span class="notranslate"><?php echo $data_small1['name']; ?></span></h2>
                        <h3><span class="notranslate"><?php echo $data_small1['zone']; ?></span></h3>
                        <ul>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon10.png" alt="price"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small1['price_min']; ?></li>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon11.png" alt="rooms"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small1['rooms_min']; ?> <?php _e( 'habitaciones', 'flaats' ); ?></li>
                        </ul>
                    </div>
                    <div class="heartsymbol">
                        <?php the_favorites_button( $promos[0] ); ?>                    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-4 aos-init" data-aos="fade-up" data-aos-duration="2000">
            	<div class="section_development_img">
                    <img src="<?php echo $data_small2['thumbnail_featured_small']; ?>" alt="<?php echo $data_small2['name']; ?>">
                    <div class="section_development_details">
                        <h2><span class="notranslate"><?php echo $data_small2['name']; ?></span></h2>
                        <h3><span class="notranslate"><?php echo $data_small2['zone']; ?></span></h3>
                        <ul>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon10.png" alt="price"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small2['price_min']; ?></li>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon11.png" alt="rooms"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small2['rooms_min']; ?> <?php _e( 'habitaciones', 'flaats' ); ?></li>
                        </ul>
                    </div>
                    <div class="heartsymbol">
                        <?php the_favorites_button( $promos[1] ); ?>                    
                    </div>                	
                </div>
            </div>
            
            <div class="col-md-4 aos-init" data-aos="fade-up" data-aos-duration="2000">
            	<div class="section_development_img">
                	<div class="feture_development">
                    	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon12.png" alt="">
                        <h4><?php _( 'PROMOCIONES<br> <span>DESTACADAS</span>', 'flaats' ); ?></h4>
                        <p><?php _( 'Villas, Apartmentos y casas situadas en preciosas comunidades', 'flaats' ); ?></p>
                        <a href="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'promociones'; else echo 'developments'; ?>"><?php _( 'VER PROMOCIONES', 'flaats' ); ?></a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 aos-init" data-aos="fade-up" data-aos-duration="2000">
            	<div class="section_development_img">
                <img src="<?php echo $data_small3['thumbnail_featured_small']; ?>" alt="<?php echo $data_small3['name']; ?>">
                    <div class="section_development_details">
                        <h2><span class="notranslate"><?php echo $data_small3['name']; ?></span></h2>
                        <h3><span class="notranslate"><?php echo $data_small3['zone']; ?></span></h3>
                        <ul>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon10.png" alt="price"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small3['price_min']; ?></li>
                            <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon11.png" alt="rooms"> <?php _e( 'desde', 'flaats' ); ?> <?php echo $data_small3['rooms_min']; ?> <?php _e( 'habitaciones', 'flaats' ); ?></li>
                        </ul>
                    </div>
                    <div class="heartsymbol">
                        <?php the_favorites_button( $promos[2] ); ?>                    
                    </div>                	
                </div>
            </div>
            
        </div>
    </div>
</section>

<?php } ?>