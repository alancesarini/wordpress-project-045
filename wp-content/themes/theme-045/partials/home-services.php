<?php

    $services = array();
    while( have_rows( '_project045_home_services' ) ) {
        the_row();
        $title = get_sub_field( 'title' );
        $text = get_sub_field( 'text' );
        $icon = get_sub_field( 'icon' );
        $services[] = array( 'title' => $title, 'text' => $text, 'icon' => $icon );
    }
?>

<section class="section_services">
	<div class="container">
        <h2><span class="notranslate">dream<strong>homes</strong></span> <em><?php _e( 'servicios', 'project045' ); ?></em></h2>
    	<div class="row">

            <?php foreach( $services as $service ) { ?>
                <div class="col-md-4 col-sm-4 col-xs-6 aos-init" data-aos="fade-up" data-aos-duration="2000">
                    <div class="services_list">
                        <img src="<?php echo $service['icon']; ?>" alt="<?php echo $service['title']; ?>">
                        <h3><?php echo $service['title']; ?></h3>
                        <?php echo wpautop( $service['text'] ); ?>
                    </div>
                </div>
            <?php } ?>
            
        </div>
    </div>
</section>