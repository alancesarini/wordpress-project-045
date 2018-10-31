<?php 

/**
 * Template name: Membership
 */

get_header(); 

while( have_posts() ) {
    the_post();
}

while( have_rows( '_flaats_membership_text' ) ) {
    the_row();
    $title1 = get_sub_field( 'title1' );
    $title2 = get_sub_field( 'title2' );
    $title3 = get_sub_field( 'title3' );
    $text = get_sub_field( 'text' );
}

$logos_members = get_field( '_flaats_membership_logos' );

?>

<section class="pagebanner" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/memberbanner.jpg)">
	<div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<section class="member_top">
	<div class="container">
       <div class="row">
       	<div class="col-md-12">
        	<h4><?php echo $title1; ?></h4>
            <h3><?php echo $title2; ?></h3>
            <h2><?php echo $title3; ?></h2>
            <?php echo wpautop( $text ); ?>
        </div>
       </div>
   </div>
</section>


<section class="member_section">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
                
                <?php the_content(); ?>
                

                <div class="current_member">
                    <h3 class="title"><?php _e( 'Miembros', 'flaats' ); ?></h3>
                    <ul>

                        <?php foreach( $logos_members as $logo ) { ?>
                            <li><img src="<?php echo $logo['url']; ?>" alt="logo"></li>
                        <?php } ?>
                        
                    </ul>
                    
                </div>
            
            <div class="member_application">
            	<div class="member_application_heading">
                <h2><?php _e( 'Solicitud', 'flaats' ); ?></h2>
                	<p><?php _e( 'Si es usted un promotor interesado en unirse a la red de DreamHomes, por favor rellene el formulario y un representante se pondrá en contacto con usted en breve.', 'flaats' ); ?></p>
                </div>
                
                <div class="row">
                    <?php echo do_shortcode( '[cf7-form cf7key="formulario-developers"]' ); ?>
                </div>
                
            </div>
            
            
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'partials/subscription' ); ?>

<?php get_footer(); ?>