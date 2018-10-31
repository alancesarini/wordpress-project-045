<?php

if( !class_exists( 'Project045_Functions' ) ) {

	class Project045_Functions {

		private static $_this;

		private static $_version;

		private static $amenities;

		function __construct() {
		
			self::$_this = $this;

			self::$_version = '1.0.0';	

		}

		/*-----------------------------------------------------------------------------------*/		
		// Get parameters for the search forms
		/*-----------------------------------------------------------------------------------*/		
		function get_search_params() {

			$selected_zone = intval( $_GET['zone'] );
			$selected_type = sanitize_text_field( $_GET['type'] );
			$selected_price_min = intval( $_GET['price_min'] );
			$selected_price_max = intval( $_GET['price_max'] );
			$selected_rooms = intval( $_GET['rooms'] );
			$selected_amenities = $_GET['amenities'];
			if( !$selected_amenities ) {
			  $selected_amenities = array();
			}
			$nightlife = intval( $_GET['nightlife'] );			
			$beach = intval( $_GET['beach'] );			
			$shops = intval( $_GET['shops'] );			
			$eating = intval( $_GET['eating'] );			
			$golf = intval( $_GET['golf'] );			
			$port = intval( $_GET['port'] );			
			$culture = intval( $_GET['culture'] );			
			$family = intval( $_GET['family'] );	

			$params = array(
				'zone' => $selected_zone,
				'type' => $selected_type,
				'price_min' => $selected_price_min,
				'price_max' => $selected_price_max,
				'rooms' => $selected_rooms,
				'amenities' => $selected_amenities,
				'nightlife' => $nightlife,
				'beach' => $beach,
				'shops' => $shops,
				'eating' => $eating,
				'golf' => $golf,
				'port' => $port,
				'culture' => $culture,
				'family' => $family
			);

			return $params;

		}

		/*-----------------------------------------------------------------------------------*/
		// Render the search form for the developments
		/*-----------------------------------------------------------------------------------*/		
		function render_search_developments() {

			$params = self::get_search_params();

		  ?>


		<form action="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'buscar-en-el-mapa'; else echo 'find-on-map'; ?>" method="GET">
        <div class="topsearch clearfix">
        <div class="first_select">
					<select id="area" name="zone">
					<option value="-1"><?php _e( 'Area', 'project045' ); ?></option>
				  <?php 
					$args = array(
					  'post_type' => 'zona',
					  'post_status' => 'publish',
					  'posts_per_page' => -1,
					  'orderby' => 'title',
					  'order' => 'ASC'
					);
					$query = new WP_Query( $args );
					while( $query->have_posts() ) {
					  $query->the_post();
					  $id = get_the_ID();
					  $name = get_the_title();
					  echo "<option value='$id'";
					  if( $id == $params['zone'] ) echo ' selected';
					  echo ">$name</option>";
					}
					wp_reset_postdata();
				  ?>
				  </select>
        </div>
        <div class="second_select">
					<select id="type" name="type">
					<option value="-1"><?php _e( 'Tipo', 'project045' ); ?></option>
				  <?php 
					$types = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );
					foreach( $types as $type ) {
					  echo "<option value='$type->slug'";
					  if( $type->slug == $params['type'] ) echo ' selected';
					  echo ">$type->name</option>";
					}
				  ?> 
				  </select>
        </div>
        <div class="forth_select">
            <select name="price_min" id="minprice">
									<option value="0"><?php _e( 'Precio mínimo', 'project045' ); ?></option>
									<?php for( $i = 100000; $i <= 2000000; $i+=50000 ) { ?>
										<?php if( $i <= 1000000 || 1500000 == $i || 2000000 == $i ) { ?>
											<option value="<?php echo $i; ?>" <?php if( $i == $params['price_min'] ) echo ' selected'; ?>><?php echo Project045_Functions::format_price( $i ); ?></option>
										<?php } ?>
									<?php } ?>
            </select>
        </div>
        <div class="fifth_select">
            <select name="price_max" id="maxprice">
									<option value="0"><?php _e( 'Precio máximo', 'project045' ); ?></option>			
									<?php for( $i = 150000; $i <= 5000000; $i+=50000 ) { ?>	
										<?php if( $i <= 1000000 || 1500000 == $i || 2000000 == $i || 2500000 == $i || 3000000 == $i || 5000000 == $i ) { ?>
											<option value="<?php echo $i; ?>" <?php if( $i == $params['price_max'] ) echo ' selected'; ?>><?php echo Project045_Functions::format_price( $i ); ?></option>
										<?php } ?>
									<?php } ?>
            </select>
        </div>
        <div class="filter_search">
            <input type="submit" name="" value="<?php _e( 'buscar', 'project045' ); ?>" class="input_search">
        </div>
        </div>
        
        <div class="showfilter">
            <a href="javascript:void(0);" id="showfilter"><?php _e( 'MOSTRAR FILTROS', 'project045' ); ?> <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/select.png" alt="icono"></a>
            <div class="filterfield clearfix" id="showfilterinfo">
                <div class="rooms">
								<select id="rooms" name="rooms">
									<option value="-1"><?php _e( 'Habitaciones', 'project045' ); ?></option>
									<?php for( $i = 1; $i < 6; $i++ ) { ?>	
									<option value="<?php echo $i; ?>" <?php if( $i == $params['rooms'] ) echo 'selected'; ?> ><?php echo $i; ?></option>
									<?php } ?>
								</select>
                </div>

                <ul>
								<?php 
									if( 'en' == pll_current_language() ) {
										self::$amenities = array( 'beachfront', 'golf', 'urban-area', 'countryside', 'sea-views', 'panoramic-views', 'swimming-pool', 'spa', 'gym', 'garden', 'private-security' );
									} else {
										self::$amenities = array( 'frente-a-la-playa', 'campo-de-golf-cercano', 'area-urbana', 'en-el-campo', 'vistas-al-mar', 'vistas-panoramicas', 'piscina-colectiva', 'spa-es', 'gimnasio', 'jardín', 'seguridad-privada' );				
									}								
									$i = 1;
									foreach( self::$amenities as $amenity_slug ) {
										$amenity = get_term_by( 'slug', $amenity_slug, 'amenity' );
										echo "<li><input type='checkbox' id='chk_amenity_$i' name='amenities[]' value='$amenity->slug'";
										if( in_array( $amenity->slug, $params['amenities'] ) ) echo ' checked';
										echo "/> <label for='chk_amenity_$i'>$amenity->name</label></li>";
										$i++;
									}
								?>
                </ul>
            </div>
        </div>
        
     </form>

		<?php
		}

		/*-----------------------------------------------------------------------------------*/
		// Render the search form for lifestyle
		/*-----------------------------------------------------------------------------------*/		
		function render_search_lifestyle() {

			$params = self::get_search_params();
		
		?>
			<form action="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'areas-es'; else echo 'areas'; ?>" method="GET">

				<div class="col-md-6">
				<div class="progress_br clearfix">
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'VIDA NOCTURNA', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="nightlife" min="1" max="5" step="1" value="<?php echo $params['nightlife']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'TIENDAS', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="shops" min="1" max="5" step="1" value="<?php echo $params['shops']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'GOLF', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="golf" min="1" max="5" step="1" value="<?php echo $params['golf']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'CULTURA', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="culture" min="1" max="5" step="1" value="<?php echo $params['culture']; ?>" />
										</div>
								</div>
						</div>
						
						</div>                    
				</div>
				
				<div class="col-md-6">
						<div class="progress_br clearfix">
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'PLAYA / BAÑO', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="beach" min="1" max="5" step="1" value="<?php echo $params['beach']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'RESTAURANTES', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="eating" min="1" max="5" step="1" value="<?php echo $params['eating']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'PUERTO DEPORTIVO', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="port" min="1" max="5" step="1" value="<?php echo $params['port']; ?>" />
										</div>
								</div>
						</div>
						
						<div class="bar_row clearfix">
								<div class="bar_name"><?php _e( 'FAMILIA', 'project045' ); ?>:</div>
								<div class="range_bar">
										<div>
											<input type="range" name="family" min="1" max="5" step="1" value="<?php echo $params['family']; ?>" />
										</div>
								</div>
						</div>
						
						</div>
				</div>

        <input type="submit" name="" value="<?php _e( 'buscar', 'project045' ); ?>" class="input_search">				

			</form>		
		<?php
		
		}

		/*-----------------------------------------------------------------------------------*/				
		// Render the search tabs
		/*-----------------------------------------------------------------------------------*/				
		function render_search( $active_tab ) {

			$params = self::get_search_params();

			$mobile_detect = new Mobile_Detect();			
			
		?>

			<section class="innerpage_filter">
				<div class="container">
					<div class="filter_area filter_innerpage">
						<div class="icon_bar">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon2-<?php echo pll_current_language(); ?>.png" alt="icono">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-best-price-<?php echo pll_current_language(); ?>.png" alt="icono">
						</div>
						<div class="tabs clearfix">
			
	        				<h2><?php if( $mobile_detect->isMobile() ) { _e( 'BUSCAR PROMOCIONES', 'project045' ); } else { _e( 'BUSCAR EN EL MAPA', 'project045' ); } ?></h2>
							<div>
								<div class="filter_div clearfix">
									<form action="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'buscar-en-el-mapa'; else echo 'find-on-map'; ?>" method="GET">
										
										<div class="topsearch clearfix">
											<div class="first_select">
												<select id="area" name="zone">
													<option value="-1"><?php _e( 'Area', 'project045' ); ?></option>
													<?php 
													$args = array(
													'post_type' => 'zona',
													'post_status' => 'publish',
													'posts_per_page' => -1,
													'orderby' => 'title',
													'order' => 'ASC'
													);
													$query = new WP_Query( $args );
													while( $query->have_posts() ) {
													$query->the_post();
													$id = get_the_ID();
													$name = get_the_title();
													echo "<option value='$id'";
													if( $id == $params['zone'] ) echo ' selected';
													echo ">$name</option>";
													}
													wp_reset_postdata();
													
													?>
												</select>
											</div>

											<div class="second_select">
												<select id="type" name="type">
													<option value="-1"><?php _e( 'Tipo', 'project045' ); ?></option>
													<?php 
													$types = get_terms( array( 'taxonomy' => 'property_type', 'hide_empty' => false ) );
													foreach( $types as $type ) {
													echo "<option value='$type->slug'";
													if( $type->slug == $params['type'] ) echo ' selected';
													echo ">$type->name</option>";
													}
													?> 
												</select>
											</div>

											<div class="forth_select">
												<select name="price_min" id="minprice">
																		<option value="0"><?php _e( 'Precio mínimo', 'project045' ); ?></option>
																		<?php for( $i = 100000; $i <= 2000000; $i+=50000 ) { ?>
																			<?php if( $i <= 1000000 || 1500000 == $i || 2000000 == $i ) { ?>
																				<option value="<?php echo $i; ?>" <?php if( $i == $params['price_min'] ) echo ' selected'; ?>><?php echo Project045_Functions::format_price( $i ); ?></option>
																			<?php } ?>
																		<?php } ?>
												</select>
											</div>
											<div class="fifth_select">
												<select name="price_max" id="maxprice">
																		<option value="0"><?php _e( 'Precio máximo', 'project045' ); ?></option>			
																		<?php for( $i = 150000; $i <= 5000000; $i+=50000 ) { ?>	
																			<?php if( $i <= 1000000 || 1500000 == $i || 2000000 == $i || 2500000 == $i || 3000000 == $i || 5000000 == $i ) { ?>
																				<option value="<?php echo $i; ?>" <?php if( $i == $params['price_max'] ) echo ' selected'; ?>><?php echo Project045_Functions::format_price( $i ); ?></option>
																			<?php } ?>
																		<?php } ?>
												</select>
											</div>

											<div class="filter_search">
												<input type="submit" name="" value="<?php _e( 'BUSCAR', 'project045' ); ?>" class="input_search">
											</div>
										</div>
						
										<div class="showfilter">
											<a href="javascript:void(0);" id="showfilter"><?php _e( 'MOSTRAR FILTROS', 'project045' ); ?> <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/select.png" alt="icono"></a>
											<div class="filterfield clearfix" id="showfilterinfo">
												<div class="rooms">
													<select id="rooms" name="rooms">
														<option value="-1"><?php _e( 'Habitaciones', 'project045' ); ?></option>														
														<?php for( $i = 1; $i < 6; $i++ ) { ?>
														<option value="<?php echo $i; ?>" <?php if( $i == $params['rooms'] ) echo 'selected'; ?> ><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
												<ul>
												<?php 
													if( 'en' == pll_current_language() ) {
														self::$amenities = array( 'beachfront', 'golf', 'urban-area', 'countryside', 'sea-views', 'panoramic-views', 'swimming-pool', 'spa', 'gym', 'garden', 'private-security' );
													} else {
														self::$amenities = array( 'frente-a-la-playa', 'campo-de-golf-cercano', 'area-urbana', 'en-el-campo', 'vistas-al-mar', 'vistas-panoramicas', 'piscina-colectiva', 'spa-es', 'gimnasio', 'jardín', 'seguridad-privada' );				
													}												
													$i = 1;
													foreach( self::$amenities as $amenity_slug ) {
														$amenity = get_term_by( 'slug', $amenity_slug, 'amenity' );
														echo "<li><input type='checkbox' id='chk_amenity_$i' name='amenities[]' value='$amenity->slug'";
														if( in_array( $amenity->slug, $params['amenities'] ) ) echo ' checked';
														echo "/> <label for='chk_amenity_$i'>$amenity->name</label></li>";
														$i++;
													}
												?>								
												</ul>
											</div>
										</div>
						
									</form>
								</div>
							</div>

							<h2 <?php if( 2 == $active_tab ) { ?>class="active-tab"<?php } ?>><?php _e( 'BUSCAR LIFESTYLE', 'project045' ); ?></h2>	
							<div <?php if( 2 == $active_tab ) { ?>class="active-panel"<?php } ?>>
								<div class="filter_div clearfix">
									<form action="<?php echo pll_home_url(); ?><?php if( 'es' == pll_current_language() ) echo 'areas-es'; else echo 'areas'; ?>" method="GET">							
									
										<div class="col-md-6">
											<div class="progress_br clearfix">

												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'VIDA NOCTURNA', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="nightlife" min="1" max="5" step="1" value="<?php echo $params['nightlife']; ?>" />
														</div>
													</div>
												</div>
						
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'TIENDAS', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="shops" min="1" max="5" step="1" value="<?php echo $params['shops']; ?>" />
														</div>
													</div>
												</div>
						
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'GOLF', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="golf" min="1" max="5" step="1" value="<?php echo $params['golf']; ?>" />
														</div>
													</div>
												</div>
												
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'CULTURA', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="culture" min="1" max="5" step="1" value="<?php echo $params['culture']; ?>" />
														</div>
													</div>
												</div>
												
											</div>                    
										</div>
										
										<div class="col-md-6">
											<div class="progress_br clearfix">
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'PLAYA / BAÑO', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="beach" min="1" max="5" step="1" value="<?php echo $params['beach']; ?>" />
														</div>
													</div>
												</div>
												
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'RESTAURANTES', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="eating" min="1" max="5" step="1" value="<?php echo $params['eating']; ?>" />
														</div>
													</div>
												</div>
												
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'PUERTO DEPORTIVO', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="port" min="1" max="5" step="1" value="<?php echo $params['port']; ?>" />
														</div>
													</div>
												</div>
												
												<div class="bar_row clearfix">
													<div class="bar_name"><?php _e( 'FAMILIA', 'project045' ); ?>:</div>
													<div class="range_bar">
														<div>
															<input type="range" name="family" min="1" max="5" step="1" value="<?php echo $params['family']; ?>" />
														</div>
													</div>
												</div>
												
											</div>
										</div>

        								<input type="submit" name="" value="<?php _e( 'buscar', 'project045' ); ?>" class="input_search">	
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php
		}

		/*-----------------------------------------------------------------------------------*/				
		// Get post content by ID
		/*-----------------------------------------------------------------------------------*/				
		function get_the_content_by_id( $post_id=0, $more_link_text = null, $stripteaser = false ) {
			global $post;
			$post = &get_post($post_id);
			setup_postdata( $post, $more_link_text, $stripteaser );
			$content = get_the_content();
			wp_reset_postdata( $post );
			return $content;
		}		

		/*-----------------------------------------------------------------------------------*/						
		// Render the popup with favorites in the header
		/*-----------------------------------------------------------------------------------*/				
		function render_popup_favorites() {

			if( is_user_logged_in() ) {
				$favorites = get_user_favorites();
				if( count( $favorites ) > 0 ) {
					$html = "<ul class='clearfix'>";
					foreach( $favorites as $favorite ) {
						$name = get_the_title( $favorite );
						$thumbnail = get_the_post_thumbnail_url( $favorite, 'thumbnail' );
						$html .= "<li><img src='" . $thumbnail . "' /><a href='" . get_the_permalink( $favorite ) . "'>" . $name . "</a></li>";
					}
					$html .= "</ul>";
				} else {
					$html = __( 'Aún no has guardado ningún favorito.', 'project045' );
				}
			} else {
				$html = "<a href='#' class='login button-login' data-toggle='modal'>" . __( 'ACCEDER', 'project045' ) . "</a>";
				$html .= "<a href='#' class='signup button-register' data-toggle='modal'>" . __( 'REGISTRO', 'project045' ) . "</a>";
			}
			?>

      	<div class="wishlist">
          <a class="wishicon" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-heart.png" alt="favorites"></a>
        	<div class="wishlist_area clearfix">
            	<?php echo $html; ?>
            </div>
        </div>

			<?php
		}	

		/*-----------------------------------------------------------------------------------*/										
		// Format prices
		/*-----------------------------------------------------------------------------------*/										
		function format_price( $price ) {

			setlocale(LC_MONETARY, 'es_ES.UTF-8');
			return money_format( '%.0n', $price );

		}

		/*-----------------------------------------------------------------------------------*/												
		// Generate an excerpt, it if doesn't exist
		/*-----------------------------------------------------------------------------------*/												
		function get_excerpt( $post_id, $words = 20 ) {

			global $post;
			$post = get_post( $post_id );
			if ( empty( $post->post_excerpt ) ) {
				$excerpt = wp_kses_post( wp_trim_words( $post->post_content, $words ) );
			} else {
				$excerpt = wp_kses_post( $post->post_excerpt ); 
			}

			return $excerpt;

		}

		/*-----------------------------------------------------------------------------------*/										
		// Format text in 2 columns
		/*-----------------------------------------------------------------------------------*/												
		function multi_col_text($content){
			// run through a couple of essential tasks to prepare the content
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
		 
			// the first "more" is converted to a span with ID
			$columns = preg_split('/(<span id="more-\d+"><\/span>)|(<!--more-->)<\/p>/', $content);
			$col_count = count($columns);
		 
			if($col_count > 1) {
				for($i=0; $i<$col_count; $i++) {
					// check to see if there is a final </p>, if not add it
					if(!preg_match('/<\/p>\s?$/', $columns[$i]) )  {
						$columns[$i] .= '</p>';
					}
					// check to see if there is an appending </p>, if there is, remove
					$columns[$i] = preg_replace('/^\s?<\/p>/', '', $columns[$i]);
					// now add the div wrapper
					$columns[$i] = '<div class="dynamic-col-'.($i+1).'">'.$columns[$i].'</div>';
				}
				$content = join($columns, "\n").'<div class="clear"></div>';
			}
			else {
				// this page does not have dynamic columns
				$content = wpautop($content);
			}
			// remove any left over empty <p> tags
			$content = str_replace('<p></p>', '', $content);
			return $content;
		}

		/*-----------------------------------------------------------------------------------*/														
		// Renders "room" or "rooms" depending on a value. Is translatable
		/*-----------------------------------------------------------------------------------*/														
		function render_rooms_literal( $number ) {

			if( $number > 1 ) {
				_e( 'habs', 'project045' );
			} else {
				_e( 'hab', 'project045' );				
			}

		}

		/*-----------------------------------------------------------------------------------*/																
		// Open the search options in mobile
		/*-----------------------------------------------------------------------------------*/																
		function show_search_mobile() {

			$mobile_detect = new Mobile_Detect();			

			if( $mobile_detect->isMobile() ) { ?>

				<script>
				(function($) {
					$(document).ready(function() {
						setTimeout(function() {
							$('#tablist1-panel1').removeClass('hidden-mobile');
							$('#tablist1-panel1').addClass('active-panel');
						}, 1000);
					});
				})(jQuery);
				</script>
			<?php }

		}

		static function this() {
		
			return self::$_this;
		
		}

	}

}

new Project045_Functions();