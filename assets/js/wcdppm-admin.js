/**
 * admin.js
 *
 * @author Your Inspiration Themes
 * @package YITH Dynamic Pricing per Payments Methods for WooCommerce
 * @version 1.0.0
 */

jQuery(document).ready( function($) {

    /*Js custom post type rule*/

    $('#_schedule_from').datepicker({
        dateFormat: 'yy-mm-dd',
    });
    $('#_schedule_to').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    $('#_yith_wcdppm_user_role').select2({
       // multiple: true
    });
});


