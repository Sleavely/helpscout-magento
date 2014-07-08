# sleavely/helpscout-magento

This is a "dynamic" custom app for Help Scout that fetches orders from Magento.

**Why, you say?**  
The built-in Magento app in Help Scout only fetches orders in batches and we didn't manage to get it working for all customers. This app doesn't care if the customer registered or placed the order as a guest, it simply finds orders by email address.

## Requirements

* PHP 5.3.0 or above
* Magento (duh!) with flat table structure
* Composer in your dev environment
* SSL-enabled web server for Help Scout

## Usage

1. Set up a custom app in Help Scout
2. Insert the secret key into index.php
4. Configure database in index.php
5. Edit the domain that orders are linked to
6. `composer update`
7. Open an order in Help Scout
