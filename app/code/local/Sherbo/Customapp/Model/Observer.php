<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/20/17
 * Time: 12:53 AM
 */

class Sherbo_Customapp_Model_Observer {

    public function logToHtml($data){
        $loghtml = 'var/log/test.html';

        file_put_contents($loghtml, '');
        file_put_contents($loghtml, $data);

    }

    public function logInfo($data){
        $logfile = 'customapp.log';

        Mage::log($data, null, $logfile, true);
    }

    public function execute(){

        //Defining variables
        $recent_date='2014-4-30 03:36:47'; //most recent order date in DB
        //$from_date='2013-4-25 02:36:47'; //Added this to reduce resource consumption
        $orderedProductsIds = [];
        $logString = '';
        $time = 3600; $discount = 10; $disable = 2;

        //Latest active date minus given time
        $to_date= date("Y-n-d H:i:s", strtotime($recent_date) - $time);
        //$this->logToHtml('New Time: '.$recent_date);

        //Error Check
        if($disable != 1 and $disable != 2){
            $this->logInfo('Data Error');
            $this->logInfo($disable);
            exit;
        }

        //Switching to Admin side to enable product manipulation
        //Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $this->logInfo('Processing');
        $this->logInfo($time);
        $this->logInfo($discount);
        $this->logInfo($disable);
        $this->logInfo('from date '.$recent_date);
        $this->logInfo('to date: '.$to_date);
        //Getting Orders
        $orders = Mage::getModel('sales/order')
            ->getCollection()
            ->addAttributeToFilter('created_at',
                ['from' => '', 'to' => $to_date]);

        $logString .= '<h2>Analysis</h2><br /><br />';

        $this->logInfo('Model queried');


        //Handling Products per order
        if($orders != null){
            foreach ($orders as $order){
                //Get Order Items
                $items = $order->getAllVisibleItems();


                //Getting all products IDs
                foreach ($items as $item){
                    $orderedProductsIds[] = $item->getProductID();
                }
            }

            $this->logInfo('Total recently sold products: '.count($orderedProductsIds));


            //Check Decision [1 -> YES -> Cancel discount][2 -> NO -> Apply discount]
            if($disable == 1){

                //Load all the products
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addFieldToFilter('entity_id', ['in' => $orderedProductsIds]);

                $this->logInfo('Total products to be reset: '.$products->getSize()); //Number here is less, I guess some products like coupons do not have entity IDs

                //Reset special price field
                foreach ($products as $product){
                    $product->setData('special_price', 0);
                    $product->save();
                }
                $this->logInfo('Special Prices removed');

            }
            else{

                //Getting all products excluding those above
                //which should be discounted
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['nin' => $orderedProductsIds]);

                $this->logInfo('Total products to be discounted: '.$products->getSize());

                //Handling products
                foreach ($products as $product){

                    //Data filtration:
                    //Filter out gifts and coupons
                    if($product->getTypeId() != null){

                        //Filter out products with lower special price
                        $price = $product->getData('price');
                        $special_price = $price - (($discount/100) * $price);

                        if($special_price < $product->getData('special_price')){
                            $logString .= 'Order ID: '.$order->getEntityID().'';
                            $logString .= '<br /><br />';
                            $logString .= 'Product Type: '. $product->getTypeId();
                            $logString .= '<br />';
                            $logString .= 'Product SKU: '. $product->getData('sku');
                            $logString .= '<br />';
                            $logString .= 'Product Price: '. $product->getData('price');
                            $logString .= '<br />';
                            $logString .= 'Product Special: '. $product->getData('special_price');
                            $logString .= '<br />=========================';
                            $logString .= '<br /><br />';

                            //Applying Discount
                            $logString .= 'Applying Discount......<br />';
                            $product->setData('special_price', $special_price);
                            $product->save();
                            $logString .= 'Product new Special Price: '.$product->getData('special_price').'<br />';
                        }


                        $logString .= '<br /><br />';


                    }

                }
            }

        }
        $this->logToHtml($logString);

    }
}