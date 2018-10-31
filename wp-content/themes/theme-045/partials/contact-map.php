<?php 

$page_contact = get_page_by_path( 'contact' );

$offices = array();
while( have_rows( '_project045_contact_offices', $page_contact->ID ) ) {
    the_row();
    $address = get_sub_field( 'address' );
    $address = str_replace( "\r\n", "<br>", $address );
    $phone = get_sub_field( 'phone' );
    $lat = get_sub_field( 'lat' );
    $lng = get_sub_field( 'lng' );
    $offices[] = array( 'name' => $name, 'address' => $address, 'phone' => $phone, 'email' => $email, 'lat' => $lat, 'lng' => $lng );
}

?>

<section class="section_contact clearfix">
    <a name="contact-map"></a>
	<div class="sec_con_left">
        <div id="map" style="width:100%;height:900px;"></div>
    </div>
    <div class="sec_con_right">
    	<h3 class="title"><?php _e( 'Contacto', 'project045' ); ?></h3>
        <?php echo do_shortcode( '[cf7-form cf7key="formulario-de-contacto"]' ); ?>
    </div>
</section>




<script async defer src="https://maps.googleapis.com/maps/api/js?language=es&key=<?php echo Project045_Definitions::$maps_api_key; ?>&callback=initialise"></script>

<script>
    var template_url = '<?php echo get_stylesheet_directory_uri(); ?>';
    
    var lat,lng,marcador_viviendas,map,latlng,mapOptions,arrayMarkers,marker;
    function initialise() {
        lat = <?php echo $offices[0]['lat']; ?>;
        lng = <?php echo $offices[0]['lng']; ?>;
        lat = 36.721274;
        lng = -4.421399;
        arrayMarkers = [];
        map = null;
        latlng = new google.maps.LatLng(lat, lng);
        mapOptions = {
            zoom: 9,
            center: latlng,
            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]            
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        map.setCenter(latlng);     
        
        <?php foreach( $offices as $office ) { ?>
            latlng = new google.maps.LatLng(<?php echo $office['lat']; ?>, <?php echo $office['lng']; ?>);
            var html = "<div class='text-infowindow'><h3 class='text-blue'><span class='notranslate'>dream<strong>homes</strong></span></h3><p><?php echo $office['address']; ?></p><p class='text-yellow'><i class='fa fa-phone'></i> <strong><?php echo $office['phone']; ?></strong></p></div>";
            var infowindow = new google.maps.InfoWindow({
                content: html,
                position: latlng
            });
            infowindow.open(map);
        <?php } ?>

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
