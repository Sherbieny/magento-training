<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/16/17
 * Time: 3:34 PM
 */

class Sherbo_Hellobez_Model_Catalog_Product extends Mage_Catalog_Model_Product {

    public function getName(){
        return 'Sherbo ' .$this->_getData('name');
    }
}