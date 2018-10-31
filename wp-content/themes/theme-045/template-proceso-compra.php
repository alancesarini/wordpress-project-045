<?php 

/**
 * Template name: Proceso de compra
 */

get_header(); 

while( have_posts() ) {
    the_post();
}

$array_data = array();
for( $i = 1; $i < 8; $i++ ) {
    while( have_rows( '_flaats_purchase_step' . $i ) ) {
        the_row();
        $title = get_sub_field( 'title' );
        $text = get_sub_field( 'text' );
        $icon = get_sub_field( 'icon' );
        $text_button = get_sub_field( 'text_button' );
        $text_popup = get_sub_field( 'text_popup' );
        $array_data['step' . $i] = array( 'title' => $title, 'text' => $text, 'icon' => $icon, 'text_button' => $text_button, 'text_popup' => $text_popup );
    }
}

$title_top1 = get_field( '_flaats_purchase_intro_title1' );
$title_top2 = get_field( '_flaats_purchase_intro_title2' );
$title_top3 = get_field( '_flaats_purchase_intro_title3' );
$title_bottom1 = get_field( '_flaats_purchase_footer_title1' );
$title_bottom2 = get_field( '_flaats_purchase_footer_title2' );


?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/purchasebanner.jpg)">
	<div class="container">
    	<h1><?php the_title(); ?></h1>
    </div>
</section>

<section class="nine_step">
	<div class="container">
    	<div class="row">
        	<h4><?php echo $title_top1; ?></h4>
            <h3><?php echo $title_top2; ?></h3>
            <h2><?php echo $title_top3; ?></h2>
        </div>
    </div>
</section>


<section class="nine_step_details">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<ul>
                    <?php for( $i = 1; $i < 8; $i++ ) { ?>
                        <li class="aos-init" data-aos="fade-up" data-aos-duration="2000">
                            <div class="flex">
                                <div class="flex-column-2">
                                    <div class="step_number"><?php echo $i; ?></div>
                                    <div class="step_text">
                                        <h3 class="title"><?php echo $array_data['step' . $i]['title']; ?></h3>
                                        <?php echo wpautop( $array_data['step' . $i]['text'] ); ?>
                                        <?php if( 5 == $i ) { ?>
                                            <p><a class="button-yellow" href="#" data-toggle="modal" data-target="#modal-lawyer"><?php echo $array_data['step' . $i]['text_button']; ?></a></p>
                                        <?php } elseif( 6 == $i ) { ?>
                                            <p><a class="button-yellow" href="#" data-toggle="modal" data-target="#modal-taxes"><?php echo $array_data['step' . $i]['text_button']; ?></a></p>                                                                        
                                        <?php } ?>                                                                
                                    </div>
                                </div>
                                <div class="step_img flex-column-1"><img src="<?php echo $array_data['step' . $i]['icon']; ?>" alt="icon"></div>
                            </div>
                        </li>
                    <?php } ?>
                   
                </ul>
            </div>
        </div>
        
        <div class="row">
        	<div class="congrats aos-init" data-aos="fade-down" data-aos-duration="2000">
            	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/like.png" alt="like">
            	<h2><?php echo $title_bottom1; ?></h2>
                <h3><?php echo $title_bottom2; ?></h3>
            </div>
        </div>
        
    </div>
</section>

<?php get_template_part( 'partials/contact-map' ); ?>

<?php include( 'partials/modals-purchase.php' ); ?>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>