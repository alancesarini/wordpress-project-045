<?php 

/**
 * Template name: Contacto
 */

get_header(); 

while( have_posts() ) {
    the_post();
}

$title_offices = get_field( '_project045_contact_title' );

$offices = array();
while( have_rows( '_project045_contact_offices' ) ) {
    the_row();
    $name = get_sub_field( 'name' );
    $address = get_sub_field( 'address' );
    $phone = get_sub_field( 'phone' );
    $email = get_sub_field( 'email' );
    $opening = get_sub_field( 'opening' );
    $offices[] = array( 'name' => $name, 'address' => $address, 'phone' => $phone, 'email' => $email, 'opening' => $opening );
}

while( have_rows( '_project045_contact_buyer' ) ) {
    the_row();
    $title_buyer = get_sub_field( 'title' );
    $text_buyer = get_sub_field( 'text' );
}

while( have_rows( '_project045_contact_members' ) ) {
    the_row();
    $title_members = get_sub_field( 'title' );
    $text_members = get_sub_field( 'text' );
}

?>


<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/purchasebanner.jpg)">
	<div class="container">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>


<section class="contact_bg">
	<div class="container">
    	<div class="row">
        	<div class="col-md-6">
            	<div class="address_one">
                	<h3 class="title"><?php echo $title_offices; ?></h3>
                    <h2><?php echo $offices[0]['name']; ?></h2>
                    <p><?php echo $offices[0]['address']; ?></p>
                    <p><?php _e( 'Horario Oficinas', 'project045' ); ?>: <?php echo $offices[0]['opening']; ?></p>
                    <a href="tel:<?php echo $offices[0]['phone']; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ph_01.png" alt="phone"> <?php echo $offices[0]['phone']; ?></a>
                    <a class="cont_info" href="mailto:<?php echo $offices[0]['email']; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mail_02.png" alt="email"> <?php echo $offices[0]['email']; ?></a>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="address_two">
                    <h2><?php echo $offices[1]['name']; ?></h2>
                    <p><?php echo $offices[1]['address']; ?></p>
                    <p><?php _e( 'Horario Oficinas', 'project045' ); ?>: <?php echo $offices[1]['opening']; ?></p>
                    <a href="tel:<?php echo $offices[1]['phone']; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ph_01.png" alt="phone"> <?php echo $offices[1]['phone']; ?></a>
                    <a class="cont_info" href="mailto:<?php echo $offices[1]['email']; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mail_02.png" alt="email"> <?php echo $offices[1]['email']; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contect_seller">
	<div class="container">
    	<div class="col-md-6">
        	<h3 class="title"><?php echo $title_buyer; ?></h3>
            <?php echo wpautop( $text_buyer ); ?>
            
            <div class="socialcontact">
            	<h3 class="title"><?php _e( 'Social media', 'project045' ); ?></h3>
                <ul>
                	<li><a href="https://www.facebook.com/" target="_BLANK"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://twitter.com/" target="_BLANK"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_BLANK"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
            
        </div>
        <div class="col-md-6">
        	<h3 class="title"><?php echo $title_members; ?></h3>
            <?php echo wpautop( $text_members ); ?>
        </div>
    </div>
</section>

<?php get_template_part( 'partials/contact-map' ); ?>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>