<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:13 PM
 */

class Sherbo_Customapp_Model_Discount extends Mage_Core_Model_Abstract {

    protected function _construct(){
        parent::_construct();
        $this->_init('customapp/discount');
    }

    public function toOptionArray(){

        return [
            array('value'=>1, 'label'=>Mage::helper('customapp')->__('Yes')),
            array('value'=>2, 'label'=>Mage::helper('customapp')->__('No')),
        ];
    }
}