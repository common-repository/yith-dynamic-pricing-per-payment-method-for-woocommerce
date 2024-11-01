<?php

    if(defined('YITH_WCDPPM_PREMIUM')) {
        $wcdppm_cpt_rules = new YITH_WCDPPM_Dynamic_Pricing_Per_Payment_Methods_List_Table_Premium();
    }else{
        $wcdppm_cpt_rules = new YITH_WCDPPM_Dynamic_Pricing_Per_Payment_Methods_List_Table();
    }

    $admin_url = admin_url('post-new.php');
    $params = array(
        'post_type' => 'yith-wcdppm-rule'
    );

    $add_new_url = esc_url(add_query_arg($params, $admin_url));
    
?>

<div class="wrap">
    <h1><?php _e('Dynamic Pricing per Payment Methods Rules', 'yith-dynamic-pricing-per-payment-method-for-woocommerce') ?><a href="<?php echo $add_new_url; ?>" class="add-new-h2"><?php _e('Add new','yith-dynamic-pricing-per-payment-method-for-woocommerce')?></a> </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <input type="hidden" name="page" value="yith_dynamic_pricing_payment_method_for_woocommerce" />
                    </form>
                    <form method="post">
                        <?php
                        $wcdppm_cpt_rules->views();
                        $wcdppm_cpt_rules->prepare_items();
                        $wcdppm_cpt_rules->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>