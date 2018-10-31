<?php

if( !class_exists( 'Project045_Definitions' ) ) {

	class Project045_Definitions {

		private static $_this;

		private static $_version;

		public static $scripts_version;

		public static $maps_api_key;

		public static $witei_inbox;

		public static $email_from;

		function __construct() {

			self::$_this = $this;

			self::$maps_api_key = 'AIzaSyA8KiTOw-vWPf5fGlsuqWfyqWmNJls1IRc'; //AIzaSyBI7Z4-WsoOAULk2aAT3GTLZ1PYzhtFevU';

			self::$witei_inbox = 'ehv@inbox.witei.com';

			self::$email_from = 'info@project045.es';

			self::$scripts_version = '1.0.40';

		}

		static function this() {

			return self::$_this;

		}

	}

}

new Project045_Definitions();
