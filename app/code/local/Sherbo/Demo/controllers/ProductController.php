<?php

require_once(Mage::getModuleDir('controllers', 'Mage_Catalog').DS.'ProductController.php');
class Sherbo_Demo_ProductController extends Mage_Catalog_ProductController { 
 
    public function viewAction(){
        echo 'Hi';
    }

}