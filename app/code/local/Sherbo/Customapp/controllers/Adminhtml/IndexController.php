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
    public function checkAction(){
//        $result = 1;
//        Mage::app()->getResponse()->setBody($result);
        $data = $this->getRequest()->getParams();

        $result = ['error' => 0,
            'message' => 'allgood'];

        Mage::log($data);

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));


    }

//    public function getDiscountCandidatesAction(){
//        $model = Mage::getModel('catalog/product')
//            ->getCollection();
//    }
}