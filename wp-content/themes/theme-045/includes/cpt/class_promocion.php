<?php

if( !class_exists( 'Flaats_Development' ) ) {
	
	class Flaats_Development {

		private static $_version;

		public static $prefix;

		/*-----------------------------------------------------------------------------------*/
		// Class constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {

			self::$_version = '1.0.0';

			self::$prefix = '_flaats_promo_';

			// Register CPT
			add_action( 'init', array( $this, 'register_cpt' ) );	
			
			// Ajax action for downloading the dossier
			add_action( 'wp_ajax_ajaxdownload', array( $this, 'ajax_download_pdf' ) );																						
			add_action( 'wp_ajax_nopriv_ajaxdownload', array( $this, 'ajax_download_pdf' ) );	
			
			// Ajax action for sending the contact to Witei
			add_action( 'wp_ajax_ajaxwitei', array( $this, 'ajax_witei' ) );																						
			add_action( 'wp_ajax_nopriv_ajaxwitei', array( $this, 'ajax_witei' ) );																									

		}

		/*-----------------------------------------------------------------------------------*/
		// Register custom post type "Promoción"
		/*-----------------------------------------------------------------------------------*/
		function register_cpt() {

			$labels = array(
				'name'               => __( 'Promociones' ),
				'singular_name'      => __( 'Promoción' ),
				'add_new'            => __( 'Añade nueva promoción' ),
				'add_new_item'       => __( 'Añade nueva promoción' ),
				'edit_item'          => __( 'Editar' ),
				'new_item'           => __( 'Nueva' ),
				'all_items'          => __( 'Todas' ),
				'view_item'          => __( 'Ver' ),
				'search_items'       => __( 'Buscar' ),
				'not_found'          => __( 'No se han encontrado promociones' ),
				'not_found_in_trash' => __( 'No se han encontrado promociones en la papelera' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Promociones'
			);
			$args = array(
				'labels'        => $labels,
				'description'   => 'Promociones',
				'public'        => true,
				'menu_position' => 21,
				'hierarchical'  => true,
				'supports'      => array( 'title', 'editor', 'thumbnail' ),
				'has_archive'   => true,
				'rewrite'		=> array( 'slug' => 'development', 'with_front' => false )
			);
			register_post_type( 'promocion', $args );		

			register_taxonomy(
                'amenity',
                'promocion',
                array(
                    'labels' => array(
                        'name' => __('Amenities'),
                        'singular_name' => __('Amenities')
                    ),
					'hierarchical' => true,
					'publicly_queryable' => false,
                    'public' => true,
                    'rewrite' => array(
                        'slug' => 'amenity',
                        'with_front' => false,
                    )
                )
			);	

			register_taxonomy(
                'property_type',
                'promocion',
                array(
                    'labels' => array(
                        'name' => __('Tipo de propiedad'),
                        'singular_name' => __('Tipo de propiedad')
                    ),
					'hierarchical' => true,
					'publicly_queryable' => false,
                    'public' => true,
                    'rewrite' => array(
                        'slug' => 'property-type',
                        'with_front' => false,
                    )
                )
			);				
			
		}

		/*-----------------------------------------------------------------------------------*/
		// Get search results
		/*-----------------------------------------------------------------------------------*/		
		function get_search_results() {
			
			$args = array(
				'post_type' => 'promocion',
				'post_status' => 'publish',
				'lang' => 'en',
				'posts_per_page' => -1
			);

			if( isset( $_GET['zone'] ) && $_GET['zone'] != '-1' ) {
				if( 'es' == pll_current_language() ) {
					$zone_id = pll_get_post( intval( $_GET['zone'] ), 'en' );
				} else {
					$zone_id = intval( $_GET['zone'] );
				}
				$args['meta_query'][] = array(
					'key' => '_flaats_promo_zone',
					'value' => $zone_id,
					'compare' => '='
				);
			}

			if( isset( $_GET['type'] ) && $_GET['type'] != '-1' ) {
				if( 'es' == pll_current_language() ) {
					$type_es = get_term_by( 'slug', $_GET['type'], 'property_type' );
					$type_en_id = pll_get_term( $type_es->term_id, 'en' ); 
					$type_en = get_term_by( 'id', $type_en_id, 'property_type' );
					$type_slug = $type_en->slug;
			  	} else {
					$type_slug = sanitize_text_field( $_GET['type'] );
				}					
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'property_type',
						'field' => 'slug',
						'terms' => $type_slug
					)
				);
			}

			if( isset( $_GET['price_min'] ) && intval( $_GET['price_min'] ) > 0 ) {
				if( isset( $args['meta_query'] ) ) {
					$args['meta_query']['relation'] = 'AND';
				}
				$args['meta_query'][] = array(
					'key' => '_flaats_promo_data_price_min',
					'value' => intval( $_GET['price_min'] ),
					'type' => 'numeric',
					'compare' => '>='
				);
			}

			if( isset( $_GET['price_max'] ) && intval( $_GET['price_max'] ) > 0 ) {
				if( isset( $args['meta_query'] ) ) {
					$args['meta_query']['relation'] = 'AND';					
				}
				$args['meta_query'][] = array(
					'key' => '_flaats_promo_data_price_min',
					'value' => intval( $_GET['price_max'] ),
					'type' => 'numeric',					
					'compare' => '<='
				);
			}

			if( isset( $_GET['rooms'] ) && $_GET['rooms'] != '-1' ) {
				if( isset( $args['meta_query'] ) ) {
					$args['meta_query']['relation'] = 'AND';					
				}
				$args['meta_query'][] = array(
					'key' => '_flaats_promo_data_rooms_min',
					'value' => intval( $_GET['rooms'] ),
					'type' => 'numeric',					
					'compare' => '>='
				);  
			}

			if( isset( $_GET['amenities'] ) && count( $_GET['amenities'] ) > 0 ) {
				if( !isset( $args['tax_query']['relation'] ) ) {
					$args['tax_query']['relation'] = 'AND';
				}
				foreach( $_GET['amenities'] as $amenity ) {
					if( 'es' == pll_current_language() ) {
						$amenity_es = get_term_by( 'slug', $amenity, 'amenity' );
						$amenity_en_id = pll_get_term( $amenity_es->term_id, 'en' ); 
						$amenity_en = get_term_by( 'id', $amenity_en_id, 'amenity' );
						$amenity_slug = $amenity_en->slug;
					} else {
						$amenity_slug = sanitize_text_field( $amenity );						
					}						
					$args['tax_query'][] = array(
						array(
							'taxonomy' => 'amenity',
							'field' => 'slug',
							'terms' => $amenity_slug
						)
					);
				}
			}

			global $post;

			$query = new WP_Query( $args );

			$array_promos = array();
			while( $query->have_posts() ) {
				$query->the_post();
				$promo_id = get_the_ID();
				if( 'es' == pll_current_language() ) {
					$promo_id = pll_get_post( get_the_ID(), 'es' );
				}
				if( intval( $promo_id ) > 0 ) {
					$array_promos[] = self::get_development_data( $promo_id );
				}
			}
			wp_reset_postdata();	
		

			return $array_promos;

		}

		/*-----------------------------------------------------------------------------------*/				
		// Get developments in a zone
		/*-----------------------------------------------------------------------------------*/				
		function get_developments_by_zone( $zone_id, $promo_id = 0, $orderby, $lang = '' ) {

			$paged = ( intval( get_query_var( 'paged' ) ) > 0 ? intval( get_query_var( 'paged' ) ) : 1 ); 	
			
			$args = array(
				'post_type' => 'promocion',
				'post_status' => 'publish',
				'posts_per_page' => 12,
			);

			if( $lang != '' ) {
				$args['lang'] = $lang;
			} else {
				$args['lang'] = pll_current_language();
			}

			if( intval( $zone_id ) > 0 ) {
				$args['meta_query']['zone'] = array(
					'key'     => '_flaats_promo_zone',
					'value'   => $zone_id,
					'compare' => '=',								
				);
			}

			if( $promo_id > 0 ) {
				$args['post__not_in'] = array( $promo_id );
			}

			$args['paged'] = $paged;

			$meta_order = '';
			switch( $orderby ) {
				case 1:
					$args['meta_query']['price'] = array(
						'key'     => '_flaats_promo_data_price_min',
						'compare' => 'EXISTS',
						'type'	  => 'NUMERIC'
					);				
					$args['orderby'] = array(
						'price' => 'ASC'
					);

					//$args['meta_key'] = '_flaats_promo_data_price_min';
					//$args['order'] = 'ASC';
					//$args['orderby'] = 'meta_value';
					break;
				case 2:
					$meta_order = array(
						'size' => 'ASC'
					);
					$args['meta_key'] = '_flaats_promo_data_size_min';
					$args['order'] = 'ASC';
					$args['orderby'] = 'meta_value';					
					break;
				case 3:
					$meta_order = array(
						'rooms' => 'ASC'
					);
					$args['meta_key'] = '_flaats_promo_data_rooms_min';
					$args['order'] = 'ASC';
					$args['orderby'] = 'meta_value';					
					break;		
				default:
					$meta_order = array(
						'featured' => 'DESC'
					);
					$args['meta_key'] = '_flaats_promo_data_featured';
					$args['order'] = 'DESC';
					$args['orderby'] = 'meta_value';					
			}	

			$array_developments = array();
			$query = new WP_Query( $args );

			return $query;

		}
		/*-----------------------------------------------------------------------------------*/				
		// Get the data for a development
		/*-----------------------------------------------------------------------------------*/		
		function get_development_data( $development_id ) {

			$zone_id = get_field( '_flaats_promo_zone', $development_id );
			$excerpt = Flaats_Functions::get_excerpt( $development_id );	
			$excerpt_short = Flaats_Functions::get_excerpt( $development_id, 15 );	
			$name = get_the_title( $development_id );
			$content = Flaats_Functions::get_the_content_by_id( $development_id );
			$url = get_the_permalink( $development_id );

			// In the spanish version, get some data from the english developments
			if( 'es' == pll_current_language() ) {
				$development_id = pll_get_post( $development_id, 'en' );
			}

			$coordinates = get_field( '_flaats_promo_location', $development_id );
			$lat = $coordinates['lat'];
			$lng = $coordinates['lng'];   
			$_zone = get_post( $zone_id ); 
			$thumbnail_featured_big = get_the_post_thumbnail_url( $development_id, 'featured-promo-big' );
			$thumbnail_featured_small = get_the_post_thumbnail_url( $development_id, 'featured-promo-small' );
			$thumbnail_list = get_the_post_thumbnail_url( $development_id, 'promo-list' );
			$thumbnail_list_big = get_the_post_thumbnail_url( $development_id, 'promo-list-big' );
			$price_min = get_field( '_flaats_promo_data_price_min', $development_id );
			$price_max = get_field( '_flaats_promo_data_price_max', $development_id );
			$rooms_min = get_field( '_flaats_promo_data_rooms_min', $development_id );
			$rooms_max = get_field( '_flaats_promo_data_rooms_max', $development_id );
			$size_min = get_field( '_flaats_promo_data_size_min', $development_id );			
			$size_max = get_field( '_flaats_promo_data_size_max', $development_id );			
			$construction_started = get_field( '_flaats_promo_data_construction_started', $development_id );	
			$featured = get_field( '_flaats_promo_data_featured', $development_id );			
			$ref = get_field( '_flaats_promo_data_ref', $development_id );		

			$development_data = array( 
				'id' => $development_id,
				'name' => $name, 
				'content' => $content, 
				'excerpt' => $excerpt,
				'excerpt_short' => $excerpt_short,
				'address' => $coordinates['address'], 
				'lat' => $lat, 
				'lng' => $lng, 
				'url' => $url,
				'zone' => $_zone->post_title,
				'zone_id' => $_zone->ID,
				'thumbnail_featured_big' => $thumbnail_featured_big,
				'thumbnail_featured_small' => $thumbnail_featured_small,
				'thumbnail_list' => $thumbnail_list,				
				'thumbnail_list_big' => $thumbnail_list_big,				
				'price_min' => Flaats_Functions::format_price( $price_min ),
				'price_max' => $price_max,
				'rooms_min' => $rooms_min,
				'rooms_max' => $rooms_max,
				'size_min' => $size_min,
				'size_max' => $size_max,
				'ref' => $ref,
				'construction_started' => $construction_started,
				'featured' => $featured
			);    
			return $development_data;

		}		

		/*-----------------------------------------------------------------------------------*/						
		// Return the amenities in order
		/*-----------------------------------------------------------------------------------*/						
		function get_the_terms_sorted( $post_id, $taxonomy ) {
			$terms = get_the_terms( $post_id, $taxonomy );
			function cmp_by_custom_order( $a, $b ) {
				return $a->custom_order - $b->custom_order;
			}
			if ( $terms ) usort( $terms, 'cmp_by_custom_order' );
			return $terms;
		}

		/*-----------------------------------------------------------------------------------*/				
		// Download pdf files
		/*-----------------------------------------------------------------------------------*/				
		function ajax_download_pdf() {

			$promo_id = intval( $_POST['promo_id'] );
			$promo_ref = sanitize_text_field( $_POST['promo_ref'] );
			$name = sanitize_text_field( $_POST['name'] );
			$email = sanitize_text_field( $_POST['email'] );
			$phone = sanitize_text_field( $_POST['phone'] );
			if( $promo_id > 0 ) {
				if( 'es' == pll_current_language() ) {
					$promo_id = pll_get_post( $promo_id, 'en' );					
				}
				while( have_rows( '_flaats_promo_pdf', $promo_id ) ) {
					the_row();
					$pdf_url = get_sub_field( 'dossier' );
				}
				if( $pdf_url != '' ) {
					//self::send_email_witei( $name, $email, $phone, $promo_ref );					
					echo json_encode( array( 'error' => 0, 'pdf' => $pdf_url ) );
				} else {
					echo json_encode( array( 'error' => 1 ) );
				}
			} else {
				echo json_encode( array( 'error' => 2 ) );				
			}

			die();

		}

		/*-----------------------------------------------------------------------------------*/				
		// Get AJAX params to send email to Witei
		/*-----------------------------------------------------------------------------------*/				
		function ajax_witei() {

			$promo_witei = sanitize_text_field( $_POST['promo_witei'] );
			$name = sanitize_text_field( $_POST['name'] );
			$email = sanitize_text_field( $_POST['email'] );
			$phone = sanitize_text_field( $_POST['phone'] );
			if( $promo_witei != '' ) {
				self::send_email_witei( $name, $email, $phone, $promo_witei );
				echo json_encode( array( 'error' => 0 ) );								
			} else {
				echo json_encode( array( 'error' => 1 ) );				
			}

			die();

		}		

		/*-----------------------------------------------------------------------------------*/				
		// Send the contact info to Witei Inbox
		/*-----------------------------------------------------------------------------------*/				
		function send_email_witei( $name, $email, $phone, $promo_witei ) {

			if( $promo_witei != '' ) {
				$from = Flaats_Definitions::$email_from;
				$to = Flaats_Definitions::$witei_inbox;
				$subject = 'Email de Dreamhomes para Witei';

				$message = "-------------------\nNombre: $name \nTelefono: $phone \nEmail: $email \nReferencia: $promo_witei \n-------------------";

				/*
				$message = "Nombre: " . $name . "\nEmail: " . $email;
				if( $phone != '' ) {
					$message .= "\nTeléfono: " . $phone;
				}
				$message .= "\nReferencia: " . $promo_witei;
				*/


				$headers = 'From: DreamHomes <' . Flaats_Definitions::$email_from . '>';
				wp_mail( $to, $subject, $message, $headers );
				wp_mail( 'aruiz@blogestudio.com', $subject, $message, $headers );
			} 

		}	

	}
}

new Flaats_Development();