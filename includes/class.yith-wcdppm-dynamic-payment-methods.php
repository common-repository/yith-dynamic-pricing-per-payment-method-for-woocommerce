<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_WCDPPM_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_Dynamic_Pricing_Payments_Methods
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Your Inspiration Themes
 *
 */

if ( ! class_exists( 'YITH_Dynamic_Pricing_Payments_Methods' ) ) {
    /**
     * Class YITH_Dynamic_Pricing_Payments_Methods
     *
     * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
     */
    class YITH_Dynamic_Pricing_Payments_Methods {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0
         */
        public $version = YITH_WCDPPM_VERSION;
        /**
         * Main Instance
         *
         * @var YITH_Dynamic_Pricing_Payments_Methods
         * @since 1.0
         * @access protected
         */
        protected static $_instance = null;

        /**
         * Main Admin Instance
         *
         * @var YITH_Dynamic_Pricing_Payments_Methods_Admin
         * @since 1.0
         */
        public $admin = null;

        /**
         * Main Frontpage Instance
         *
         * @var YITH_Dynamic_Pricing_Payments_Methods_Frontend
         * @since 1.0
         */
        public $frontend = null;

        /**
         * Construct
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since 1.0
         */
        public function __construct(){

            /* === Require Main Files === */
            $require = apply_filters( 'yith_wcdppm_require_class',
                array(
                    'common'    => array(
                        'includes/class.yith-wcdppm-rule.php',
                        'includes/class.yith-wcdppm-dynamic-payment-methods-functions.php'
                    ),
                    'admin'     => array(
                        'includes/class.yith-wcdppm-post-types.php',
                        'includes/class.yith-wcdppm-dynamic-payment-methods-admin.php',
                        'includes/class.yith-wcdppm-dynamic-payment-methods-list-table.php',
                    ),
                    'frontend'  => array(
                        'includes/class.yith-wcdppm-dynamic-payment-methods-frontend.php',
                    ),
                )
            );

            $this->_require( $require );

            $this->init_classes();


            /* === Load Plugin Framework === */
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            /* == Plugins Init === */
            add_action( 'init', array( $this, 'init' ) );
        }

        /**
         * Main plugin Instance
         *
         * @return YITH_Dynamic_Pricing_Payments_Methods Main instance
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         */
        public static function instance()
        {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            if ( is_null( $self::$_instance ) ) {
                $self::$_instance = new $self;
            }

            return $self::$_instance;
        }

        public function init_classes() {
            $this->functions = YITH_WCDPPM_Functions::get_instance();
        }

        /**
         * Add the main classes file
         *
         * Include the admin and frontend classes
         *
         * @param $main_classes array The require classes file path
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since  1.0
         *
         * @return void
         * @access protected
         */
        protected function _require( $main_classes ) {
            foreach ( $main_classes as $section => $classes ) {
                foreach ( $classes as $class ) {
                    if ( 'common' == $section  || ( 'frontend' == $section && ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) || ( 'admin' == $section && is_admin() ) && file_exists( YITH_WCDPPM_PATH . $class ) ) {
                        require_once( YITH_WCDPPM_PATH . $class );
                    }
                }
            }
        }

        /**
         * Load plugin framework
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since  1.0
         * @return void
         */
        public function plugin_fw_loader() {
            if ( !defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if ( !empty( $plugin_fw_data ) ) {
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
        }

        /**
         * Function init()
         *
         * Instance the admin or frontend classes
         *
         * @author Carlos Rodríguez <carlos.rodriguez@yourinspiration.it>
         * @since  1.0
         * @return void
         * @access protected
         */
        public function init() {
            if ( is_admin() ) {
                $this->admin = new YITH_Dynamic_Pricing_Payments_Methods_Admin();
            }

            if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
                $this->frontend = new YITH_Dynamic_Pricing_Payments_Methods_Frontend();
            }
        }
    }
}