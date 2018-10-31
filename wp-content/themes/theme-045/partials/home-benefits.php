<?php

$benefits_intro = get_field( '_flaats_benefits_intro' );

$benefits = array();
for( $i = 1; $i < 5; $i++ ) {
    while( have_rows( '_flaats_benefits_section' . $i ) ) {
        the_row();
        $title = get_sub_field( 'title' );
        $text = get_sub_field( 'text' );
        $pic = get_sub_field( 'pic' );
        $benefits['section' . $i] = array( $title, $text, $pic );
    }
}

?>



<section class="benifits_home">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<h3><?php _e( 'Beneficios de comprar con', 'flaats' ); ?></h3>
                <h2><span class="notranslate">dream<em>homes</em></span> </h2>
                <h4><?php echo $benefits_intro; ?></h4>
            </div>
        </div>
        
        <div class="benifits_list">
        <div class="row">
        	<div class="col-md-12">
            	<div class="col-md-6">
                	<div class="benifits_details aos-init" data-aos="fade-right" data-aos-duration="2000">
                    	<img src="<?php echo $benefits['section1'][2]; ?>" alt="foto">
                        <div class="benifits_info">
                        	<h4 class="title"><?php echo $benefits['section1'][0]; ?></h4>
                            <?php echo wpautop( $benefits['section1'][1] ); ?>
                        </div>
                    </div>
                    
                    <div class="benifits_details aos-init" data-aos="fade-right" data-aos-duration="2000">
                    	<img src="<?php echo $benefits['section3'][2]; ?>" alt="foto">
                        <div class="benifits_info">
                        	<h4 class="title"><?php echo $benefits['section2'][0]; ?></h4>
                            <?php echo wpautop( $benefits['section2'][1] ); ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img13.jpg" alt="foto">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                	<div class="benifits_right aos-init" data-aos="fade-left" data-aos-duration="2000">
                    	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img_png.png" alt="foto">
                    </div>
                    
                    <div class="benifits_details aos-init" data-aos="fade-left" data-aos-duration="2000">
                    	<img src="<?php echo $benefits['section2'][2]; ?>" alt="foto">
                        <div class="benifits_info padding_l">
                        	<h4 class="title"><?php echo $benefits['section3'][0]; ?></h4>
                            <?php echo wpautop( $benefits['section3'][1] ); ?>
                        </div>
                    </div>
                    
                    <div class="benifits_details aos-init" data-aos="fade-left" data-aos-duration="2000">
                    	<img src="<?php echo $benefits['section4'][2]; ?>" alt="foto">
                        <div class="benifits_info padding_l" >
                        	<h4 class="title"><?php echo $benefits['section4'][0]; ?></h4>
                            <?php echo wpautop( $benefits['section4'][1] ); ?>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        </div>
    </div>
</section>