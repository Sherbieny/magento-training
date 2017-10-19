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

    /**
     * Inactive Products
     * Products with filtered attributes:
     *  - NOT present in orders before defined date
     *  - Have no special price
     *  - Have type (simple, configurable, downloadable)
     * Since current orders are not very precise, current date will be
     * latest date available in orders
     */
    public function getFilteredProductsAction(){

        //Defining variables:
        $from_date='2013-5-29 02:36:47'; //Latest active date minus 3600sec
        $to_date='2014-5-30 03:36:47';
        $orderedProductsIDs = [];

        //Switching to Admin side to enable product manipulation
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        //Getting Orders
        $orders = Mage::getModel('sales/order')
            ->getCollection()
            ->addAttributeToFilter('created_at',
                ['from' => $from_date, 'to' => $to_date]);

        echo '<h2>Analysis</h2><br /><br />';

        //Handling Products per order
        if($orders != null){
            foreach ($orders as $order){
                //Get Order Items
                $items = $order->getAllVisibleItems();


                //Getting all products IDs
                foreach ($items as $item){
                    $orderedProductsIDs[] = $item->getProductID();
                }
                var_dump($orderedProductsIDs);
                //Getting all products excluding those above
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['nin' => $orderedProductsIDs]);

                //Handling products
                foreach ($products as $item){
                    $product = Mage::getModel('catalog/product')
                        ->load($item->getId());


                    //Data filtration:
                    //Filter out gifts and coupons && special prices
                    if($product->getTypeId() != null
                        && $product->getData('special_price') < 1){

                        echo 'Order ID: '.$order->getEntityID().'';
                        echo '<br /><br />';
                        echo 'Product Type: '. $product->getTypeId();
                        echo '<br />';
                        echo 'Product SKU: '. $product->getData('sku');
                        echo '<br />';
                        echo 'Product Price: '. $product->getData('price');
                        echo '<br />';
                        echo 'Product Special: '. $product->getData('special_price');
                        echo '<br />=========================';
                        echo '<br /><br />';



                        //Applying Discount
                        $price = $product->getData('price');
                        $discount = $price - (0.1 * $price);

                        echo 'Applying Discount......<br />';
                        $product->setData('special_price', $discount);
                       // $product->save();
                        echo 'Product new Special Price: '.$product->getData('special_price').'<br />';

                        echo '<br /><br />';
                    }

                }
            }
        }

    }
}