# Noda Payments module

This module integrates Noda payment gateway into magento:

### Prior steps
Before proceeding with the plugin installation and configuration, ensure you've completed the onboarding process, signed the contract with Noda and obtained access to the Production API keys.
If you haven't completed these steps, please visit [Noda HUB](https://ui.noda.live/hub/) and follow the provided step-by-step guide.


## Module Installation

Before installing this module, note that the Noda_Payments is dependent on the following modules:

- `Magento_Store`
- `Magento_Catalog`
- `Magento_Sales`
- `Magento_Webapi`
- `Magento_Directory`
- `Magento_Checkout`
- `Magento_Payment`
- `Magento_Payment`


Please follow the detailed instructions on how to install Magento module: [Custom magento 2 module setup](https://www.nexcess.net/blog/how-to-install-a-magento-2-extension/#:~:text=Log%20in%20to%20your%20Magento%20Marketplace%20account%20and%20navigate%20to,to%20install%20a%20specific%20version)

### What needs to be done in case the link is not working for you:
1. Upload archive to your hosting;
2. unzip it into the `app/code` directory of magento 2 project;
3. run the following commands to make the installation and update the configuration of Magento:
```
php bin/magento setup:upgrade

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f
```
4. Verify the module is installed and active:
```
php bin/magento module:status Noda_Payments
```
and enable it if it is still disabled:
```
php bin/magento module:enable Noda_Payments
```
5. configuration the module
By default the module is configured in testing mode.
In testing mode, payments are processed, but no real money transfers occur.
No additional configuration is needed if you intend to perform test payments only.

Please keep in mind, that default values for 'Api Key', 'Signature', and 'Shop Id' are intended for testing purposes only.

In order to transition to live, real payments, follow the steps below:
- Go to `Noda` payment methods configuration in admin tool at `Sales` > `Configuration` > `Sales` > `Payment Methods` > `NodaPay`
- ``Disable`` the ``'Test Mode'`` option by choosing ``"No"`` in the dropdown
- Fill in the  `'Api Key'`, `'Signature'`, and `'Shop Id'` values with your organization's specific credentials, which can be accessed in your [Noda HUB personal account](https://ui.noda.live/hub/integration).

## Extensibility

Extension developers can interact with the Noda_Payments module. For more information about the Magento extension mechanism, see [Magento plug-ins](https://developer.adobe.com/commerce/php/development/components/plugins/).

[The Magento dependency injection mechanism](https://developer.adobe.com/commerce/php/development/components/dependency-injection/) enables you to override the functionality of the Noda_Payments module.

A lot of functionality in the module is on JavaScript, use [mixins](https://developer.adobe.com/commerce/frontend-core/javascript/mixins/) to extend it.

### Layouts

This module introduces the following layouts in the `view/frontend/layout` directory:

- `checkout_index_index`

For more information about a layout in Magento 2, see the [Layout documentation](https://developer.adobe.com/commerce/frontend-core/guide/layouts/).
