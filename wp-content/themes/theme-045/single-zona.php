<?php get_header(); ?>

<?php
while( have_posts() ) {
    the_post();
    
    $lifestyle = array();
    foreach( Flaats_Zona::$array_lifestyle[pll_current_language()] as $param => $text ) {
        $score = get_post_meta( get_the_ID(), '_flaats_zone_lifestyle_' . $param, true );
        $lifestyle[$text] = $score;
    }
    $featured_promo = get_field( get_the_ID(), '_flaats_zone_promo' );
    $promo_data = Flaats_Development::get_development_data( $featured_promo );
    $query_developments = Flaats_Development::get_developments_by_zone( get_the_ID(), 0, 0 );
    $array_developments = array();
    while( $query_developments->have_posts() ) {
        $query_developments->the_post();
        $data = Flaats_Development::get_development_data( get_the_ID() );
        $array_developments[] = $data;
    }    
    $array_zones = Flaats_Zona::get_all_zones( get_the_ID() );   
    $coordinates = get_field( '_flaats_zone_location', get_the_ID() );
    if( $coordinates != false ) {
        $lat = $coordinates['lat'];
        $lng = $coordinates['lng'];       
    } else {
        $lat = 0;
        $lng = 0;
    }
} 
?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/development_banner.jpg)">
	<div class="container">
    	<h1><?php the_title(); ?></h1>
    </div>
</section>

<?php Flaats_Functions::render_search( 1 ); ?>

<section class="fichazona">
	<div class="container">
       <div class="row">
       	<div class="col-md-12">
        	<div class="fichazonabanner">
        	<?php the_post_thumbnail( 'zone-big' ); ?>
            <h2><?php the_title(); ?></h2>
            </div>      
         </div>
         <div class="titulo_area clearfix">
         	<div class="col-md-8">
            	<?php the_content(); ?>
            </div>
            <div class="col-md-4">
            	<div class="small_map">
                    <div id="map" style="width:100%;height:270px"></div>
                </div>
                
                <div class="goog_for">
                	<h5><?php _e( 'Este area es buena para:', 'flaats' ); ?></h5>
                    <ul class="clearfix">
                        <?php foreach( $lifestyle as $text => $value ) { ?>
                            <li>
                                <label><?php echo $text; ?>:</label>
                                <?php for( $i = 1; $i <= $value; $i++ ) { ?>
                                    <span class="star star-active"><i class="fa fa-star"></i></span>
                                <?php } ?>
                                <?php for( $i = ($value+1); $i <= 5; $i++ ) { ?>
                                    <span class="star"><i class="fa fa-star"></i></span>
                                <?php } ?>    
                            </li>
                        <?php } ?>              
                    </ul>
                    <a href="#" class="lifestyle"><?php _e( 'BUSCAR LIFESTYLE', 'flaats' ); ?></a>
                </div>
                
                <?php if( intval( $featured_promo ) > 0 ) { ?>
                <div class="ficha_emare">
                	<div class="section_development_img">
                        <img src="<?php echo $promo_data['thumbnail_featured_small']; ?>" alt="<?php echo $promo_data['name']; ?>">
                        <div class="section_development_details">
                            <h2><?php echo $promo_data['name']; ?></h2>
                            <h3><?php echo $promo_data['zone']; ?></h3>
                            <ul>
                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon10.png" alt="icon"> <?php echo $promo_data['price_min']; ?></li>
                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon11.png" alt="icon"> <?php echo $promo_data['rooms_min']; ?> <?php _e( 'habitaciones', 'flaats' ); ?></li>
                            </ul>
                        </div>
                        <div class="heartsymbol">
                            <?php the_favorites_button( $promo_data['id'] ); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
            </div>
         </div>
       </div>      
    </div>
</section>

<?php if( count( $array_developments ) > 0 ) { ?>

<section class="merbella_slider">
	<div class="container">
    	<div class="row">
        	<h2><?php _e( 'Ver más promociones', 'flaats' ); ?> <br> <span><?php _e( 'en', 'flaats' ); ?> <?php the_title(); ?></span></h2>  
            <div class="merbella_slider_area">
                <div id="merbellaslider" class="owl-carousel">
                    
                <?php foreach( $array_developments as $development ) { ?>
                    <div class="item">
                        <div class="col-md-12">      
                            <a href="<?php echo $development['url']; ?>">   
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
                                    <h2><span class="notranslate"><?php echo $development['name']; ?></span></h3>
                                    <h3><?php _e( 'Promoción en', 'flaats' ); ?> <?php the_title(); ?></h3>
                                    <p class="group inner list-group-item-text"><?php echo $development['excerpt']; ?></p>
                                <ul>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon17.png" alt=""> <p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['price_min']; ?></p></li>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon18.png" alt=""><p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['rooms_min']; ?> <?php Flaats_Functions::render_rooms_literal( $development['rooms_min'] ); ?></p> </li>
                                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon19.png" alt=""><p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['size_min']; ?> m2</p></li>
                                </ul>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                
                </div>
            </div>
        </div>
    </div>    
</section>

<?php } ?>

<section class="homearea">
	<div class="container">
    	<h4><?php _e( 'Otras zonas que', 'flaats' ); ?> <br> <span><?php _e( 'pueden interesarte', 'flaats' ); ?></span></h4>
        
        <div id="homeareas" class="owl-carousel">
            
        <?php foreach( $array_zones as $zone ) { ?>
            <div class="item">
            <div class="col-md-12">
            <div class="homeimg">
                <a href="<?php echo $zone['url']; ?>"><img src="<?php echo $zone['thumbnail_slider']; ?>" alt="<?php echo $zone['name']; ?>"></a>
                <h3><?php echo $zone['name']; ?></h3>
                </div>
                <h2><a href="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'promociones'; else echo 'developments'; ?>?z=<?php echo $zone['id']; ?>"><?php _e( 'VER PROMOCIONES', 'flaats' ); ?></a></h2>                
            </div>
            </div>
        <?php } ?>
        
  </div>
        
    </div>
</section>




<script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key=<?php echo Flaats_Definitions::$maps_api_key; ?>&callback=initialise"></script>

<script>
    var template_url = '<?php echo get_stylesheet_directory_uri(); ?>';
    
    var lat,lng,marcador_viviendas,map,latlng,mapOptions,arrayMarkers,marker;
    function initialise() {
        lat = <?php echo $lat; ?>;
        lng = <?php echo $lng; ?>;
        arrayMarkers = [];
        map = null;
        latlng = new google.maps.LatLng(lat, lng);
        mapOptions = {
            zoom: 16,
            center: latlng,
            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]            
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        map.setCenter(latlng);     
        crearMarcadorViviendas();
    }

    function crearMarcadorViviendas() {

        var myLatlng = new google.maps.LatLng(lat,lng);
        marcador_viviendas = new google.maps.Marker({
            map: map,
            position: myLatlng,
            icon: template_url + "/images/map_pin.png"
        });

    }


</script>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>