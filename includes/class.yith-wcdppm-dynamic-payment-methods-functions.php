<?php
/**
 * Notes class
 *
 * @author  Yithemes
 * @package YITH Dynamic Payment per Methods for WooCommerce
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCDPPM_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}


if ( !class_exists( 'YITH_WCDPPM_Functions' ) ) {
    /**
     * YITH_WCDPPM_Functions
     *
     * @since 1.0.0
     */
    class YITH_WCDPPM_Functions {

        /**
         * Single instance of the class
         *
         * @var \YITH_WCDPPM_Functions
         * @since 1.0.0
         */
        protected static $_instance;
        

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCDPPM_Functions
         * @since 1.0.0
         */
        public static function get_instance() {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            if ( is_null( $self::$_instance ) ) {
                $self::$_instance = new $self;
            }

            return $self::$_instance;
        }

        /**
         * Constructor
         *
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function __construct() {
            
        }

        /**
         * Get payment gateway
         *
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function yith_wcdppm_get_payment_gateway()
        {
            $payment_methods = array();
            foreach (WC()->payment_gateways->payment_gateways() as $gateways) {
                $payment_methods[$gateways->id] = $gateways->title;
            }
            return apply_filters('yith_wcdppm_get_payment_gateway',$payment_methods);
        }
        /**
         * Get type dynamic pricing
         *
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function yith_wcdppm_get_type_dynamic_pricing ()
        {
            $type_dynamic_pricing = array(
                'dec_value' => __('Decrease by value','yith-dynamic-pricing-per-payment-method-for-woocommerce'),
            );
            return apply_filters('yith_wcdppm_get_type_dynamic_pricing',$type_dynamic_pricing);
        }

        /**
         * Get List of roles
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * return array of roles
         */
        public function yith_wcdppm_get_user_roles() {
            $roles_user = wp_roles()->roles;
            $role = array();
            foreach($roles_user as $roles=>$rol){
                $role[$roles] = $rol['name'];
            }
            return apply_filters('yith_wcdppm_get_user_roles',$role);
        }

        /**
         * Get a posts by $args
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * return array of posts
         */
        function yith_wcdppm_get_rules($args) {

            $defaults = apply_filters( 'yith_wcdppm_get_rule',array(
                'posts_per_page' => -1,
                'post_type' => 'yith-wcdppm-rule',
            ));

            $params = wp_parse_args( $args, $defaults );
            $results = get_posts( $params );
            return $results;
        }

        /**
         * Query post by type of payment method and by user role.
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        function yith_wcdppm_get_post_type_by_type($type,$roles) {
            $args = array(
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_payment_methods',
                        'value' => $type,
                        'compare' => '='
                    ),

                ) );

            return $this->yith_wcdppm_get_rules( $args );
        }

        /**
         * Get the dynamic payment method object.
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @param  mixed $post_type
         * @uses   WP_Post
         */

        function yith_wcdppm_get_dynamic_payment_method_object( $post_type ) {

            $_dynamic_payment = false;
            if ( false === $post_type ) {
                $post_type = $GLOBALS[ 'post' ];
                if ( $post_type && isset( $post_type->ID ) ) {
                    $_dynamic_payment = new YITH_WCDPPM_Rule( $post_type->ID );
                }
            } elseif ( is_numeric( $post_type ) ) {
                $_dynamic_payment = new YITH_WCDPPM_Rule($post_type);
            } elseif ( $post_type instanceof YITH_WCDPPM_Rule ) {
                $_dynamic_payment = $post_type;
            } elseif ( !( $post_type instanceof WP_Post ) ) {
                $_dynamic_payment = false;
            }

            return apply_filters( 'yith_wcdppm_dynamic_paymen_object', $_dynamic_payment );
        }

        /**
         * Get the amount of each payment method
         * @since  1.0.0
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */

        public function yith_wcdppm_get_amount($type,$roles)
        {
            $rules = $this->yith_wcdppm_get_post_type_by_type($type, $roles);
            $amount = 0;
            foreach ($rules as $rule) {
                $payment_rule = $this->yith_wcdppm_get_dynamic_payment_method_object($rule->ID);
                $amount -= $payment_rule->amount;
            }

            return $amount;
        } 
    }
}