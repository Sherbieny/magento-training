<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/16/17
 * Time: 3:08 PM
 */

class Sherbo_Hellobez_Block_Newproducts extends Mage_Core_Block_Template {

    /**
     * Get Filtered Products
     *
     * @return mixed
     */
    public function getProducts(){
        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->setOrder('created_at')
            ->setPageSize(5);

        return $products;
    }
}