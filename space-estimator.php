<?php
/**
 * Plugin Name: Space Estimator
 * Plugin URI:  https://alaminislam.info/space-estimator
 * Description: A simple plugin to estimate space requirements for various items.
 * Version:     1.0.2
 * Author:      Md Al Amin Islam
 * Author URI:  https://alaminislam.info
 * License:     GPL2
 * Text Domain: space-estimator
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define( 'SPACE_ESTIMATOR_VERSION', '1.0.0' );
define( 'SPACE_ESTIMATOR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SPACE_ESTIMATOR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator.php';

// Initialize the plugin
new Space_Estimator();
