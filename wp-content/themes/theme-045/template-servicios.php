<?php 

/**
 * Template name: Nuestros servicios
 */

get_header(); 

while( have_posts() ) {
    the_post();
}

$array_data = array();
for( $i = 1; $i < 7; $i++ ) {
    while( have_rows( '_project045_services_section' . $i ) ) {
        the_row();
        $title = get_sub_field( 'title' );
        $text = get_sub_field( 'text' );
        $pic = get_sub_field( 'pic' );
        $text_button = get_sub_field( 'text_button' );
        $text_popup = get_sub_field( 'text_popup' );
        $link = get_sub_field( 'link' );
        $array_data['section' . $i] = array( 'title' => $title, 'text' => $text, 'pic' => $pic, 'text_button' => $text_button, 'text_popup' => $text_popup, 'link' => $link );
    }
}

$benefits_intro = get_field( '_project045_benefits_intro' );

$benefits = array();
for( $i = 1; $i < 5; $i++ ) {
    while( have_rows( '_project045_benefits_section' . $i ) ) {
        the_row();
        $title = get_sub_field( 'title' );
        $text = get_sub_field( 'text' );
        $pic = get_sub_field( 'pic' );
        $benefits['section' . $i] = array( 'title' => $title, 'text' => $text, 'pic' => $pic );
    }
}

?>




<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/ourservices_banner.jpg)">
	<div class="container">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>

<section class="persentage_bg">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-2" data-aos="fade-right" data-aos-duration="2000">
            	<div class="left_padding">
                 	<h3 class="title"><?php echo $array_data['section1']['title']; ?></h3>                    
                	<?php echo wpautop( $array_data['section1']['text'] ); ?>
                    <a class="button-icon button-arrow" href="<?php echo $array_data['section1']['link']; ?>"><?php echo $array_data['section1']['text_button']; ?></a>
                </div>
            </div>
            
            <div class="col-md-6 aos-init flex-column-1" data-aos="fade-left" data-aos-duration="2000"><img src="<?php echo $array_data['section1']['pic']; ?>" alt="foto"></div>
            
        </div>
    </div>
</section>


<section class="section_field_one">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-1 margin-neg" data-aos="fade-right" data-aos-duration="2000">
            	<img src="<?php echo $array_data['section2']['pic']; ?>" alt="foto">
            </div>
            
            <div class="col-md-6 aos-init flex-column-2" data-aos="fade-left" data-aos-duration="2000">
            	<h3 class="title"><?php echo $array_data['section2']['title']; ?></h3>
                <?php echo wpautop( $array_data['section2']['text'] ); ?>
                <a class="button-icon button-arrow" href="#contact-map"><?php echo $array_data['section2']['text_button']; ?></a>
            </div>
            
            
            
            <div class="gap clearfix"></div>
        
            
            <div class="col-md-6 aos-init flex-column-4" data-aos="fade-right" data-aos-duration="2000">
            	<h3 class="title"><?php echo $array_data['section3']['title']; ?></h3>
                <?php echo wpautop( $array_data['section3']['text'] ); ?>
                <a class="button-icon button-arrow" href="<?php echo $array_data['section3']['link']; ?>"><?php echo $array_data['section3']['text_button']; ?></a>
            </div>
            
                <div class="col-md-6 aos-init flex-column-3" data-aos="fade-left" data-aos-duration="2000">
            	<img src="<?php echo $array_data['section3']['pic']; ?>" alt="foto">
            </div>
            
        </div>
    </div>
</section>


<section class="section_field_two">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-1" data-aos="fade-right" data-aos-duration="2000"><img src="<?php echo $array_data['section4']['pic']; ?>" alt="foto"></div>
            <div class="col-md-6 aos-init flex-column-2" data-aos="fade-left" data-aos-duration="2000">
            	<h3 class="title"><?php echo $array_data['section4']['title']; ?></h3>
                <?php echo wpautop( $array_data['section4']['text'] ); ?>
                <a class="button-icon button-concierge" href="#" data-toggle="modal" data-target="#modal-concierge"><?php echo $array_data['section4']['text_button']; ?></a>
            </div>
        </div>
    </div>
</section>

<section class="section_field_one">
	<div class="container">
    	<div class="row flex">
        	<div class="col-md-6 aos-init flex-column-2" data-aos="fade-right" data-aos-duration="2000">
            	<h3 class="title"><?php echo $array_data['section5']['title']; ?></h3>
                <div class="left_padding_two">
                <?php echo wpautop( $array_data['section5']['text'] ); ?>
                <a class="button-icon button-arrow" href="#" data-toggle="modal" data-target="#modal-lawyer"><?php echo $array_data['section5']['text_button']; ?></a>
                 </div>
            </div>
        	<div class="col-md-6 aos-init flex-column-1 margin-neg" data-aos="fade-left" data-aos-duration="2000">
            	<img src="<?php echo $array_data['section5']['pic']; ?>" alt="foto">
            </div>
            
            
            
            
            <div class="gap clearfix"></div>
        <div class="col-md-6 aos-init flex-column-3" data-aos="fade-right" data-aos-duration="2000">
            	<img src="<?php echo $array_data['section6']['pic']; ?>" alt="foto">
            </div>
            
            <div class="col-md-6 aos-init flex-column-4" data-aos="fade-left" data-aos-duration="2000">
            	<h3 class="title"><?php echo $array_data['section6']['title']; ?></h3>
                <?php echo wpautop( $array_data['section6']['text'] ); ?>
                <a class="button-icon button-newsletter" href="#newsletter-form"><?php echo $array_data['section6']['text_button']; ?></a>
            </div>
            
            
                
            
        </div>
    </div>
</section>

<?php include( 'partials/modals-ourservices.php' ); ?>

<?php get_template_part( 'partials/home', 'benefits' ); ?>

<?php get_template_part( 'partials/contact-map' ); ?>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>