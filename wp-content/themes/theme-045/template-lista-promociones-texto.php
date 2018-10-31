<?php 

/**
 * Template name: Lista de promociones con texto
 */

get_header(); 

$zone_id = intval( $_GET['z'] );
$order = intval( $_GET['o'] );
 
$query = Flaats_Development::get_developments_by_zone( $zone_id, 0, $order );

$array_developments = array();
while( $query->have_posts() ) {
    $query->the_post();
    $data = Flaats_Development::get_development_data( get_the_ID() );
    $array_developments[] = $data;
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
         <div class="titulo_area clearfix">
         	<div class="col-md-12">
            	<?php the_content(); ?>
            </div>
         </div>
       </div>      
    </div>
</section>

<section class="grideview_area">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            <div class="listmenu">
            	<div class="shortlist">
                    <select id="gridviewlist">
                      <option value="-1"><?php _e( 'Ordenar por', 'flaats' ); ?></option>
                      <option value="1" <?php if( 1 == $order ) { echo 'selected'; } ?>><?php _e( 'Precio', 'flaats' ); ?></option>
                      <option value="2" <?php if( 2 == $order ) { echo 'selected'; } ?>><?php _e( 'Tamaño', 'flaats' ); ?></option>
                      <option value="3" <?php if( 3 == $order ) { echo 'selected'; } ?>><?php _e( 'Habitaciones', 'flaats' ); ?></option>                                
        	        </select>
                </div>
            	<div class="buttngroup">
                	<a href="javascript:void(0);" id="gridview"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gridview.png" alt="icon"></a>
                	<a href="javascript:void(0);" id="listview"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/listview.png" alt="icon"></a>            		
                </div>
                </div>
            </div>
        </div>
        
        <div id="propertylist" class="row list-group">

        <?php foreach( $array_developments as $development ) { ?>
        <a href="<?php echo $development['url']; ?>">
        <div class="propertyitem  col-xs-4 col-lg-4 aos-init" data-aos="fade-up" data-aos-duration="2000">
            <div class="thumbnail clearfix">
            <div class="heartsymbol">
                <?php the_favorites_button( $development['id'] ); ?>
            </div>
            <div class="propertyimg">
                <img class="group list-group-image" src="<?php echo $development['thumbnail_list']; ?>" alt="<?php echo $development['name']; ?>" />
                </div>
                <div class="caption">
                    <h1><?php echo $development['name']; ?></h1>
                    <h2><?php echo $development['zone']; ?></h2>
                    <p class="group inner list-group-item-text"><?php echo $development['excerpt']; ?></p>
                   <ul>
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon17.png" alt="icon"> <p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['price_min']; ?></p></li>
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon18.png" alt="icon"><p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['rooms_min']; ?> <?php Flaats_Functions::render_rooms_literal( $development['rooms_min'] ); ?></p> </li>
                      <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon19.png" alt="icon"><p><span><?php _e( 'desde', 'flaats' ); ?></span> <?php echo $development['size_min']; ?> m2</p></li>
                   </ul>
                </div>
          </div>
        </div>
        </a>
        <?php } ?>
                
       </div>
       
       <div class="row">
       	<div class="pagination">
           <?php if( function_exists( 'wp_pagenavi' ) ) wp_pagenavi( array( 'query' => $query ) ); ?>
        </div>
       </div>
        
    </div>
</section>

<?php get_template_part( 'partials/subscription' ); ?>

<?php Flaats_Functions::show_search_mobile(); ?>

<?php get_footer(); ?>