<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/16/17
 * Time: 7:50 PM
 */

class Sherbo_Hellobez_Model_Resource_Subscription_Collection extends
Mage_Core_Model_Resource_Db_Collection_Abstract{

    protected function _construct(){
        $this->_init('hellobez/subscription');
    }
}