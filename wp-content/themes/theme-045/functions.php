<?php

// Constant definitions
require( 'includes/class_definitions.php' );

// General configuration
require( 'includes/class_configuration.php' );

// Common functions
require( 'includes/class_functions.php' );

// CPTs
require( 'includes/cpt/class_zona.php' );
require( 'includes/cpt/class_promocion.php' );

// Class for detecting mobile devices
include( dirname( __FILE__ ) . '/includes/vendor/mobile_detect/Mobile_Detect.php' );
