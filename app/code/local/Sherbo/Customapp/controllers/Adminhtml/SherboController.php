<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:23 PM
 */

class Sherbo_Adminhtml_SherboController extends Mage_Adminhtml_Controller_Action {

    public function checkAction(){
        $result = 1;
        Mage::app()->getResponse()->setBody($result);
    }
}