/**
 * frontend.js
 *
 * @author Your Inspiration Themes
 * @package YITH Dynamic Pricing per Payments Methods for WooCommerce
 * @version 1.0.0
 */

jQuery( document ).ready( function ( $ ) {

    var change_amount_and_total = function ( $gateway ) {

        var $gateway_data   = $( '#yith-wcdppm-gateway-' + $gateway ),
            amount          = $gateway_data.data( 'amount' ),
            total           = $gateway_data.data( 'total' ),
            json            = $gateway_data.data('payment-method'),
            $order_review   = $( '#order_review' ),
            $amount_td      = $order_review.find( '#yith-wcdppm-amount' ).first(),
            $order_total_td = $order_review.find( '.order-total > td' ).first();

            if ( amount == 0 ) {
                $('.yith-wcdppm-payment-method').hide();
            } else {
                $('.yith-wcdppm-payment-method').show();

                if(amount > 0) {
                    $amount_td.html( '+'+json.amount );
                } else {
                    $amount_td.html( json.amount );
                }
            }
            if( total > 0) {
                $order_total_td.html( json.total );
            } else {
                $order_total_td.html( json.free );
            }
    };

    $( document ).on( 'change', '.input-radio[name="payment_method"]', function ( event ) {
        var $target = $( event.target );
        change_amount_and_total( $target.val() );
    } );


    $( document.body ).on( 'updated_checkout', function () {
        change_amount_and_total( $( '.woocommerce-checkout input[name="payment_method"]:checked' ).attr( 'value' ) );
    } );

} );


