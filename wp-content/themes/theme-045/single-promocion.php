<?php get_header(); ?>


<?php
while( have_posts() ) {
    the_post(); 
    $promo_name = get_the_title();
    $promo_data = Project045_Development::get_development_data( get_the_ID() );
    $promo_logo = get_field( '_project045_promo_logo', get_the_ID() );
    $promo_pics = get_field( '_project045_promo_pics', get_the_ID() );
    $promo_developers = get_field( '_project045_promo_developers', get_the_ID() );
    $promo_plan = get_field( '_project045_promo_plan', get_the_ID() );
    $promo_zone = get_field( '_project045_promo_zone', get_the_ID() );
    $promo_price_min = Project045_Functions::format_price( get_field( '_project045_promo_data_price_min', get_the_ID() ) );
    $promo_size_min = get_field( '_project045_promo_data_size_min', get_the_ID() );
    $promo_rooms_min = get_field( '_project045_promo_data_rooms_min', get_the_ID() );
    $promo_rooms_max = get_field( '_project045_promo_data_rooms_max', get_the_ID() );
    $promo_video = get_field( '_project045_promo_data_video', get_the_ID() );    
    $promo_building_permit = get_field( '_project045_promo_data_building_permit', get_the_ID() );    
    $promo_construction_started = get_field( '_project045_promo_data_construction_started', get_the_ID() );  
    $promo_date = get_field( '_project045_promo_data_dateend', get_the_ID() );
    if( $promo_date ) {
        $_date = new DateTime( substr( $promo_date, 6, 4 ) . '-' . substr( $promo_date, 3, 2 ) . '-' . substr( $promo_date, 0, 2 ) );
        $finish_day = $_date->format( 'j' );
        $finish_month = $_date->format( 'M' );
        $finish_year = $_date->format( 'Y' );
    }
    $property_type = get_the_terms( get_the_ID(), 'property_type' );
    $zone_data = Project045_Zona::get_zone_data( $promo_zone );
    $promo_texts = array();
    for( $i = 1; $i < 4; $i++ ) {
        while( have_rows( '_project045_promo_text' . $i ) ) {
            the_row();
            $title = get_sub_field( 'title' );
            $subtitle = get_sub_field( 'subtitle' );
            $text = get_sub_field( 'text' );
            $pic = get_sub_field( 'pic' );
            $video = get_sub_field( 'video' );
            $promo_texts[] = array( 'title' => $title, 'subtitle' => $subtitle, 'text' => $text, 'pic' => $pic, 'video' => $video );
        }
    }
    
    $amenities = Project045_Development::get_the_terms_sorted( get_the_ID(), 'amenity' );
    $promo_amenities = array();
    foreach( $amenities as $amenity ) {
        $image_id = get_term_meta( $amenity->term_id, 'image', true );
        $image_url = wp_get_attachment_url( $image_id );
        $promo_amenities[] = array( 'name' => $amenity->name, 'pic' => $image_url );
    }

    $query_developments = Project045_Development::get_developments_by_zone( $promo_zone, get_the_ID(), 0 );
    $more_promos = array();
    while( $query_developments->have_posts() ) {
        $query_developments->the_post();
        $data = Project045_Development::get_development_data( get_the_ID() );
        $more_promos[] = $data;
    }    
    wp_reset_postdata();    

    while( have_rows( '_project045_promo_pdf', get_the_ID() ) ) {
        the_row();
        $dossier_url = get_sub_field( 'dossier' );
        $plans_url = get_sub_field( 'plans' );
        $prices_url = get_sub_field( 'prices' );
    }

    $content = get_the_content('',FALSE,'');
    $content = Project045_Functions::multi_col_text( $content );


    //------------------------------------------------------------------------------------    
    // If we are in the spanish version, get custom fields from the english version of the CPT
    //------------------------------------------------------------------------------------    
    if( 'es' == pll_current_language() ) {
        $english_promo_id = pll_get_post( get_the_ID(), 'en' );
        $promo_data = Project045_Development::get_development_data( $english_promo_id );
        $promo_logo = get_field( '_project045_promo_logo', $english_promo_id );
        $promo_pics = get_field( '_project045_promo_pics', $english_promo_id );
        $promo_developers = get_field( '_project045_promo_developers', $english_promo_id );
        $promo_plan = get_field( '_project045_promo_plan', $english_promo_id );
        $promo_price_min = Project045_Functions::format_price( get_field( '_project045_promo_data_price_min', $english_promo_id ) );
        $promo_size_min = get_field( '_project045_promo_data_size_min', $english_promo_id );
        $promo_rooms_min = get_field( '_project045_promo_data_rooms_min', $english_promo_id );
        $promo_rooms_max = get_field( '_project045_promo_data_rooms_max', $english_promo_id );
        $promo_video = get_field( '_project045_promo_data_video', $english_promo_id );    
        $promo_building_permit = get_field( '_project045_promo_data_building_permit', $english_promo_id );   
        $promo_construction_started = get_field( '_project045_promo_data_construction_started', $english_promo_id );  
        $promo_date = get_field( '_project045_promo_data_dateend', $english_promo_id );
        if( $promo_date ) {
            $_date = new DateTime( substr( $promo_date, 6, 4 ) . '-' . substr( $promo_date, 3, 2 ) . '-' . substr( $promo_date, 0, 2 ) );
            $finish_day = $_date->format( 'j' );
            $finish_month = $_date->format( 'M' );
            $finish_year = $_date->format( 'Y' );
        }
    
        while( have_rows( '_project045_promo_pdf', $english_promo_id ) ) {
            the_row();
            $dossier_url = get_sub_field( 'dossier' );
            $plans_url = get_sub_field( 'plans' );
            $prices_url = get_sub_field( 'prices' );
        }   
        
        $promo_texts = array();     
        for( $i = 1; $i < 4; $i++ ) {
            while( have_rows( '_project045_promo_text' . $i, get_the_ID() ) ) {
                the_row();
                $title = get_sub_field( 'title' );
                $subtitle = get_sub_field( 'subtitle' );
                $text = get_sub_field( 'text' );
                $promo_texts[] = array( 'title' => $title, 'subtitle' => $subtitle, 'text' => $text, 'pic' => '', 'video' => '' );
            }            
            while( have_rows( '_project045_promo_text' . $i, $english_promo_id ) ) {
                the_row();
                $pic = get_sub_field( 'pic' );                
                $video = get_sub_field( 'video' );                
                $promo_texts[$i-1]['pic'] = $pic;
                $promo_texts[$i-1]['video'] = $video;
            }
        }

        $query_developments = Project045_Development::get_developments_by_zone( $promo_zone, get_the_ID(), 0 );
        $more_promos = array();
        while( $query_developments->have_posts() ) {
            $query_developments->the_post();
            $spanish_subpromo_id = pll_get_post( get_the_ID(), 'es' );         
            if( intval( $spanish_subpromo_id ) > 0 ) {   
                $data = Project045_Development::get_development_data( get_the_ID() );
                $excerpt = Project045_Functions::get_excerpt( $spanish_subpromo_id );	
                $data['excerpt'] = $excerpt;
                $more_promos[] = $data;
            }
        }      
        wp_reset_postdata();    
                
    }
    //------------------------------------------------------------------------------------

}
?>



<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/development_banner.jpg)">
	<div class="container">
    	<h1><span class="notranslate"><?php echo $promo_name; ?></span></h1>
    </div>
</section>

<?php Project045_Functions::render_search( 1 ); ?>


<section class="promocion_slider">
<div class="container">
	<div class="row">
    	<div class="col-md-10">
        <h2><span class="notranslate">
            <?php 
                if( $promo_logo ) {
                    echo "<img src='" . $promo_logo . "' />";
                } else {
                    echo $promo_name;
                } 
            ?>
        </span></h2>
        <h3><?php echo $zone_data['name']; ?></h3>
        </div>
        <div class="col-md-2"></div>
        
        <div class="col-md-12">
        	<div class="riconvictoria">

                <div id="carousel-promo" class="carousel slide">

                    <?php if( $promo_construction_started ) { ?>
                        <!--
                        <div class="badge-construction">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/badge-construction-<?php echo pll_current_language(); ?>.png" alt="construction" />
                        </div>
                        -->
                    <?php } ?>
                
                    <div class="carousel-inner" role="listbox">
                    <?php $i = 1; ?>
                    <?php if( $promo_video != '' ) { ?>
                        <div class="item active" >
                            <?php the_field( '_project045_promo_data_video', $english_promo_id ); ?>
                        </div>
                    <?php $i++; } ?>    

                    <?php foreach( $promo_pics as $pic ) { ?>
                            <div class="item <?php if( 1 == $i ) echo 'active'; ?>">
                                <img src="<?php echo $pic['sizes']['promo-gallery']; ?>" alt="foto" class="img-responsive" />
                            </div>
                    <?php $i++; } ?>  
                    
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-promo" role="button" data-slide="prev">
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-promo" role="button" data-slide="next">
                        <span class="sr-only">Next</span>
                    </a>
                </div>        
            
            <div class="riconvictoria_details clearfix">
            	<div class="row">
                <div class="col-md-9">
                <div class="row_top clearfix">
                	<ul class="list_ricon">
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_<?php echo $property_type[0]->slug; ?>.png" alt="icon"><p><?php echo $property_type[0]->name; ?></p></li>
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon18.png" alt="icon"><p><span><?php _e( 'desde', 'project045' ); ?></span> <?php echo $promo_rooms_min; ?> <?php Project045_Functions::render_rooms_literal( $promo_rooms_min ); ?></p> </li>
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon19.png" alt="icon"><p><span><?php _e( 'desde', 'project045' ); ?></span> <?php echo $promo_size_min; ?> m2</p></li>
                   </ul>
                 </div>
                 <div class="ricon_bt clearfix">
                 	<?php echo $content; ?>
                 </div>
                </div>
                <div class="col-md-3">
                	<div class="ricon_right">
                	<h3><?php _e( 'desde', 'project045' ); ?> <strong><?php echo $promo_price_min; ?></strong></h3>

                    <?php if( intval( $promo_building_permit ) > 0 ) { ?>
                        <a href="#" class="riconinfo">
                            <?php 
                                switch( $promo_building_permit ) {
                                    case 1:
                                        _e( 'licencia solicitada', 'project045' ); 
                                        break;
                                    case 2:
                                        _e( 'licencia concedida', 'project045' ); 
                                        break;
                                    case 3:
                                        _e( 'licencia de primera ocupación', 'project045' ); 
                                        break;                                                                                                            
                                } 
                            ?>
                            <i class="fa fa-check-square"></i>
                        </a>
                    <?php } ?>

                    <a href="#promo-map" class="riconmap">
                        <?php _e( 'localización', 'project045' ); ?> <i class="fa fa-map-marker-alt"></i>                     
                    </a>
                    
                    <div class="cal_div">
                    	<div class="cal_iconarea">
                        	<div class="cal_bg">
                            	<h6><span><?php echo strtoupper( $finish_month ); ?></span><br> <?php echo $finish_year; ?></h6>
                            </div>
                            <p class="dont-break-out"><?php _e( 'COMPLETADO', 'project045' ); ?></p>
                            <p></p>
                        </div>
                        
                        <div class="visitcal">
                        	<a href="#" data-toggle="modal" data-target="#modal-request-visit"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-home.png" alt="visit"><br><?php _e( 'Solicitar visita', 'project045' ); ?></a>
                        </div>
                    </div>
                    
                    </div>
                </div>
              </div>  
                <div class="current_member clearfix">
                <ul>
                    <?php foreach( $promo_developers as $developer ) { ?>
                	    <li><img src="<?php echo $developer['url']; ?>" alt="logo"></li>
                    <?php } ?>               
                </ul>
                
            </div>
            
            
            	<ul class="download">

                    <?php if( $dossier_url != '' ) { ?>
                	<li>
                        <a href="#" class="button-download dossier" data-which="dossier" data-toggle="modal" data-target="#modal-download-dossier">
                            <?php _e( 'DESCARGAR DOSSIER', 'project045' ); ?>
                        </a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="#" class="button-download plans" data-which="plans" data-toggle="modal" data-target="#modal-download-plans">
                            <?php _e( 'SOLICITAR PLANOS', 'project045' ); ?>
                        </a>
                    </li>                    
                    <li>
                        <a href="#" class="button-download prices" data-which="prices" data-toggle="modal" data-target="#modal-download-prices">
                            <?php _e( 'SOLICITAR PRECIOS', 'project045' ); ?>
                        </a>
                    </li>
                </ul>
            
            </div>
            
            
            </div>
        </div>
        
    </div>
</div>
</section>


<section class="amenities">
	<div class="container">
    <div class="row">
    	<h2><?php _e( 'Características', 'project045' ); ?></h2>
        <ul>
            
            <?php foreach( $promo_amenities as $amenity ) { ?>
            <li>
            	<img src="<?php echo $amenity['pic']; ?>" alt="<?php echo $amenity['name']; ?>">
                <p>
                    <?php
                        if( 0 === strpos( $amenity['name'], 'NNN' ) ) {
                            if( 'es' == pll_current_language() ) {
                                $and = ' y ';
                            } else {
                                $and = ' and ';
                            }
                            $text = '';
                            for( $i = $promo_rooms_min; $i <= $promo_rooms_max; $i++ ) {
                                if( $i == $promo_rooms_max ) {
                                    $text .= $and . $i;
                                } else {
                                    $text .= ',' . $i;
                                }
                            }
                            $amenity_name = str_replace( 'NNN' , '', $amenity['name'] );
                            $text = substr( $text, 1, strlen( $text ) - 1 ) . $amenity_name;
                            echo $text;
                        } else {
                            echo $amenity['name'];
                        } 
                    ?>
                </p>
            </li>
            <?php } ?>
            
        </ul>
    </div>
    </div>
</section>

<?php if( $promo_plan ) { ?>
<div class="blackzone">
	<div class="container">
    	<div class="row">
            <div class="col-md-12">
                <p class="text-center"><img src="<?php echo $promo_plan; ?>" /></p>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if( isset( $promo_texts[0] ) ) { ?>
<section class="section_02">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-2" data-aos="fade-right" data-aos-duration="2000">
            	<h3 class="title title-padding"><?php echo $promo_texts[0]['title']; ?></h3>
                <h2><?php echo $promo_texts[0]['subtitle']; ?></h2>
                <?php echo wpautop( $promo_texts[0]['text'] ); ?>
            </div>
            
            <div class="col-md-6 aos-init flex-column-1" data-aos="fade-left" data-aos-duration="2000">
                <?php if( $promo_texts[0]['pic'] != '' ) { ?>
            	    <img src="<?php echo $promo_texts[0]['pic']; ?>" alt="<?php echo $promo_texts[0]['title']; ?>">
                <?php } else { ?>
                    <?php echo $promo_texts[0]['video']; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<?php if( isset( $promo_texts[1] ) ) { ?>
<section class="section_field_two">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-1" data-aos="fade-right" data-aos-duration="2000">
                <?php if( $promo_texts[1]['pic'] != '' ) { ?>
            	    <img src="<?php echo $promo_texts[1]['pic']; ?>" alt="<?php echo $promo_texts[1]['title']; ?>">
                <?php } else { ?>
                    <?php echo $promo_texts[1]['video']; ?>
                <?php } ?>            
            </div>
            <div class="col-md-6 aos-init flex-column-2" data-aos="fade-left" data-aos-duration="2000">
            	<h3 class="title"><?php echo $promo_texts[1]['title']; ?></h3>
                <h4><?php echo $promo_texts[1]['subtitle']; ?></h4>
                <?php echo wpautop( $promo_texts[1]['text'] ); ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<?php if( isset( $promo_texts[2] ) ) { ?>
<section class="section_02">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 padd_top2 aos-init flex-column-2" data-aos="fade-right" data-aos-duration="2000">
            	<h3 class="title"><?php echo $promo_texts[2]['title']; ?></h3>
                <h2><?php echo $promo_texts[2]['subtitle']; ?></h2>
                <?php echo wpautop( $promo_texts[2]['text'] ); ?>
            </div>
            
            <div class="col-md-6 padd_top2 aos-init flex-column-1" data-aos="fade-left" data-aos-duration="2000">
                <?php if( $promo_texts[2]['pic'] != '' ) { ?>
            	    <img src="<?php echo $promo_texts[2]['pic']; ?>" alt="<?php echo $promo_texts[2]['title']; ?>">
                <?php } else { ?>
                    <?php echo $promo_texts[2]['video']; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>


<section class="ubicacion">
    <a name="promo-map"></a>
            <div class="contenido" id="ottmapas">
                <div class="contenido">
                    <div class="barra_botones">
                        <div class="button-wrapper">
                            <div class="col_button col_button_mobile">
                                <button data-type="educacion" type="" class="boton_maps">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/educacion.png" alt="icon">  <span><?php _e( 'Educativos', 'project045' ); ?></span>
                                </button>
                            </div>
                            <div class="col_button">
                                <button data-type="sanitario" type="" class="boton_maps">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sanitario.png" alt="icon"> <span><?php _e( 'Sanitarios', 'project045' ); ?></span></button>
                            </div>
                            <div class="col_button">
                                <button data-type="comercial" type="" class="boton_maps">
                                     <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/compras.png" alt="icon"> <span><?php _e( 'Compras', 'project045' ); ?></span></button>
                            </div>
                            <div class="col_button">
                                <button data-type="restaurantes" type="" class="boton_maps">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/utensils.png" alt="icon"> <span><?php _e( 'Restaurantes', 'project045' ); ?></span></button>
                            </div>
                            <div class="col_button">
                                <button data-type="transportes" type="" class="boton_maps">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/transportes.png" alt="icon"> <span><?php _e( 'Transportes', 'project045' ); ?></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="maps">
                        <div id="responsive_map" class="responsive_map"></div>
                    </div>
                </div>

            </div>
        </section>
<!-- END Maps-->

<section class="promocionform">
<div class="container">
<div class="member_application">
<a name="contact-form"></a>
            	<div class="member_application_heading">
                <h2><?php _e( 'Contacte con nosotros', 'project045' ); ?></h2>
                	<p><?php _e( 'Si está interesado en obtener más información sobre esta promoción por favor rellene el siguiente formulario.', 'project045' ); ?></p>
                </div>
                
                <div class="row">
                    <?php echo do_shortcode( '[cf7-form cf7key="formulario-de-contacto-1"]' ); ?>
                    <?php //echo do_shortcode('[contact-form-7 id="378" title="Form info promo"]'); ?>
                </div>
                
            </div>
</div>
</section>


<section class="lifestyle_promo">
	<div class="container">
    		<div class="row">
            	<div class="col-md-12"><h2><?php _e( 'LifeStyle <span>Promoción</span>', 'project045' ); ?></h2></div>
            </div>
            <div class="row">
            	<div class="lifegallery">
            	<div class="col-md-7">
                    <div class="gallery-zone-big">
                        <h3><?php echo $zone_data['name']; ?></h3>
                        <img src="<?php echo $zone_data['gallery'][0]['sizes']['zone-gallery-big']; ?>" alt="foto">
                    </div>
                </div>
                <div class="col-md-5">
                	<div class="col-md-6"><img src="<?php echo $zone_data['gallery'][1]['sizes']['zone-gallery-small']; ?>" alt="foto"></div>
                    <div class="col-md-6"><img src="<?php echo $zone_data['gallery'][2]['sizes']['zone-gallery-small']; ?>" alt="foto"></div>
                    <div class="col-md-6"><img src="<?php echo $zone_data['gallery'][3]['sizes']['zone-gallery-small']; ?>" alt="foto"></div>
                    <div class="col-md-6"><img src="<?php echo $zone_data['gallery'][4]['sizes']['zone-gallery-small']; ?>" alt="foto"></div>
                </div>
                </div>
            </div>
    </div>
</section> 




<section class="dela_zona">
	<div class="container">
    	<div class="row">
        	
        	<div class="col-md-12">
        	<div class="dela_innerzona clearfix">
            	<h2><?php _e( 'Intereses <span>de la Zona</span>', 'project045' ); ?></h2>
            	<div class="col-md-6">
        			<div class="progress_br clearfix">
                        <?php foreach( $zone_data['lifestyle1'] as $text => $score ) { ?>
                            <div class="bar_row clearfix">
                                <div class="bar_name"><?php echo $text; ?>:</div>
                                <div class="range_bar">
                                    <div>
                                        <input type="range" min="1" max="5" step="1" value="<?php echo $score; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>                    
        		</div>
            	<div class="col-md-6">
        			<div class="progress_br clearfix">
                        <?php foreach( $zone_data['lifestyle2'] as $text => $score ) { ?>
                            <div class="bar_row clearfix">
                                <div class="bar_name"><?php echo $text; ?>:</div>
                                <div class="range_bar">
                                    <div>
                                        <input type="range" min="1" max="5" step="1" value="<?php echo $score; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>                    
        		</div>                

            </div>
            </div>            
        </div>
        
        <div class="row">
            	<div class="col-md-12">
                    <div class="zone-content">
                        <?php echo wpautop( $zone_data['content'] ); ?>   
                    </div>     
                </div>
        </div>
    </div>
</section>

<section class="merbella_slider zona_bg">
	<div class="container">
    	<div class="row">
        	<h2><?php _e( 'Ver más promociones <br> <span>en', 'project045' ); ?> <?php echo $zone_data['name']; ?></span></h2>
            
            <div class="merbella_slider_area"> 
            
            <div id="merbellaslider" class="owl-carousel">
                
                <?php foreach( $more_promos as $development ) { ?>
                <a href="<?php echo $development['url']; ?>">                
            	<div class="item">
                   <div class="col-md-12">   
                            <div class="thumbnail clearfix">
                                <div class="heartsymbol">
                                    <?php the_favorites_button( $development['id'] ); ?>
                                </div>
                                <div class="propertyimg">
                                    <img class="group list-group-image" src="<?php echo $development['thumbnail_list']; ?>" alt="<?php echo $development['name']; ?>" />
                                    <?php if( $development['construction_started'] ) { ?>
                                        <div class="badge-construction">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/badge-construction-<?php echo pll_current_language(); ?>.png" alt="construction" />
                                        </div>
                                    <?php } ?>                                   
                                </div>
                                <div class="caption">
                                    <h2><span class="notranslate"><?php echo $development['name']; ?></span></h2>
                                    <h3><span class="notranslate"><?php echo $development['zone']; ?></span></h3>
                                    <p class="group inner list-group-item-text"><?php echo $development['excerpt']; ?></p>
                                <ul>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon17.png" alt=""> <p><span><?php _e( 'desde', 'project045' ); ?></span> <?php echo $development['price_min']; ?></p></li>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon18.png" alt=""><p><span><?php _e( 'desde', 'project045' ); ?></span> <?php echo $development['rooms_min']; ?> <?php Project045_Functions::render_rooms_literal( $development['rooms_min'] ); ?></p> </li>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon19.png" alt=""><p><span><?php _e( 'desde', 'project045' ); ?></span> <?php echo $development['size_min']; ?> m2</p></li>
                                </ul>
                                </div>
                            </div>
                    </div>
                </div>
                </a>
                <?php } ?>

            </div>
        </div>
    </div>

</section>



        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo Project045_Definitions::$maps_api_key; ?>&libraries=places&language=es&callback=initialise"></script>

        <script>
            var template_url = '<?php echo get_stylesheet_directory_uri(); ?>';
            var promo_id = '<?php the_ID(); ?>';
            var promo_ref = '<?php the_title(); ?>';
            var promo_witei = '<?php echo $promo_data['ref']; ?>';
            var lat,lng,marker,map,latlng,mapOptions,arrayMarkers,marker;
            function initialise() {
                lat = <?php echo $promo_data['lat']; ?>;
                lng = <?php echo $promo_data['lng']; ?>;
                marker = null;
                arrayMarkers = [];
                map = null;
                latlng = new google.maps.LatLng(lat, lng);
                mapOptions = {
                    zoom: 13,
                    center: latlng,
                    fullscreenControl: false,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.TOP_RIGHT
                    },    
                    gestureHandling: 'greedy',                
                    styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]                                
                }
                map = new google.maps.Map(document.getElementById('responsive_map'), mapOptions);
                map.setCenter(latlng);     
                crearMarcadorViviendas();
            }

    function crearMarcadorViviendas() {

      var myLatlng = new google.maps.LatLng(lat,lng);

      infowindow = new google.maps.InfoWindow;
      google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
      });    

      marker = new google.maps.Marker({
        map: map,
        position: myLatlng,
        icon: template_url + "/images/map_pin.png"
      });      

      marker.htmlString = "";
      marker.htmlString += '<div class="window-info-map">';
      marker.htmlString += '    <h4><?php the_title(); ?></h4>';
      marker.htmlString += '	<p class="text_assoc"><?php echo $promo_data['address']?></p>';
      marker.htmlString += '</div>';          
      
      infowindow.setContent (marker.htmlString);
      infowindow.open(map, marker); 

      /*
      google.maps.event.addListener(marker, 'click' ,function(){
        infowindow.setContent (marker.htmlString);
        infowindow.open(map, marker);          
        render_info_window(this);
      });
      */          

    }

    function showServices(type, imagen){
          request = {
              location: {lat:lat, lng:lng},
              radius: '15000',
              types: [type]
          };
           
          service = new google.maps.places.PlacesService(map);
          service.nearbySearch(request, callback);
          
      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i],imagen);
          }
        }
      }
    }

    function createMarker(place,imagen) {
      var placeLoc = place.geometry.location;
      var iconImg = template_url + "/images/icon-"+imagen+".png";
      var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        icon: iconImg
      });

      var infowindow2 = new google.maps.InfoWindow({});


      arrayMarkers.push(marker);
    
      google.maps.event.addListener(marker, 'mouseover', function() {
        infowindow2.setContent(place.name);
        infowindow2.open(map, this);
      });
      
      google.maps.event.addListener(marker, 'mouseout', function() {
        infowindow2.close(map, this);
      });

    }

    function clearOverlays(){
      if (arrayMarkers) {
        i = 0;
        for (i in arrayMarkers) {
          arrayMarkers[i].setMap(null);
        }
      }
    }


jQuery(document).ready(function($) {

    $('.boton_maps').click(function(){
       if($(this).hasClass('active')){
          $(this).removeClass('active');
          clearOverlays();

          $(".boton_maps.active" ).each(function( index, value ) {
            var tipo = $(value).attr('data-type')

            switch (tipo){
              case "educacion":
                  showServices("school", tipo);
                  showServices("university", tipo);
              break;
              case "sanitario":
                  showServices("pharmacy", tipo);
                  showServices("hospital", tipo);
                  showServices("doctor", tipo);
                  showServices("veterinary_care", tipo);
              break;
              case "comercial":
                  showServices("bakery", tipo);
                  showServices("store", tipo);
                  showServices("shopping_mall", tipo);
              break;
              case "restaurantes":
                  showServices("restaurant", tipo);
              break;
              case "transportes":
                  showServices("taxi_stand", tipo);
                  showServices("bus_station", tipo);
                  showServices("train_station", tipo);
                  showServices("subway_station", tipo);
                  showServices("airport", tipo);
              break;

            }

          });

       }else{
          $(this).addClass('active');
           var tipo = $(this).attr('data-type');
            switch (tipo){
              case "educacion":
                  showServices("school", tipo);
                  showServices("university", tipo);
              break;
              case "sanitario":
                  showServices("pharmacy", tipo);
                  showServices("hospital", tipo);
                  showServices("doctor", tipo);
                  showServices("veterinary_care", tipo);
              break;
              case "comercial":
                  showServices("bakery", tipo);
                  showServices("store", tipo);
                  showServices("shopping_mall", tipo);
              break;
              case "restaurantes":
                  showServices("restaurant", tipo);
              break;
              case "transportes":
                  showServices("taxi_stand", tipo);
                  showServices("bus_station", tipo);
                  showServices("train_station", tipo);
                  showServices("subway_station", tipo);
                  showServices("airport", tipo);
              break;

            }
       }
    });


});

</script>

<?php get_template_part( 'partials/modals', 'development' ); ?>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>