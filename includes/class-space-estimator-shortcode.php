<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Space_Estimator_Shortcode {

    public function __construct() {
        add_shortcode( 'space_estimator', [ $this, 'render_space_estimator_shortcode' ] );
    }

    public function render_space_estimator_shortcode() {
        ob_start();
        $contact_form = get_option('space_estimator_contact_form_shortcode', '');
        ?>
        <div class="se-calculator-wrapper">
            <div class="se-data-field">
                <div class="se-step mb-4">
                    <h3 class="se-title">Step 1</h3>
                    <p>Use our Space Estimator below to work out how much space you might need.</p>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="sp-data form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="se-add-btn btn btn-primary" id="button-addon2">Add Room</button>
                </div>
            </div>
            <div class="se-content-box">
                <!-- Room containers will be dynamically inserted here -->
            </div>
            <div class="se-calculate">
                <div class="total-volume">
                    <h3>Total Volume:</h3>
                    <h4 id="total-volume">0.00m<sup>3</sup></h4>
                </div>
                <div class="se-cal-ctnt-wrap">
                    <div class="se-locker">
                        <h4>Storage Locker</h4>
                        <p>Volume:</p>
                        <p>1.15m<sup>3</sup></p>
                        <p>Area:</p>
                        <p>0.96m<sup>2</sup></p>
                    </div>
                    <div class="se-mesurement">
                        <p>0.8m W x 1.2m D x 1.2m H</p>
                    </div>
                </div>
                <div class="se-cal-ctnt-wrap">
                    <div class="se-locker">
                        <h4>Mini Module (3m<sup>3</sup>)</h4>
                        <p>Volume:</p>
                        <p>3.6m<sup>3</sup></p>
                        <p>Area:</p>
                        <p>1.8m<sup>2</sup></p>
                    </div>
                    <div class="se-mesurement">
                        <p>1.5m W x 1.2m D x 2.0m H</p>
                    </div>
                </div>
                <div class="se-cal-ctnt-wrap">
                    <div class="se-locker">
                        <h4>Mini Module (6m<sup>3</sup>)</h4>
                        <p>Volume:</p>
                        <p>6.9m<sup>3</sup></p>
                        <p>Area:</p>
                        <p>3.45m<sup>2</sup></p>
                    </div>
                    <div class="se-mesurement">
                        <p>1.5m W x 2.3m D x 2.0m H</p>
                    </div>
                </div>
            </div>

            <div class="se-footer">
                <div class="se-step mb-4 mt-5">
                    <h3 class="se-title">Step 2</h3>
                </div>
                <?php echo do_shortcode($contact_form); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
