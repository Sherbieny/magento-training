# Customapp

Magento custom module for a price discount admin panel and a daily cron job

### Enviroment
  > Ubuntu 16.04

  > LAMP

  > PHPStorm


### Installation
```sh
$ copy Sherbo folder to app/code/local
$ copy Sherbo_Customapp.xml to app/etc/modules
$ copy button.phtml to app/design/adminhtml/default/default/template/sherbo/system/config
```
### Features
* ##### Automatic Price Discounts admin panel:
    *  **Time**: input time in seconds
    *  **Discount Percent**: input discount amount
    *  **Remove Discount**: Apply/Remove discount
* ##### CRON Job: 
    * Apply discount at 01:00AM for 10% on all orders not sold for 3600 seconds

