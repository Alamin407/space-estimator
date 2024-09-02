<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Space_Estimator_CPT {

    public function __construct() {
        add_action( 'init', [ $this, 'register_custom_post_type' ] );
        add_action( 'add_meta_boxes', [ $this, 'add_custom_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_custom_fields' ] );
    }

    // Register custom post type
    public function register_custom_post_type() {
        $labels = array(
            'name'               => _x( 'Estimates', 'post type general name', 'space-estimator' ),
            'singular_name'      => _x( 'Estimate', 'post type singular name', 'space-estimator' ),
            'menu_name'          => _x( 'Estimates', 'admin menu', 'space-estimator' ),
            'name_admin_bar'     => _x( 'Estimate', 'add new on admin bar', 'space-estimator' ),
            'add_new'            => _x( 'Add New', 'estimate', 'space-estimator' ),
            'add_new_item'       => __( 'Add New Estimate', 'space-estimator' ),
            'new_item'           => __( 'New Estimate', 'space-estimator' ),
            'edit_item'          => __( 'Edit Estimate', 'space-estimator' ),
            'view_item'          => __( 'View Estimate', 'space-estimator' ),
            'all_items'          => __( 'All Estimates', 'space-estimator' ),
            'search_items'       => __( 'Search Estimates', 'space-estimator' ),
            'parent_item_colon'  => __( 'Parent Estimates:', 'space-estimator' ),
            'not_found'          => __( 'No estimates found.', 'space-estimator' ),
            'not_found_in_trash' => __( 'No estimates found in Trash.', 'space-estimator' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'estimate' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title' )
        );

        register_post_type( 'estimate', $args );
    }

    // Add custom meta boxes
    public function add_custom_meta_boxes() {
        add_meta_box(
            'estimate_meta_box',       // ID
            'Estimate Details',        // Title
            [ $this, 'render_meta_box' ], // Callback
            'estimate',                // Screen
            'normal',                  // Context
            'default'                  // Priority
        );
    }

    // Render custom meta box
    public function render_meta_box( $post ) {
        // Retrieve current data
        $item     = get_post_meta( $post->ID, '_item', true );
        $volume   = get_post_meta( $post->ID, '_volume', true );

        // Render the form fields
        ?>
        <label for="item">Item:</label>
        <input type="text" id="item" name="item" value="<?php echo esc_attr( $item ); ?>" class="widefat">

        <label for="volume">Volume:</label>
        <input type="text" id="volume" name="volume" value="<?php echo esc_attr( $volume ); ?>" class="widefat">

        <?php
    }

    // Save custom fields
    public function save_custom_fields( $post_id ) {
        if ( ! isset( $_POST['item'] ) || ! isset( $_POST['volume'] ) ) {
            return;
        }

        update_post_meta( $post_id, '_item', sanitize_text_field( $_POST['item'] ) );
        update_post_meta( $post_id, '_volume', sanitize_text_field( $_POST['volume'] ) );
    }
}
