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
 * @class      YITH_Dynamic_Pricing_Payments_Methods_Admin
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
 *
 */

if ( !class_exists( 'YITH_Dynamic_Pricing_Payments_Methods_Admin' ) ) {
    /**
     * Class YITH_Dynamic_Pricing_Payments_Methods_Admin
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class YITH_Dynamic_Pricing_Payments_Methods_Admin {

        /**
         * @var Panel object
         */
        protected $_panel = null;


        /**
         * @var Panel page
         */
        protected $_panel_page = 'yith_wcdppm_panel';

        /**
         * @var bool Show the premium landing page
         */
        public $show_premium_landing = true;

        /**
         * @var string Official plugin documentation
         */
        protected $_official_documentation = 'http://docs.yithemes.com/yith-dynamic-pricing-per-payment-method-for-woocommerce/';
        /**
         * @var string Official premium plugin
         */
        protected $_premium_landing_url = 'http://yithemes.com/themes/plugins/yith-dynamic-pricing-per-payment-method-for-woocommerce/';


        /**
         * Single instance of the class
         *
         * @var \YITH_Dynamic_Pricing_Payments_Methods_Admin
         * @since 1.0.0
         */
        protected static $_instance = null;

        /**
         * Returns single instance of the class
         *
         * @return \YITH_Dynamic_Pricing_Payments_Methods_Admin
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
        public function __construct() {
            /* === Register Panel Settings === */
            add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );

            // Enqueue Scripts
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11);

            add_action( 'yith_wcdppm_premium_tab', array( $this, 'show_premium_landing' ) );

            add_action('yith_wcdppm_settings_tab',array($this,'show_dynamic_pricing_per_payment_method_rules_tab'));

            add_action('woocommerce_saved_order_items', array($this,'recalculate_order_total'),10,2);

        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = apply_filters( 'yith_wcdppm_admin_tabs', array(
                    'settings'   => __( 'Settings', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                )
            );

            if( $this->show_premium_landing ){
                $admin_tabs['premium'] = __( 'Premium Version', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' );
            }

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => _x( 'Dynamic Pricing per Payment Method', 'plugin name in admin page title', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'menu_title'       => _x( 'Dynamic Pricing per Payment Method', 'plugin name in admin WP menu', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                'capability'       => 'manage_options',
                'parent'           => 'yith-dynamic-pricing-per-payment-method-for-woocommerce',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCDPPM_OPTIONS_PATH,
                'links'            => $this->get_sidebar_link()
            );


            /* === Fixed: not updated theme/old plugin framework  === */
            if ( !class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once('plugin-fw/lib/yit-plugin-panel-wc.php' );
            }


            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );

            add_action( 'woocommerce_admin_field_yith_dynamic_pricing_per_payment_methods_upload', array( $this->_panel, 'yit_upload' ), 10, 1 );
        }


        /**
         * Sidebar links
         *
         * @return   array The links
         * @since    1.2.1
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function get_sidebar_link() {
            $links = array(
                array(
                    'title' => __( 'Plugin documentation', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                    'url'   => $this->_official_documentation,
                ),
                array(
                    'title' => __( 'Help Center', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                    'url'   => 'http://support.yithemes.com/hc/en-us/categories/202568518-Plugins',
                ),
                array(
                    'title' => __( 'Support platform', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ),
                    'url'   => 'https://yithemes.com/my-account/support/dashboard/',
                ),
                /*array(
                    'title' => sprintf( '%s (%s %s)', __( 'Changelog', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ), __( 'current version', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ), YITH_WCDPPM_VERSION ),
                    'url'   => 'https://yithemes.com/docs-plugins/yith-woocommerce-multi-step-checkout/07-changelog-premium.html',
                ),*/
            );

            return $links;
        }



        /**
         * Enqueue styles and scripts
         *
         * @access public
         * @return void
         * @since 1.0.0
         * @author   Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public function enqueue_styles_scripts() {

            wp_register_style( 'yith_wcdppm_admincss', YITH_WCDPPM_ASSETS_URL . 'css/wcdppm-admin.css', YITH_WCDPPM_VERSION );
            wp_register_script( 'yith_wcdppm_admin', YITH_WCDPPM_ASSETS_URL . 'js/wcdppm-admin.js', array( 'jquery','jquery-ui-sortable','wc-enhanced-select' ), YITH_WCDPPM_VERSION, true );

            wp_localize_script( 'yith_wcdppm_admin', 'yith_wcdppm_admin', apply_filters( 'yith_wcdppm_admin_localize',array(
                'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
            )));

            if ( is_admin() ){
                wp_enqueue_script('yith_wcdppm_admin');
                wp_enqueue_style('yith_wcdppm_admincss');
            }

        }

        /**
         * Show the premium landing
         *
         * @author Carlos Rodriguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0.0
         * @return void
         */
        public function show_premium_landing(){
            if( file_exists( YITH_WCDPPM_TEMPLATE_PATH . 'premium/premium.php' )&& $this->show_premium_landing ){
                require_once( YITH_WCDPPM_TEMPLATE_PATH . 'premium/premium.php' );
            }
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri()
        {
            return defined('YITH_REFER_ID') ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url.'?refer_id=1030585';
        }
        
        /**
         * show all rules tab
         * @author YITHEMES
         * @since 1.0.0
         */
        public function show_dynamic_pricing_per_payment_method_rules_tab()
        {
            wc_get_template( 'admin/dynamic-pricing-per-payment-method-rules.php', array(), '', YITH_WCDPPM_TEMPLATE_PATH );
        }


        /**
         * recalculate negative order total
         * @author YITHEMES
         * @since 1.0.0
         */
        public function recalculate_order_total($order_id,$items) {
            $order = wc_get_order($order_id);
            $amount = yit_get_prop($order,'_yith_wcdppm_amount',true);
            if ($amount) {
                $ordertotal = wc_format_decimal($items['_order_total']);
                if ($ordertotal < 0){
                    yit_save_prop( $order, '_order_total', wc_format_decimal(0) );
                }
            }
        }
        
    }


}

/**
 * Unique access to instance of YITH_Dynamic_Pricing_Payments_Methods_Admin class
 *
 * @return \YITH_Dynamic_Pricing_Payments_Methods_Admin
 * @since 1.0.0
 */
function YITH_Dynamic_Pricing_Payments_Methods_Admin() {

    return YITH_Dynamic_Pricing_Payments_Methods_Admin::get_instance();
}