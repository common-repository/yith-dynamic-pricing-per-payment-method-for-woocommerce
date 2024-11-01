<style>
    .section{
        margin-left: -20px;
        margin-right: -20px;
        font-family: "Raleway",san-serif;
    }
    .section h1{
        text-align: center;
        text-transform: uppercase;
        color: #808a97;
        font-size: 35px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 50px 0 0;
    }
    .section ul{
        list-style-type: disc;
        padding-left: 15px;
    }
    .section:nth-child(even){
        background-color: #fff;
    }
    .section:nth-child(odd){
        background-color: #f1f1f1;
    }
    .section .section-title img{
        display: table-cell;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }
    .section h2,
    .section h3 {
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
    }

    .section .section-title h2{
        display: table-cell;
        vertical-align: middle;
        line-height: 25px;
    }

    .section-title{
        display: table;
    }

    .section h3 {
        font-size: 14px;
        line-height: 28px;
        margin-bottom: 0;
        display: block;
    }

    .section p{
        font-size: 13px;
        margin: 15px 0;
    }
    .section ul li{
        margin-bottom: 4px;
    }
    .landing-container{
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }
    .landing-container:after{
        display: block;
        clear: both;
        content: '';
    }
    .landing-container .col-1,
    .landing-container .col-2{
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }
    .landing-container .col-1 img{
        width: 100%;
    }
    .landing-container .col-1{
        width: 55%;
    }
    .landing-container .col-2{
        width: 45%;
    }
    .premium-cta{
        background-color: #808a97;
        color: #fff;
        border-radius: 6px;
        padding: 20px 15px;
    }
    .premium-cta:after{
        content: '';
        display: block;
        clear: both;
    }
    .premium-cta p{
        margin: 7px 0;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }
    .premium-cta a.button{
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>images/upgrade.png) #ff643f no-repeat 13px 13px;
        border-color: #ff643f;
        box-shadow: none;
        outline: none;
        color: #fff;
        position: relative;
        padding: 9px 50px 9px 70px;
    }
    .premium-cta a.button:hover,
    .premium-cta a.button:active,
    .premium-cta a.button:focus{
        color: #fff;
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>images/upgrade.png) #971d00 no-repeat 13px 13px;
        border-color: #971d00;
        box-shadow: none;
        outline: none;
    }
    .premium-cta a.button:focus{
        top: 1px;
    }
    .premium-cta a.button span{
        line-height: 13px;
    }
    .premium-cta a.button .highlight{
        display: block;
        font-size: 20px;
        font-weight: 700;
        line-height: 20px;
    }
    .premium-cta .highlight{
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

    .section.one{
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
    }
    .section.two{
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/02-bg.png) no-repeat #fff; background-position: 15% 100%;
    }
    .section.three{
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
    }
    .section.four{
        background: url(<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/04-bg.png) no-repeat #fff; background-position: 15% 100%;
    }


    @media (max-width: 768px) {
        .section{margin: 0}
        .premium-cta p{
            width: 100%;
        }
        .premium-cta{
            text-align: center;
        }
        .premium-cta a.button{
            float: none;
        }
    }

    @media (max-width: 480px){
        .wrap{
            margin-right: 0;
        }
        .section{
            margin: 0;
        }
        .landing-container .col-1,
        .landing-container .col-2{
            width: 100%;
            padding: 0 15px;
        }
        .section-odd .col-1 {
            float: left;
            margin-right: -100%;
        }
        .section-odd .col-2 {
            float: right;
            margin-top: 65%;
        }
    }

    @media (max-width: 320px){
        .premium-cta a.button{
            padding: 9px 20px 9px 70px;
        }

        .section .section-title img{
            display: none;
        }
    }
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Dynamic Pricing per Payment Method for WooCommerce%2$s to benefit from all features!','yith-dynamic-pricing-per-payment-method-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/01.png" alt="Feature 01" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Surcharge or discount?','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php _e('Do you want to encourage users to make bank transfers rather than cheques? Or do you want to apply a surcharge only for a specific payment method? ', 'yith-dynamic-pricing-per-payment-method-for-woocommerce');?>
                </p>
                <p>
                    <?php echo sprintf(__('These are the two available scenarios that the plugin allows to manage: choose the one you prefer for each available payment method by applying a %1$sdiscount%2$s or %1$ssurcharge%2$s on the cart total.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('More price rules','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Thanks to the plugin premium version, you’ll be able to %1$screate and combine more price rules%2$s for the same payment method. You could, for example, think of applying a 5% discount on cheque payments for all users and an additional 10% off shop managers.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/02.png" alt="feature 02" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/03.png" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/03-icon.png"/>
                    <h2><?php _e('Additional information','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Add a %1$sshort description%2$s for each payment rule configured that will be visible to users on the Checkout page in the payment method box.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/04-icon.png" />
                    <h2><?php _e('User roles','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Create an ad hoc rule for specific users: choose the %1$suser roles%2$s to which applying the rule you have created and it’s done.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('In simple words, you’ll be able to give a %1$s10% off%2$s to all your "shop managers" that’ll choose Stripe to pay for the order.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/04.png" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/05.png" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/05-icon.png"/>
                    <h2><?php _e('Tax','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Did you choose to apply a discount or a percent surcharge based on the cart amount? Well, choose whether to %1$sinclude tax to the cart total or not%2$s, on which the payment method discount/surcharge will apply', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/06-icon.png" />
                    <h2><?php _e('Cart amount','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Do you want to offer a discount to those who use a %1$sspecific payment method%2$s, but you want that this applies only if the cart amount exceeds $100? With the premium version, you’ll be able to this as well.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('Optionally, you’ll be able to set a %1$sminimum and/or maximum cart%2$s amount needed for the payment method rule to apply.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/06.png" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/07.png" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCDPPM_ASSETS_URL ?>/images/07-icon.png"/>
                    <h2><?php _e('Limited-time offers','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Make the payment rules you’ve just created automatic! You’ll be able to %1$sschedule start%2$s and %1$send date%2$s for each rule and make it automatically apply.', 'yith-dynamic-pricing-per-payment-method-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH Dynamic Pricing per Payment Method for WooCommerce%2$s to benefit from all features!','yith-dynamic-pricing-per-payment-method-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-dynamic-pricing-per-payment-method-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
</div>