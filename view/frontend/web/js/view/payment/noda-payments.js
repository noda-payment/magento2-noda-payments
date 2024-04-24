/* @api */
define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'nodapayment',
            component: 'Noda_Payments/js/view/payment/method-renderer/nodapayment-method'
        }
    );

    /** Add view logic here if needed */
    return Component.extend({});
});
