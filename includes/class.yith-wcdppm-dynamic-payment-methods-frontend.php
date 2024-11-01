<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( !defined( 'YITH_WCDPPM_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_Dynamic_Pricing_Payments_Methods_Admin_Premium
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
 *
 */

if ( !class_exists( 'YITH_Dynamic_Pricing_Payments_Methods_Frontend' ) ) {
    /**
     * Class YITH_Dynamic_Pricing_Payments_Methods_Frontend
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class YITH_Dynamic_Pricing_Payments_Methods_Frontend
    {
        /**
         * Single instance of the class
         *
         * @var \YITH_Dynamic_Pricing_Payments_Methods_Frontend
         * @since 1.0.0
         */
        protected static $_instance;


        /**
         * Returns single instance of the class
         *
         * @return \YITH_Dynamic_Pricing_Payments_Methods_Frontend
         * @since 1.0.0
         */
        public static function get_instance()
        {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            if ( is_null( $self::$_instance ) ) {
                $self::$_instance = new $self;
            }

            return $self::$_instance;
        }

        /**
         * Construct
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function __construct()
        {
            add_filter('woocommerce_gateway_title',array($this,'add_gateway_title'),10,2);
            add_action('woocommerce_review_order_before_order_total', array($this,'add_row_payment_method'));

            add_action('woocommerce_checkout_update_order_meta', array($this,'add_amount_to_order'),10,2);

            add_action( 'woocommerce_checkout_order_processed', array($this,'add_item_fee'));
            // Enqueue Scripts
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles_scripts'), 4);

        }


        /**
         * Enqueue styles and scripts
         *
         * @access public
         * @return void
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function enqueue_styles_scripts()
        {
            wp_register_script('yith_wcdppm_frontend', YITH_WCDPPM_ASSETS_URL . 'js/wcdppm-frontend.js', array('jquery','jquery-ui-sortable'), YITH_WCDPPM_VERSION, true);

            wp_localize_script('yith_wcdppm_frontend', 'yith_wcdppm_frontend', apply_filters('yith_wcdppm_frontend_localize', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
            )));

            if(is_checkout()) {
                wp_enqueue_script('yith_wcdppm_frontend');
            }
        }

        /**
         * Add gateway title
         * @access public
         * @return string
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function add_gateway_title($title,$type) {

            $amount = 0; //prevent issues with apply_filters
            if (version_compare(WC()->version, '3.0.2', '<=')) {
                if (is_checkout() && !did_action('woocommerce_checkout_process')) {
                    $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;

                    $user = wp_get_current_user();
                    $amount = $functions->yith_wcdppm_get_amount($type, $user->roles);
                    if ($amount != 0) {
                        if ($amount > 0) {
                            $title = $title . ' +' . wc_price($amount);

                        } else {
                            $title = $title . ' ' . wc_price($amount);
                        }
                    }
                }
            } else {
                if ( !did_action('woocommerce_checkout_process')  ) {
                    $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;

                    $user = wp_get_current_user();
                    $amount = $functions->yith_wcdppm_get_amount($type, $user->roles);
                    if ($amount != 0) {
                        if ($amount > 0) {
                            $title = $title . ' +' . wc_price($amount);

                        } else {
                            $title = $title . ' ' . wc_price($amount);
                        }
                    }
                }
            }

            return apply_filters('yith_wcdppm_gateway_title', $title, $type,$amount);
        }
        

        /**
         * Add payment method row to an order details before place order
         * @access public
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function add_row_payment_method() {
            $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;
            $user = wp_get_current_user();
            $gateways = $functions->yith_wcdppm_get_payment_gateway();
            $total = WC()->cart->total;
            foreach ($gateways as $gateway => $value) {
                $amount = $functions->yith_wcdppm_get_amount($gateway,$user->roles);
                $new_total = $total + $amount;

                $total_json = array(
                    'amount' => wc_price($amount),
                    'total' => wc_price($new_total),
                    'free' => wc_price(0)
                );
                $data_to_file_json = json_encode($total_json);
                ?>
                <input type="hidden" id="yith-wcdppm-gateway-<?php echo $gateway ?>" data-total="<?php echo $new_total?>" data-amount="<?php echo $amount ?>" data-payment-method="<?php echo  htmlspecialchars(  $data_to_file_json ) ?>" >
                <?php
            }
            ?>
            <tr class="yith-wcdppm-payment-method">
                <th><?php echo apply_filters('yith_wcdppm_change_name_payment_method',__( 'Payment method', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' )); ?></th>
                <td id="yith-wcdppm-amount">

                </td>
            </tr>
            <?php
        }

        /**
         * Add metadata amount to an order and set new total order
         * @access public
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function add_amount_to_order( $order_id,$posted ) {
            $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;
            $user = wp_get_current_user();
            $order = wc_get_order($order_id);
            $payment_method = yit_get_prop($order,'_payment_method',true);
            $amount = $functions->yith_wcdppm_get_amount($payment_method, $user->roles);
            $ordertotal = $order->get_total() + $amount;

            if ($ordertotal > 0) {
                $order->set_total($order->get_total() + $amount);
            } else {
                $order->set_total(0);
            }
            if ( is_callable( array( $order, 'save') ) ) {

                $order->save();
            }

            yit_save_prop($order,'_yith_wcdppm_amount',$amount);
        }

        /**
         * Add Payment method fee row in order details page
         * @access public
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */

        public function add_item_fee($order_id) {

            $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;
            $user = wp_get_current_user();
            $order = wc_get_order($order_id);
            $payment_method = yit_get_prop($order,'_payment_method',true);
            $amount = $functions->yith_wcdppm_get_amount($payment_method, $user->roles);
            $order_fee_id = 'yith-wcdppm_fee';
            $order_fee_title = __('Payment Method Discount:', 'yith-dynamic-pricing-per-payment-method-for-woocommerce');
            $order_fee_amount = $amount;

            if ( $order instanceof WC_Data ) {
                $item = new WC_Order_Item_Fee();

                $item->set_props( array(
                    'name'      => $order_fee_title,
                    'tax_class' => 0,
                    'total'     => $amount,
                    'total_tax' => 0,
                    'taxes'     => array(
                        'total' => array(),
                    ),
                    'order_id'  => $order_id,
                ) );
                $item->save();
                $order->add_item( $item );


            } else {
                $order_fee            = new stdClass();
                $order_fee->id        = $order_fee_id;
                $order_fee->name      = $order_fee_title;
                $order_fee->amount    = floatval( $order_fee_amount );
                $order_fee->taxable   = false;
                $order_fee->tax       = 0;
                $order_fee->tax_data  = array();
                $order_fee->tax_class = '';

                $order->add_fee($order_fee);
            }

        }
    }
}

/**
 * Unique access to instance of YITH_Dynamic_Pricing_Payments_Methods_Frontend class
 *
 * @return \YITH_Dynamic_Pricing_Payments_Methods_Frontend
 * @since 1.0.0
 */

function YITH_Dynamic_Pricing_Payments_Methods_Frontend() {

    return YITH_Dynamic_Pricing_Payments_Methods_Frontend::get_instance();
}