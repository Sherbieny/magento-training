<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:23 PM
 */

class Sherbo_Customapp_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    public function indexAction(){
        $logString .= 'admin setup';
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

        $this->getDiscountCandidatesAction($time, $discount, $disable);

        $result = ['error' => 0,'message' => 'allgood'];
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));


    }

    public function getDiscountCandidatesAction($time, $discount, $disable){
        //Defining variables
        $to_date='2014-5-30 03:36:47'; //most recent order date in DB
        $orderedProductsIds = [];
        $logString = '';

        //Latest active date minus given time
        $from_date= date("Y-m-d H:i:s", strtotime($to_date) - $time);
        //$this->logToHtml('New Time: '.$from_date);

        //Error Check
        if($disable != 1 and $disable != 2){
            $this->logInfo('Data Error');
            $this->logInfo($disable);
            exit;
        }

        //Check Decision [1 -> YES -> Cancel discount][2 -> NO -> Apply discount]
//        if($disable == 1){
//
//        }else{
//
//        }

        //Switching to Admin side to enable product manipulation
        //Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $this->logInfo('Processing');
        $this->logInfo($time);
        $this->logInfo($discount);
        $this->logInfo($disable);
        //Getting Orders
        $orders = Mage::getModel('sales/order')
            ->getCollection()
            ->addAttributeToFilter('created_at',
                ['from' => $from_date, 'to' => $to_date]);
        
        $logString .= '<h2>Analysis</h2><br /><br />';

        $this->logInfo('Model queried');
        $this->logToHtml($orders);

        //Handling Products per order
        if($orders != null){
            foreach ($orders as $order){
                //Get Order Items
                $items = $order->getAllVisibleItems();

                $this->logInfo('Orders found');
                //Getting all products IDs
                foreach ($items as $item){
                    $orderedProductsIds[] = $item->getProductID();
                }
                $this->logInfo($orderedProductsIds);

                //Getting all products excluding those above
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('entity_id', ['nin' => $orderedProductsIds]);

                //Handling products
                foreach ($products as $item){
                    $product = Mage::getModel('catalog/product')
                        ->load($item->getId());


                    //Data filtration:
                    //Filter out gifts and coupons && special prices
                    if($product->getTypeId() != null
                        && $product->getData('special_price') < 1){

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
                        $price = $product->getData('price');
                        $discount = $price - (($discount/100) * $price);

                        $logString .= 'Applying Discount......<br />';
                        $product->setData('special_price', $discount);
                        // $product->save();
                        $logString .= 'Product new Special Price: '.$product->getData('special_price').'<br />';

                        $logString .= '<br /><br />';

                        //$this->logToHtml($logString);
                    }

                }
            }
        }
    }
}