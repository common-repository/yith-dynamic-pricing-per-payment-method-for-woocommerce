<?php

/*
Plugin Name: YITH Dynamic Pricing per Payment Method for WooCommerce
Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-dynamic-pricing-per-payment-methods/
Description: YITH Dynamic Pricing per Payment Method for WooCommerce allows you to set a discount depending on the payment method used.
Author: YITHEMES
Text Domain: yith-dynamic-pricing-per-payment-method-for-woocommerce
Version: 1.2.0
Author URI: http://yithemes.com/
WC requires at least: 3.0.0
WC tested up to: 3.3.0
*/

/*
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if( ! function_exists( 'yith_wcdppm_install_woocommerce_admin_notice' ) ) {
    /**
     * Print an admin notice if WooCommerce is deactivated
     *
     * @author Carlos Rodriguez <carlos.rodriguez@yourinspiration.it>
     * @since 1.0
     * @return void
     * @use admin_notices hooks
     */
    function yith_wcdppm_install_woocommerce_admin_notice() { ?>
        <div class="error">
            <p><?php _ex( 'YITH Dynamic Pricing per Payment Method for WooCommerce is enabled but not effective. It requires WooCommerce in order to work.', 'Alert Message: WooCommerce requires', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' ); ?></p>
        </div>
        <?php
    }
}


/**
 * Check if WooCommerce is activated
 *
 * @author Carlos Rodriguez <carlos.rodriguez@yourinspiration.it>
 * @since 1.0
 * @return void
 * @use admin_notices hooks
 */
if(!function_exists('yith_wcdppm_install')){
    function yith_wcdppm_install() {

        if ( !function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'yith_wcdppm_install_woocommerce_admin_notice' );
        } else {
            do_action( 'yith_wcdppm_init' );
        }
    }
}
add_action( 'plugins_loaded', 'yith_wcdppm_install', 11 );

if( ! function_exists( 'yit_deactive_free_version' ) ) {
    require_once 'plugin-fw/yit-deactive-plugin.php';
}

/* === DEFINE === */
! defined( 'YITH_WCDPPM_VERSION' )            && define( 'YITH_WCDPPM_VERSION', '1.2.0' );
! defined( 'YITH_WCDPPM_FREE_INIT' )          && define( 'YITH_WCDPPM_FREE_INIT', plugin_basename( __FILE__ ) );
! defined( 'YITH_WCDPPM_SLUG' )               && define( 'YITH_WCDPPM_SLUG', 'yith-dynamic-pricing-per-payment-method-for-woocommerce' );
! defined( 'YITH_WCDPPM_SECRETKEY' )          && define( 'YITH_WCDPPM_SECRETKEY', '67WiDt54JQy26P0jVJqE' );
! defined( 'YITH_WCDPPM_FILE' )               && define( 'YITH_WCDPPM_FILE', __FILE__ );
! defined( 'YITH_WCDPPM_PATH' )               && define( 'YITH_WCDPPM_PATH', plugin_dir_path( __FILE__ ) );
! defined( 'YITH_WCDPPM_URL' )                && define( 'YITH_WCDPPM_URL', plugins_url( '/', __FILE__ ) );
! defined( 'YITH_WCDPPM_ASSETS_URL' )         && define( 'YITH_WCDPPM_ASSETS_URL', YITH_WCDPPM_URL . 'assets/' );
! defined( 'YITH_WCDPPM_TEMPLATE_PATH' )      && define( 'YITH_WCDPPM_TEMPLATE_PATH', YITH_WCDPPM_PATH . 'templates/' );
! defined( 'YITH_WCDPPM_WC_TEMPLATE_PATH' )   && define( 'YITH_WCDPPM_WC_TEMPLATE_PATH', YITH_WCDPPM_PATH . 'templates/woocommerce/' );
! defined( 'YITH_WCDPPM_OPTIONS_PATH' )       && define( 'YITH_WCDPPM_OPTIONS_PATH', YITH_WCDPPM_PATH . 'panel' );

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_WCDPPM_PATH . 'plugin-fw/init.php' ) ) {
    require_once( YITH_WCDPPM_PATH . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YITH_WCDPPM_PATH  );


function yith_wcdppm_init() {
    load_plugin_textdomain( 'yith-dynamic-pricing-per-payment-method-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


    if ( ! function_exists( 'YITH_Dynamic_Pricing_Payments_Methods' ) ) {
        /**
         * Unique access to instance of YITH_Dynamic_Pricing_Payments_Methods class
         *
         * @return YITH_Dynamic_Pricing_Payments_Methods
         * @since 1.0.0
         */
        function YITH_Dynamic_Pricing_Payments_Methods() {
            // Load required classes and functions

            require_once(YITH_WCDPPM_PATH . 'includes/class.yith-wcdppm-dynamic-payment-methods.php' );

            if ( defined( 'YITH_WCDPPM_PREMIUM' ) && file_exists(YITH_WCDPPM_PATH . 'includes/class.yith-wcdppm-dynamic-payment-methods-premium.php' ) ) {
                require_once( YITH_WCDPPM_PATH . 'includes/class.yith-wcdppm-dynamic-payment-methods-premium.php' );
                return YITH_Dynamic_Pricing_Payments_Methods_Premium::instance();
            }
            return YITH_Dynamic_Pricing_Payments_Methods::instance();
        }
    }

    // Let's start the game!
    YITH_Dynamic_Pricing_Payments_Methods();
}

add_action( 'yith_wcdppm_init', 'yith_wcdppm_init' );