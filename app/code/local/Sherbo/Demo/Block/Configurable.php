<?php

    class Sherbo_Demo_Block_Configurable extends Mage_Core_Block_Template {
        public function getConfigurableProducts(){
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect(['name', 'price', 'url_key'])
                ->addAttributeToFilter('type_id', ['eq' => 'configurable']);

            return $products;
        }
    }