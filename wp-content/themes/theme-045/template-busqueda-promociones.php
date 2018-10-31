<?php 

/**
 * Template name: Búsqueda de promociones
 */

get_header(); 

$array_developments = Project045_Development::get_search_results();

$mobile_detect = new Mobile_Detect();

?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/development_banner.jpg)">
	<div class="container">
      <h1>
        <?php 
          $title = get_the_title();
          if( $mobile_detect->isMobile() ) {
            $title = str_replace( array( ' on map', ' en el mapa' ), array( '', '' ), $title );
          } 
          echo $title;
        ?>
      </h1>
    </div>
</section>


<?php Project045_Functions::render_search( 1 ); ?>


<section class="busqueda_mapa clearfix">

  <div class="busqueda_mapa_map">

    <?php if( !$mobile_detect->isMobile() ) { ?>
    
    <div id="map" style="width:50%;height:850px;float:right"></div>

    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&language=es&key=<?php echo Project045_Definitions::$maps_api_key; ?>"></script>

    <script>
      var array_locations = new Array();
      var array_markers = new Array();

      <?php foreach( $array_developments as $development ) { ?>
        var city = {name: "<?php echo str_replace( "\"", "'", $development['name'] ); ?>", address: "<?php echo str_replace( "\"", "'", $development['address'] ); ?>", lat: "<?php echo $development['lat']; ?>", lng: "<?php echo $development['lng']; ?>", url: "<?php echo $development['url']; ?>", image: "<?php echo $development['thumbnail_list']; ?>"};
        array_locations.push(city);
      <?php } ?>  

      <?php 
        if( isset( $_GET['zone'] ) && intval( $_GET['zone'] ) > 0 ) {
          $zone_data = Project045_Zona::get_zone_data( intval( $_GET['zone'] ) ); 
          $lat = $zone_data['lat'];
          $lng = $zone_data['lng'];
        } else {
          $lat = 36.510071;
          $lng = -4.882447;
        }
      ?>
        
      function initialise() {
        var window_html = '';
        var marker_image = new google.maps.MarkerImage('<?php echo get_stylesheet_directory_uri(); ?>/images/icon-map-marker.png', new google.maps.Size(34, 50));        
        var zone = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>}
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: zone,
          gestureHandling: 'greedy',
          styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]                    
        });
        
        /*
        infowindow = new google.maps.InfoWindow;
        google.maps.event.addListener(map, 'click', function() {
          infowindow.close();
        });
        */        

        for(var i=0;i<array_locations.length;i++) {
          var latLng = new google.maps.LatLng(array_locations[i].lat,array_locations[i].lng);
          var marker = new google.maps.Marker({
            position: latLng,
            title: array_locations[i].name,
            icon: marker_image      
          });
          marker.htmlString = "";
          marker.htmlString += '<div class="window-info-map">';
          marker.htmlString += '    <p><a href="' +  array_locations[i].url +  '" title=""><img src="' + array_locations[i].image + '" /></a></p>';
          marker.htmlString += '    <h4>' + array_locations[i].name + '</h4>';
          marker.htmlString += '		<p class="text_assoc">' + array_locations[i].address + '</p>';
          marker.htmlString += '		<p><a href="' +  array_locations[i].url +  '" title=""><?php _e( 'Ver promoción', 'project045' ); ?></a></p>';
          marker.htmlString += '</div>';          
          array_markers.push(marker); 

          window_html = "";
          window_html += '<div class="window-info-map">';
          window_html += '    <p><a href="' +  array_locations[i].url +  '" title=""><img src="' + array_locations[i].image + '" /></a></p>';
          window_html += '    <h4>' + array_locations[i].name + '</h4>';
          window_html += '		<p class="text_assoc">' + array_locations[i].address + '</p>';
          window_html += '		<p><a href="' +  array_locations[i].url +  ' " title=""><?php _e( 'Ver promoción', 'project045' ); ?></a></p>';
          window_html += '</div>';   

          infowindow = new google.maps.InfoWindow({
            content: window_html
          });
          google.maps.event.addListener(map, 'click', function() {
            infowindow.close();
          });               
          infowindow.open(map, marker); 
          /*google.maps.event.addListener(marker, 'click' ,function(){
            render_info_window(this);
          });*/               
        }

        var styles = [{
          url: '<?php echo get_stylesheet_directory_uri(); ?>/images/icon-map-small.png',
          height: 44,
          width: 44,
          textColor: '#ffffff',
          textSize: 19
        }, {
          url: '<?php echo get_stylesheet_directory_uri(); ?>/images/icon-map-medium.png',
          height: 55,
          width: 55,
          textColor: '#ffffff',
          textSize: 19
        }, {
          url: '<?php echo get_stylesheet_directory_uri(); ?>/images/icon-map-big.png',
          height: 77,
          width: 77,
          textColor: '#ffffff',
          textSize: 19
        }];
        
        var markerCluster = new MarkerClusterer(map, array_markers, {styles: styles});
      }

      function render_info_window(marker){
        infowindow.setContent (marker.htmlString);
        infowindow.open(map, marker);
      }

      google.maps.event.addDomListener(window, 'load', initialise);
    </script>  
    <?php } ?>
  
  <div class="busqueda_mapa_l">
    
    	<div class="busqueda_mapa_row" id="mapascrollbar">

          <?php foreach( $array_developments as $development ) { ?>
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
                <h2><?php echo $development['name']; ?></h2>
                <h3><?php echo $development['zone']; ?></h3>
                <p class="group inner list-group-item-text"><?php echo $development['excerpt_short']; ?></p>
               <ul>
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon17.png" alt="icon"> <p><?php echo $development['price_min']; ?></p></li>
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon18.png" alt="icon"><p> <?php echo $development['rooms_min']; ?> <?php Project045_Functions::render_rooms_literal( $development['rooms_min'] ); ?></p> </li>
                  <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon19.png" alt="icon"><p><?php echo $development['size_min']; ?> m2</p></li>
               </ul>
            </div>
            </div>
            </a>
          <?php } ?>
          	
      </div>
                
</div>

</div>

</section>

<?php Project045_Functions::show_search_mobile(); ?>

<?php get_footer(); ?>