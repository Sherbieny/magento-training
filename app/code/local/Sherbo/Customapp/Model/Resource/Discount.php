<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:17 PM
 */

class Sherbo_Customapp_Model_Resource_Discount extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct()
    {
        $this->_init('customapp/discount', 'discount_id');
    }
}