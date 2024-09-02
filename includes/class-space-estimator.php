<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Space_Estimator {

    public function __construct() {
        $this->include_files();
        $this->init_hooks();
    }

    private function include_files() {
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator-cpt.php';
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator-ajax.php';
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator-shortcode.php';
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator-admin.php';
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'includes/class-space-estimator-enqueue.php';
    }

    private function init_hooks() {
        // Initialize classes
        new Space_Estimator_CPT();
        new Space_Estimator_Ajax();
        new Space_Estimator_Shortcode();
        new Space_Estimator_Admin();
        new Space_Estimator_Enqueue();
    }
}
