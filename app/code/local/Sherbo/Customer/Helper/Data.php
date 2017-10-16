<?php

class Sherbo_Customer_Helper_Data extends Mage_Customer_Helper_Data {

      /**
     * Retrieve current customer name
     *
     * @return string
     */
     public function getCustomerName()
     {
         return $this->getCustomer()->getName();
     }
 
}