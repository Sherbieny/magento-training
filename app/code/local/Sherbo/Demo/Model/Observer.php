<?php

class Sherbo_Demo_Model_Observer {
    public function logCustomer($observer){
        $customer = $observer->getCustomer();
        Mage::log($customer->getName() . "Has logged in!", null, "customer.log");
    }
}