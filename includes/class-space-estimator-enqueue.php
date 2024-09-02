<?php
if(!defined('ABSPATH')){
    exit;
}

class Space_Estimator_Enqueue{
    public function __construct() {
        add_action('wp_enqueue_scripts', [ $this, 'enqueue_scripts' ]);
        add_action('admin_enqueue_scripts', [ $this, 'admin_scripts' ]);
    }

    public function enqueue_scripts() {
        // Enqueue Stylesheetes
        wp_enqueue_style('se-bootstrap-css', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], SPACE_ESTIMATOR_VERSION, 'all');
        wp_enqueue_style('space-estimate-css', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/css/space-estimate.css', [], SPACE_ESTIMATOR_VERSION, 'all');

        // Enqueue javascripts
        wp_enqueue_script( 'se-bootstrap-js', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/js/bootstrap.min.js', [ 'jquery' ], SPACE_ESTIMATOR_VERSION, true );
        wp_enqueue_script( 'space-estimator-js', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/js/space-estimator.js', [ 'se-bootstrap-js' ], SPACE_ESTIMATOR_VERSION, true );

        // Localize the admin ajax
        wp_localize_script( 'space-estimator-js', 'spaceEstimatorAjax', [
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ]);
    }

    public function admin_scripts() {
        // Enqueue Stylesheetes
        wp_enqueue_style('se-admin-bootstrap-css', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], SPACE_ESTIMATOR_VERSION, 'all');
        wp_enqueue_style('se-admin-style-css', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/css/se-admin-style.css', [], SPACE_ESTIMATOR_VERSION, 'all');

        // Enqueue javascripts
        wp_enqueue_script( 'se-admin-bootstrap-js', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/js/bootstrap.min.js', [ 'jquery' ], SPACE_ESTIMATOR_VERSION, true );
        wp_enqueue_script( 'se-admin-js', SPACE_ESTIMATOR_PLUGIN_URL . 'assets/js/se-admin-js.js', [ 'se-admin-bootstrap-js' ], SPACE_ESTIMATOR_VERSION, true );
    }
}