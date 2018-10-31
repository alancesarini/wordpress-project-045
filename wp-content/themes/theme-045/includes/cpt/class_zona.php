<?php

if( !class_exists( 'Flaats_Zona' ) ) {
	
	class Flaats_Zona {

		private static $_version;

		public static $prefix;

		public static $array_lifestyle;

		/*-----------------------------------------------------------------------------------*/
		// Class constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {

			self::$_version = '1.0.0';

			self::$prefix = '_flaats_zona_';
 
			self::$array_lifestyle['es'] = array(
				'nightlife' => __( 'VIDA NOCTURNA', 'flaats' ),
				'beach' => __( 'PLAYA / BAÑO', 'flaats' ),
				'shops' => __( 'TIENDAS', 'flaats' ),
				'eating' => __( 'RESTAURANTES', 'flaats' ),
				'golf' => __( 'GOLF', 'flaats' ),
				'port' => __( 'PUERTO DEPORTIVO', 'flaats' ),
				'culture' => __( 'CULTURA', 'flaats' ),
				'family' => __( 'FAMILIA', 'flaats' ),
			);
 
			self::$array_lifestyle['en'] = array(
				'nightlife' => 'NIGHTLIFE',
				'beach' => 'BEACH',
				'shops' => 'SHOPPING',
				'eating' => 'RESTAURANTS',
				'golf' => 'GOLF',
				'port' => 'LEISURE PORT',
				'culture' => 'CULTURE',
				'family' => 'FAMILY',
			);

			// Register CPT
			add_action( 'init', array( $this, 'register_cpt' ) );			

			// Add rewrites
			add_filter( 'generate_rewrite_rules', array( $this, 'add_rewrites' ) );

		}

		/*-----------------------------------------------------------------------------------*/
		// Register custom post type "Zona"
		/*-----------------------------------------------------------------------------------*/
		function register_cpt() {

			$labels = array(
				'name'               => __( 'Areas' ),
				'singular_name'      => __( 'Area' ),
				'add_new'            => __( 'Añade nueva área' ),
				'add_new_item'       => __( 'Añade nueva área' ),
				'edit_item'          => __( 'Editar' ),
				'new_item'           => __( 'Nueva' ),
				'all_items'          => __( 'Todas' ),
				'view_item'          => __( 'Ver' ),
				'search_items'       => __( 'Buscar' ),
				'not_found'          => __( 'No se han encontrado área' ),
				'not_found_in_trash' => __( 'No se han encontrado área en la papelera' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Areas'
			);
			$args = array(
				'labels'        => $labels,
				'description'   => 'Areas',
				'public'        => true,
				'menu_position' => 21,
				'hierarchical'  => true,
				'supports'      => array( 'title', 'editor', 'thumbnail' ),
				'has_archive'   => true,
				'rewrite'		=> array( 'slug' => 'area', 'with_front' => false )
			);
			register_post_type( 'zona', $args );		

		}

		/*-----------------------------------------------------------------------------------*/		
		// Add the rewrite for the CPT
		/*-----------------------------------------------------------------------------------*/		
        function add_rewrites( $wp_rewrite ) {

			$rules = array();
			$rules["zona/([^/]+)/?$"] = 'index.php?post_type=zona&zona=$matches[1]';
			$wp_rewrite->rules = $rules + $wp_rewrite->rules;

		}

		/*-----------------------------------------------------------------------------------*/
		// Get search results
		/*-----------------------------------------------------------------------------------*/		
		function get_search_results() {

			$paged = ( intval( get_query_var( 'paged' ) ) > 0 ? intval( get_query_var( 'paged' ) ) : 1 ); 

			$args = array(
				'post_type' => 'zona',
				'post_status' => 'publish',
				'lang' => pll_current_language(),
				'meta_query' => array(
					'relation' => 'AND'
				)
			);

			foreach( self::$array_lifestyle[pll_current_language()] as $param => $text ) {
				if( isset( $_GET[$param] ) && intval( $_GET[$param] ) > 0 && intval( $_GET[$param] ) < 6 ) {
					$args['meta_query'][] = array(
						'key' => '_flaats_zone_lifestyle_' . $param,
						'value' => intval( $_GET[$param] ),
						'compare' => '>='
					);
				}
			}

			$args['paged'] = $paged;
			$args['orderby'] = 'title';
			$args['order'] = 'ASC';

			$query = new WP_Query( $args );

			return $query;

		}	
		
		/*-----------------------------------------------------------------------------------*/				
		// Get all zones
		/*-----------------------------------------------------------------------------------*/				
		function get_all_zones( $zone_id ) {

			$args = array(
				'post_type' => 'zona',
				'post_status' => 'publish',
				'lang' => pll_current_language(),
				'posts_per_page' => -1,
				'post__not_in' => array ( $zone_id )
			);

			$query = new WP_Query( $args );
			$array_zones = array();
			while( $query->have_posts() ) {
				$query->the_post();
				$array_zones[] = self::get_zone_data( get_the_ID() );    
			}	
			wp_reset_postdata();
			
			return $array_zones;

		}

		/*-----------------------------------------------------------------------------------*/						
		// Get data for a zone
		/*-----------------------------------------------------------------------------------*/						
		function get_zone_data( $zone_id ) {

			$thumbnail = get_the_post_thumbnail_url( $zone_id, 'zone-big' );
			$thumbnail_list = get_the_post_thumbnail_url( $zone_id, 'zone-list' );
			$thumbnail_slider = get_the_post_thumbnail_url( $zone_id, 'zone-slider' );
			$lifestyle = array();
			$lifestyle1 = array();
			$lifestyle2 = array();
			$i = 1;
			foreach( self::$array_lifestyle[pll_current_language()] as $param => $text ) {
				$text = __( $text, 'flaats' );
				$score = get_post_meta( $zone_id, '_flaats_zone_lifestyle_' . $param, true );
				$text_formatted = ucfirst( strtolower( $text ) );
				$text_formatted = str_replace( 'Ñ', 'ñ', $text_formatted );
				$lifestyle[$text_formatted] = $score;
				if( $i < 5 ) {
					$lifestyle1[$text_formatted] = $score;
				} else {
					$lifestyle2[$text_formatted] = $score;					
				}
				$i++;
			}
			$content = Flaats_Functions::get_the_content_by_id( $zone_id );
			$gallery = get_field( '_flaats_zone_pics', $zone_id );
			$coordinates = get_field( '_flaats_zone_location', $zone_id );
			$lat = $coordinates['lat'];
			$lng = $coordinates['lng'];   

			$data = array( 
				'id' => $zone_id, 
				'name' => get_the_title( $zone_id ), 
				'content' => $content, 
				'thumbnail' => $thumbnail, 
				'thumbnail_list' => $thumbnail_list, 
				'thumbnail_slider' => $thumbnail_slider, 
				'lifestyle' => $lifestyle, 
				'lifestyle1' => $lifestyle1, 
				'lifestyle2' => $lifestyle2, 
				'url' => get_the_permalink( $zone_id ), 
				'gallery' => $gallery,
				'lat' => $lat,
				'lng' => $lng
			);    
			
			return $data;

		}

	}
}

new Flaats_Zona();