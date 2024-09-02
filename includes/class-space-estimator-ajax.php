<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Space_Estimator_Ajax {

    public function __construct() {
        add_action( 'wp_ajax_nopriv_load_estimates', [ $this, 'load_estimates' ] );
        add_action( 'wp_ajax_load_estimates', [ $this, 'load_estimates' ] );
    }

    public function load_estimates() {
        $rooms = [
            'Living Room' => [] // Fixed first room
        ];

        // Add the "Living Room" data
        $args = array(
            'post_type' => 'estimate',
            'posts_per_page' => -1
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $room_name = get_post_meta( get_the_ID(), '_room_name', true ) ?: 'Living Room'; // Default to "Living Room" if no room name
                $item = get_post_meta( get_the_ID(), '_item', true );
                $volume = get_post_meta( get_the_ID(), '_volume', true );
                $quantity = get_post_meta( get_the_ID(), '_quantity', true );
                $total = get_post_meta( get_the_ID(), '_total', true );

                if ( !isset( $rooms[$room_name] ) ) {
                    $rooms[$room_name] = [];
                }

                $rooms[$room_name][] = [
                    'item'     => $item,
                    'volume'   => $volume,
                    'quantity' => $quantity,
                    'total'    => $total
                ];
            }

            $response = '';
            foreach ( $rooms as $room_name => $items ) {
                $total_volume = array_sum( array_column( $items, 'total' ) );
                $response .= '<div class="se-items-wrap my-4" data-room="' . esc_attr( $room_name ) . '">';
                $response .= '<div class="se-item-content">';
                $response .= '<div class="se-item-content-header">';
                $response .= '<div class="se-head-left">';
                $response .= '<h3 class="room-name">' . esc_html( $room_name ) . '</h3>';
                $response .= '</div>';
                $response .= '<div class="se-head-right">';
                $response .= '<h3 class="room-total" id="total">' . number_format($total_volume, 2) . 'm3</h3>';
                $response .= '</div>';
                $response .= '</div>';
                $response .= '<div class="se-item-content-body">';
                $response .= '<div class="item"><h3>Item</h3></div>';
                $response .= '<div class="volume"><h3>Volume</h3></div>';
                $response .= '<div class="quantity"><h3>Quantity</h3></div>';
                $response .= '<div class="total"><h3>Total</h3></div>';
                $response .= '</div>';
                $response .= '<ul class="se-item-list" id="item-list">';
                $response .= '</ul>';
                $response .= '<select name="space_estimator_items" class="space-estimator-select form-select">';
                $response .= '<option value="">Select an item</option>';
                foreach ( $items as $item ) {
                    $response .= '<option 
                        value="' . esc_attr( $item['item'] ) . '"
                        data-item="' . esc_attr( $item['item'] ) . '"
                        data-volume="' . esc_attr( $item['volume'] ) . '"
                        data-total="' . esc_attr( $item['volume'] ) . '">
                        ' . esc_html( $item['item'] ) . '
                    </option>';
                }
                $response .= '</select>';
                $response .= '</div>';
            }
        } else {
            $response = '<p>No estimates found.</p>';
        }

        wp_reset_postdata();

        echo $response;

        wp_die(); // Required to terminate immediately and return a proper response
    }
}
