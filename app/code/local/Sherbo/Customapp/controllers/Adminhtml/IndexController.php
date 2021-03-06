<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:23 PM
 */

class Sherbo_Customapp_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    public function indexAction(){
        echo 'admin setup';
    }

    public function logToHtml($data){
        $loghtml = 'var/log/test.html';

        file_put_contents($loghtml, '');
        file_put_contents($loghtml, $data);

    }

    public function logInfo($data){
        $logfile = 'customapp.log';

        Mage::log($data, null, $logfile, true);
    }
    public function checkAction(){

        //Check incoming data
        if($this->getRequest()->getPost()){
            $time = $this->getRequest()->getPost('time');
            $discount = $this->getRequest()->getPost('discount');
            $disable = $this->getRequest()->getPost('disable');
            $this->logInfo('Data sent');
            $this->logInfo($time);
            $this->logInfo($discount);
            $this->logInfo($disable);
        }else{
            $this->logInfo('Data not sent');
            exit;
        }

        $this->applyDiscountAction($time, $discount, $disable);

        $result = ['error' => 0,'message' => 'allgood'];
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));


    }

    /**
     * Inactive Products
     * Products with filtered attributes:
     *  - NOT present in orders before defined date
     *  - Have special price exceeding $discount
     *  - Have type (simple, configurable, downloadable)
     * Since current orders are not very precise, current date will be
     * latest date available in orders
     *
     * @param $time
     * @param $discount
     * @param $disable
     */
    public function applyDiscountAction($time, $discount, $disable){

        //Defining variables
        $recent_date='2014-4-30 03:36:47'; //most recent order date in DB
        $orderedProductsIds = [];
        $logString = '';

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
        
        $this->logInfo('Model queried');


        //Handling Products per order
        if($orders != null){
            foreach ($orders as $order){
                //Get Order Items
                $items = $order->getAllVisibleItems();


                //Get all products IDs
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
                //which should not be discounted
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['nin' => $orderedProductsIds]);

                $this->logInfo('Total products to be discounted: '.$products->getSize());

                //$logString .= '<h2>Analysis</h2><br /><br />';

                //Handling products
                foreach ($products as $product){

                    //Data filtration:
                    //Filter out gifts and coupons
                    if($product->getTypeId() != null){

                        //Filter out products with lower special price
                        $price = $product->getData('price');
                        $special_price = $price - (($discount/100) * $price);

                        if($special_price < $product->getData('special_price')){
                            //$logString .= 'Order ID: '.$order->getEntityID().'';
                            //$logString .= '<br /><br />';
                            //$logString .= 'Product Type: '. $product->getTypeId();
                            //$logString .= '<br />';
                            //$logString .= 'Product SKU: '. $product->getData('sku');
                            //$logString .= '<br />';
                            //$logString .= 'Product Price: '. $product->getData('price');
                            //$logString .= '<br />';
                            //$logString .= 'Product Special: '. $product->getData('special_price');
                            //$logString .= '<br />=========================';
                            //$logString .= '<br /><br />';

                            //Applying Discount
                            //$logString .= 'Applying Discount......<br />';
                            $product->setData('special_price', $special_price);
                            $product->save();
                            //$logString .= 'Product new Special Price: '.$product->getData('special_price').'<br />';
                        }


                        //$logString .= '<br /><br />';


                    }
                }
            }
        }
        //$this->logToHtml($logString);
    }
}