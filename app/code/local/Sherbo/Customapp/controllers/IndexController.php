<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:06 PM
 */

class Sherbo_Customapp_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction(){

        echo 'setup';
    }

    public function getProductsAction(){

        $products = Mage::getModel('catalog/product')
            ->getCollection();


        echo '<h2>The products</h2>';

        var_dump($products);
    }
}