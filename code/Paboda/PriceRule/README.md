# Mage2 Module Paboda PriceRule

    ``paboda/module-pricerule``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [DB](#markdown-header-db)


## Main Functionalities
- Add a custom price rule functionality to be shown in product detail pages and product listing pages with the label "Your price"
- Add, edit, delete, multiple delete features via backend


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Paboda`
 - Enable the module by running `php bin/magento module:enable Paboda_PriceRule`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Install the module composer by running `composer require paboda/module-pricerule`
 - enable the module by running `php bin/magento module:enable Paboda_PriceRule`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - Backend --> PRICE RULE (menu on the left menu bar) --> Price Rule


## Specifications

Needs to create a module that does the following:
1. Add a new page to the admin panel with a grid and form where the admin can specify a special price for a special customer.
2. Also, the admin can specify Start Date and End Date for that price.
3. On the frontend area for a customer who has a special price should be displayed price from this grid + label near price “Your price”
It should be custom logic (not catalog or sales price rules, not default special price, etc)
The price should be for a specific product and a specific customer. That is, the admin can choose a product, customer, and set a price that will be for the product for this customer. 


## DB
 - Add a new datatable named "custom_pricerule"


