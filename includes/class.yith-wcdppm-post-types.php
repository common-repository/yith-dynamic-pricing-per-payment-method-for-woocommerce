<?php
/**
 * Post Types class
 *
 * @author  Yithemes
 * @package YITH Dynamic Payments Methods for WooCommerce
 * @version 1.0.0
 */

if ( !defined( 'YITH_WCDPPM_VERSION' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WCDPPM_Post_Types' ) ) {
    /**
     * YITH Dynamic Payments Methods for WooCommerce Premium Post Types
     *
     * @since 1.0.0
     */
    class YITH_WCDPPM_Post_Types {


        /**
         * Dynamic Payment Post Type
         *
         * @var string
         * @static
         */
        public static $dynamic_payments = 'yith-wcdppm-rule';

        /**
         * Hook in methods.
         */
        public function __construct() {
            add_action( 'init', array($this, 'register_post_types' ));
            add_action( 'init', array( $this, 'add_style_metabox' ));
            add_action( 'edit_form_advanced', array( $this, 'add_return_to_list_button' ) );
        }

        /**
         * Register core post types.
         */
        public function register_post_types() {
            if ( post_type_exists( self::$dynamic_payments ) ) {
                return;
            }

            do_action( 'yith_wcdppm_register_post_type' );

            /*  DYNAMIC PRICING PAYMENTS METHODS  */

            $labels = array(
                'name'               => __( 'Dynamic Price per Payment Methods', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'singular_name'      => __( 'Dynamic Price per Payment Methods', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'add_new'            => __( 'Add new rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'add_new_item'       => __( 'Add New Rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'edit'               => __( 'Edit', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'edit_item'          => __( 'Edit Rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'new_item'           => __( 'New Rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'view'               => __( 'View Rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'view_item'          => __( 'View Rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'search_items'       => __( 'Search Rules', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'not_found'          => __( 'No Rules found', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'not_found_in_trash' => __( 'No Rules found in trash', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'parent'             => __( 'Parent Rules', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'menu_name'          => _x( 'YITH Rules', 'Admin menu name', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'all_items'          => __( 'All YITH Rules', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
            );

            $dynamic_payments_post_type_args = array(
                'label'               => __( 'Dynamic Payment Methods', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'labels'              => $labels,
                'description'         => __( 'This is where rules are stored.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'public'              => true,
                'show_ui'             => true,
                'capability_type'     => 'product',
                'map_meta_cap'        => true,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_menu'        => false,
                'hierarchical'        => false,
                'show_in_nav_menus'   => false,
                'rewrite'             => false,
                'query_var'           => false,
                'supports'            => array( 'title' ),
                'has_archive'         => false,
                'menu_icon'           => 'dashicons-edit',
            );

            register_post_type( self::$dynamic_payments, apply_filters( 'yith_wcdppm_register_post_type_dynamic_payments_methods', $dynamic_payments_post_type_args ) );

        }
        /**
         * Add style metabox custom post type.
         */
        public function add_style_metabox() {
            $currency_simbol = get_woocommerce_currency_symbol();
            $functions = YITH_Dynamic_Pricing_Payments_Methods()->functions;
            $args = array(
                'label'    => __( 'Payment method price rule', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'pages'    => self::$dynamic_payments,
                'context'  => 'normal',
                'priority' => 'high',
                'tabs'     => apply_filters( 'yith_wcdppm_dynamic_pricing_per_payments_settings', array(
                    'style' => array(
                        'label'  => __( 'Dynamic pricing per payments - form', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                        'fields' => apply_filters('yith_wcdppm_post_type_field', array(
                            'payment_methods'       => array(
                                'label' => __( 'Payment method', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                                'desc'  => '',
                                'type'  => 'select',
                                'options' => $functions->yith_wcdppm_get_payment_gateway(),
                            ),
                            'amount' => array(
                                'label' => __( 'Amount', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                                'desc'  => '',
                                'type'  => 'text',
                            ),
                        ) )
                    )
                ) )
            );

            $metabox = YIT_Metabox( 'yith-wcdppm-search-form-style' );
            $metabox->init( $args );

        }

        public function add_return_to_list_button() {
            global $post;

            if ( isset( $post ) && self::$dynamic_payments === $post->post_type ) {
                $admin_url = admin_url( 'admin.php' );
                $params = array(
                    'page' => 'yith_wcdppm_panel',
                    'tab' => 'settings'
                );

                $list_url = apply_filters( 'yith_wcdppm_rule_back_link', esc_url( add_query_arg( $params, $admin_url ) ) );
                $button = sprintf( '<a class="button-secondary" href="%s">%s</a>', $list_url,
                    __( 'Back to rules',
                        'yith-dynamic-pricing-per-payment-method-for-woocommerce' ) );
                echo $button;
            }
        }
    }
}

return new YITH_WCDPPM_Post_Types();