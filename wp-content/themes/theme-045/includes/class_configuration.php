<?php

if( !class_exists( 'Project045_Configuration' ) ) {

	class Project045_Configuration {

		private static $_this;

		private static $_version;

		public static $prefix;

		function __construct() {
		
			self::$_this = $this;

			self::$_version = '1.0.0';

			self::$prefix = '_project045_';

			/*-----------------------------------------------------------------------------------*/
			// Add support for thumbnails
			/*-----------------------------------------------------------------------------------*/
			add_theme_support( 'post-thumbnails' ); 	

			/*-----------------------------------------------------------------------------------*/
			// Load text domain
			/*-----------------------------------------------------------------------------------*/
			add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );	

			/*-----------------------------------------------------------------------------------*/
			// Register menus
			/*-----------------------------------------------------------------------------------*/
			add_action( 'init', array( $this, 'register_menus' ) );

			// Remove the admin bar in the frontend
			show_admin_bar( false );

			/*-----------------------------------------------------------------------------------*/
			// Add new image sizes
			/*-----------------------------------------------------------------------------------*/						
			add_image_size( 'featured-promo-big', 750, 398, true );
			add_image_size( 'featured-promo-small', 360, 398, true );
			add_image_size( 'zone-slider', 255, 219, true );
			add_image_size( 'zone-list', 569, 391, true );
			add_image_size( 'promo-favs', 55, 37, true );
			add_image_size( 'zone-big', 1140, 424, true );
			add_image_size( 'promo-list', 364, 242, true );
			add_image_size( 'promo-list-big', 584, 388, true );
			add_image_size( 'promo-gallery', 1140, 595, true );
			add_image_size( 'zone-gallery-big', 652, 424, true );
			add_image_size( 'zone-gallery-small', 244, 212, true );		
			

			/*-----------------------------------------------------------------------------------*/
			// Register the widget areas
			/*-----------------------------------------------------------------------------------*/
			register_sidebars( 1,
				array(
					'name' => 'Texto en pie de página',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => ''
				)				
			);	
			register_sidebars( 1,
				array(
					'name' => 'Menú de áreas en pie de página',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => ''
				)				
			);							
			register_sidebars( 1,
				array(
					'name' => 'Dirección en pie de página',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => ''
				)				
			);	
			register_sidebars( 1,
				array(
					'name' => 'Iconos sociales en pie de página',
					'before_widget' => '',
					'after_widget'  => '',
					'before_title'  => '',
					'after_title'   => ''
				)				
			);				
		
			/*-----------------------------------------------------------------------------------*/
			// Load JS and CSS for the frontend screens
			/*-----------------------------------------------------------------------------------*/
			add_action( 'wp_enqueue_scripts', array( $this, 'load_js_css' ) );	

			/*-----------------------------------------------------------------------------------*/																		
			// Hooks for registering the Google Maps API Key in Advanced Custom Fields
			/*-----------------------------------------------------------------------------------*/																		
			add_action( 'acf/init', array( $this, 'register_maps_api' ) );

			/*-----------------------------------------------------------------------------------*/																					
			// Init the AJAX login scripts
			/*-----------------------------------------------------------------------------------*/		
			add_action( 'wp_ajax_nopriv_ajaxlogin', array( $this, 'ajax_login' ) );																						
			add_action( 'wp_ajax_nopriv_ajaxregister', array( $this, 'ajax_register' ) );	
			add_action( 'wp_ajax_nopriv_ajaxforgotpassword', array( $this, 'ajax_forgotpassword' ) );
			if( !is_user_logged_in() ) {
				add_action( 'wp', array( $this, 'ajax_login_init' ) );
			}	

			/*-----------------------------------------------------------------------------------*/
			// Move the comment field to the bottom
			/*-----------------------------------------------------------------------------------*/
			add_filter( 'comment_form_fields', array( $this, 'move_comment_field_to_bottom' ) );	

			/*-----------------------------------------------------------------------------------*/			
			// Send an email upon user registration
			/*-----------------------------------------------------------------------------------*/
			add_action( 'user_register', array( $this, 'send_registration_notice' ), 10, 1 );

			/*-----------------------------------------------------------------------------------*/			
			// Filter to add hidden fields in the "download dossier" form
			/*-----------------------------------------------------------------------------------*/			
			add_filter( 'wpcf7_form_hidden_fields', array( $this, 'add_field_to_download_form' ), 10, 1 ); 

		}

		/*-----------------------------------------------------------------------------------*/			
		// Add hidden fields to development forms 
		/*-----------------------------------------------------------------------------------*/			
		function add_field_to_download_form( $fields ) {

			if( is_single() && 'promocion' == get_post_type() ) {
				$fields['promo'] = get_the_title();
				return $fields;
			}

		}

		/*-----------------------------------------------------------------------------------*/
		// Send email upon user registration
		/*-----------------------------------------------------------------------------------*/
		function send_registration_notice( $user_id ) {

			$the_user = get_userdata( $user_id );
			$user_email = $the_user->user_email;
			$user_name = $the_user->first_name . ' ' . $the_user->last_name;

			$from = Project045_Definitions::$email_from;
			$to = Project045_Definitions::$email_from;
			$subject = 'Nuevo registro de usuario';
			$message = "Nombre: " . $user_name . "\nEmail: " . $user_email;
			$headers = 'From: Project045 <' . Project045_Definitions::$email_from . '>';
			wp_mail( $to, $subject, $message, $headers );	

		}	

		/*-----------------------------------------------------------------------------------*/
		// Move comment field to the bottom
		/*-----------------------------------------------------------------------------------*/
		function move_comment_field_to_bottom( $fields ) {

			$comment_field = $fields['comment'];
			unset( $fields['comment'] );
			$fields['comment'] = $comment_field;
			return $fields;

		}
		

		/*-----------------------------------------------------------------------------------*/																							
		// Load textdomain
		/*-----------------------------------------------------------------------------------*/																											
		function load_textdomain() {

			load_theme_textdomain( 'project045', get_template_directory() . '/lang' );

		}		

		/*-----------------------------------------------------------------------------------*/																							
		// Init the AJAX login
		/*-----------------------------------------------------------------------------------*/																					
		function ajax_login_init(){
			
			global $wp;

			wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login.min.js', array( 'jquery' ) ); 
			wp_enqueue_script('ajax-login-script');
		
			wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'redirecturl' => home_url( $wp->request ),
				'loadingmessage' => __( 'Enviando información. Por favor espere...', 'project045' )
			));
		
		}
			

		/*-----------------------------------------------------------------------------------*/																					
		// Process the ajax login
		/*-----------------------------------------------------------------------------------*/																									
		function ajax_login() {

			check_ajax_referer( 'ajax-login-nonce', 'security' );
		
			self::auth_user_login($_POST['username'], $_POST['password'], __( 'Acceso', 'project045' ) );
		
			die();
		}	
		
		/*-----------------------------------------------------------------------------------*/																											
		// Process the ajax register
		/*-----------------------------------------------------------------------------------*/																											
		function ajax_register() {
 
			// First check the nonce, if it fails the function will break
			check_ajax_referer( 'ajax-register-nonce', 'securityregister', false );
				
			// Nonce is checked, get the POST data and sign user on
			$info = array();
			$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
			$info['user_pass'] = sanitize_text_field($_POST['password']);
			$info['user_email'] = sanitize_email( $_POST['email']);
			
			// Register the user
			$user_register = wp_insert_user( $info );
			 if ( is_wp_error($user_register) ){	
				$error  = $user_register->get_error_codes()	;
				
				if(in_array('empty_user_login', $error))
					echo json_encode(array('loggedin'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));
				elseif(in_array('existing_user_login',$error))
					echo json_encode(array('loggedin'=>false, 'message'=>__('El nombre de usuario ya existe.', 'project045' )));
				elseif(in_array('existing_user_email',$error))
				echo json_encode(array('loggedin'=>false, 'message'=>__('La dirección de email ya existe.', 'project045' )));
			} else {			
			  	self::auth_user_login($info['nickname'], $info['user_pass'], __( 'Registro', 'project045' ) );       
			}
		 
			die();
		}	
		
		/*-----------------------------------------------------------------------------------*/																											
		// Signon the user
		/*-----------------------------------------------------------------------------------*/																															
		function auth_user_login($user_login, $password, $login) {
			$info = array();
			$info['user_login'] = $user_login;
			$info['user_password'] = $password;
			$info['remember'] = true;
			
			$user_signon = wp_signon( $info, false );
			if ( is_wp_error($user_signon) ){
				echo json_encode(array('loggedin'=>false, 'message'=>__('Nombre de usuario o contraseña incorrecta.', 'project045')));
			} else {
				wp_set_current_user($user_signon->ID); 
				echo json_encode(array('loggedin'=>true, 'message'=>__($login.' con éxito, redirigiendo...', 'project045' )));
			}
			
			die();
		}		

		/*-----------------------------------------------------------------------------------*/																											
		// Handle the lost password form
		/*-----------------------------------------------------------------------------------*/																													
		function ajax_forgotpassword(){
	 
			check_ajax_referer( 'ajax-forgot-nonce', 'security' );
			
			global $wpdb;
			
			$account = $_POST['user_login'];
			
			if( empty( $account ) ) {
				$error = __( 'Introduzca su nombre de usuario o email.', 'project045' );
			} else {
				if(is_email( $account )) {
					if( email_exists($account) ) 
						$get_by = 'email';
					else	
						$error = __( 'No existe ningún usuario registrado con ese email.', 'project045' );		
				}
				else if (validate_username( $account )) {
					if( username_exists($account) ) 
						$get_by = 'login';
					else	
						$error = __( 'No existe ningún usuario registrado con ese nombre.', 'project045' );				
				}
				else
					$error = __( 'Nombre de usuario o email incorrecto.', 'project045' );		
			}	
			
			if(empty ($error)) {
				// lets generate our new password
				//$random_password = wp_generate_password( 12, false );
				$random_password = wp_generate_password();
		 
					
				// Get user data by field and data, fields are id, slug, email and login
				$user = get_user_by( $get_by, $account );
					
				$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
					
				// if  update user return true then lets send user an email containing the new password
				if( $update_user ) {
					
					$from = 'acesarini@blogestudio.com'; // Set whatever you want like mail@yourdomain.com
					
					if(!(isset($from) && is_email($from))) {		
						$sitename = strtolower( $_SERVER['SERVER_NAME'] );
						if ( substr( $sitename, 0, 4 ) == 'www.' ) {
							$sitename = substr( $sitename, 4 );					
						}
						$from = 'admin@'.$sitename; 
					}
					
					$to = $user->user_email;
					$subject = __( 'Su nueva contrasña', 'project045' );
					$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
					
					$message = __( 'Su nueva contraseña es: ', 'project045' ) . $random_password;
						
					$headers[] = 'MIME-Version: 1.0' . "\r\n";
					$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers[] = "X-Mailer: PHP \r\n";
					$headers[] = $sender;
						
					$mail = wp_mail( $to, $subject, $message, $headers );
					if( $mail ) 
						$success = __( 'Compruebe su buzón de correo. Le hemos enviado su nueva contraseña.', 'project045' );
					else
						$error = __( 'Ha ocurrido un error al intentar enviarle email con su contraseña.', 'project045' );					
				} else {
					$error = __( 'Ha ocurrido un error.', 'project045' );
				}
			}
			
			if( ! empty( $error ) )
				echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
					
			if( ! empty( $success ) )
				echo json_encode(array('loggedin'=>false, 'message'=>__($success)));
						
			die();
		}

		/*-----------------------------------------------------------------------------------*/
		// Register menus
		/*-----------------------------------------------------------------------------------*/
		function register_menus() {
		
			register_nav_menu( 'headermenu', __( 'Menú cabecera' ) );
			register_nav_menu( 'footermenu', __( 'Menú pie' ) );
			register_nav_menu( 'footermenulegal', __( 'Menú pie legal' ) );			

		}	

		/*-----------------------------------------------------------------------------------*/
		// Load assets
		/*-----------------------------------------------------------------------------------*/
		function load_js_css() {

			wp_register_script( 'fontawesome-all', get_stylesheet_directory_uri() . '/js/fontawesome-all.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'owl', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'selectric', get_stylesheet_directory_uri() . '/js/jquery.selectric.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'select', get_stylesheet_directory_uri() . '/js/select.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'tab_menu', get_stylesheet_directory_uri() . '/js/tab_menu.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'aos', get_stylesheet_directory_uri() . '/js/aos.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'rangeslider', get_stylesheet_directory_uri() . '/js/rangeslider.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'easymap', get_stylesheet_directory_uri() . '/js/easymap.plugin.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'markerclusterer', get_stylesheet_directory_uri() . '/js/markerclusterer.min.js', array(), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'customscrollbar', get_stylesheet_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'ddslick', get_stylesheet_directory_uri() . '/js/jquery.ddslick.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );
			wp_register_script( 'project045-main', get_stylesheet_directory_uri() . '/js/main.min.js', array( 'jquery' ), Project045_Definitions::$scripts_version, true );

			wp_enqueue_script( 'fontawesome-all' );
			wp_enqueue_script( 'owl' );
			wp_enqueue_script( 'selectric' );
			wp_enqueue_script( 'select' );
			wp_enqueue_script( 'jquery-ui' );
			wp_enqueue_script( 'tab_menu' );
			wp_enqueue_script( 'aos' );
			wp_enqueue_script( 'rangeslider' );
			wp_enqueue_script( 'bootstrap' );
			wp_enqueue_script( 'easymap' );
			wp_enqueue_script( 'markerclusterer' );
			wp_enqueue_script( 'customscrollbar' );
			wp_enqueue_script( 'ddslick' );
			wp_enqueue_script( 'project045-main' );

		}

		/*-----------------------------------------------------------------------------------*/								
		// Register the Google Maps API Key
		/*-----------------------------------------------------------------------------------*/										
		public static function register_maps_api() {

			acf_update_setting( 'google_api_key', Project045_Definitions::$maps_api_key );
			
		}

		/*-----------------------------------------------------------------------------------*/						
		// Change the default icons in the social icons widget
		/*-----------------------------------------------------------------------------------*/		
		function social_icons_html_output( $format ) {

			$format = '<li class="%1$s"><a href="%2$s" target="_blank"><i class="fa fa-%1$s"></i></a></li>';
			return $format;
		
		}

		static function this() {
		
			return self::$_this;
		
		}

	}

}

new Project045_Configuration();