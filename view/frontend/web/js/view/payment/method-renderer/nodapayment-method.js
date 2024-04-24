define(
    [
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Checkout/js/action/redirect-on-success',
        'Magento_Checkout/js/model/error-processor',
        'mage/storage',
        'mage/url'
    ],
    function (
        Component,
        additionalValidators,
        redirectOnSuccessAction,
        errorProcessor,
        storage,
        urlBuilder
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Noda_Payments/payment/nodapayment'
            },
            redirectAfterPlaceOrder: false,
            logoUrl: '',
            logoAlt: 'Place Order Nodapayment',

            initObservable: function ()
            {
                this._super()
                    .observe([
                        'logoUrl',
                        'logoAlt'
                    ]);

                this.initLogoUrl();

                return this;
            },

            /**
             * Initial Logo Url
             */
            initLogoUrl: function () {
                let serviceUrl = urlBuilder.build('/rest/V1/nodapay/logo', {});
                var self = this;

                return storage.get(
                    serviceUrl
                ).fail(
                    function (response) {
                        errorProcessor.process(response, messageContainer);
                    }
                ).done(
                    function (response) {
                        self.logoUrl(response.url)
                    }
                );
            },

            /**
             * Place order.
             */
            placeOrder: function (data, event) {
                var self = this;

                if (event) {
                    event.preventDefault();
                }

                if (this.validate() &&
                    additionalValidators.validate() &&
                    this.isPlaceOrderActionAllowed() === true
                ) {
                    this.isPlaceOrderActionAllowed(false);

                    this.getPlaceOrderDeferredObject()
                        .done(
                            function (order) {

                                let nodaButton = document.getElementById("nodapay-button");

                                nodaButton.dataset.order = order

                                self.afterPlaceOrder();

                                if (self.redirectAfterPlaceOrder) {
                                    redirectOnSuccessAction.execute();
                                }
                            }
                        ).always(
                            function () {
                                self.isPlaceOrderActionAllowed(true);
                            }
                        );

                    return true;
                }

                return false;
            },

            /**
             * After place order callback
             */
            afterPlaceOrder: function () {
                let paymentId = document.getElementById('nodapay-button').dataset.order,
                    requestData = JSON.stringify({
                        payment_id: paymentId,
                    });

                let xhr = new XMLHttpRequest();

                xhr.open('POST', '/rest/V1/nodapay/payUrl', true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);

                        if (response.hasOwnProperty('pay_url')) {
                            window.location.href = response.pay_url;
                        } else {
                            console.log("invalid endpoint response")
                        }
                    } else {
                        console.log("Invalid response status code")
                    }
                };
                xhr.send(requestData)
            },
        });
    }
);
