<?php
if(!defined('ABSPATH')){
    exit;
}
class Space_Estimator_Admin{
    public function __construct(){
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_admin_menu() {
        add_menu_page(
            'Space Estimator',
            'Space Estimator',
            'manage_options',
            'space-estimator',
            [ $this, 'admin_page' ],
            'dashicons-admin-site',
            20
        );

        // Submenu page
        add_submenu_page(
            'space-estimator',
            'Settings',
            'Settings',
            'manage_options',
            'space-estimator-settings',
            [ $this, 'settings_page' ]
        );
    }

    public function register_settings() {
        register_setting( 'space_estimator_settings_group', 'space_estimator_contact_form_shortcode' );
    }

    public function admin_page() {
        require_once SPACE_ESTIMATOR_PLUGIN_DIR . 'templates/estimate-admin-template.php';
    }

    public function settings_page(){
        ?>
            <div class="wrap">
                <h1>Space Estimator Settings</h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'space_estimator_settings_group' );
                    do_settings_sections( 'space_estimator_settings_group' );
                    ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Contact Form 7 Shortcode</th>
                            <td>
                                <input type="text" name="space_estimator_contact_form_shortcode" value="<?php echo esc_attr( get_option( 'space_estimator_contact_form_shortcode' ) ); ?>" class="regular-text" />
                                <p class="description">Enter the Contact Form 7 shortcode here (e.g., [contact-form-7 id="123" title="Contact form 1"]).</p>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
                <p class="text-bold">Note: To receive the calculator data via email, please create 2 textarea fields. One textarea field is normal and the second textarea field is unique. Set the id="estimates-textarea" on the second textarea field, and it should be hidden.</p>
            </div>
        <?php
    }

}