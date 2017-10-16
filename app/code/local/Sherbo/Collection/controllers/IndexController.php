<?php

class Sherbo_Collection_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction(){
        echo 'setup complete<br /><br />';
        echo 'starting...<br /><br />';
        

        $thing_1 = new Varien_Object();
        $thing_1->setName('Richard');
        $thing_1->setAge(24);

        $thing_2 = new Varien_Object();
        $thing_2->setName('Jane');
        $thing_2->setAge(12);

        $thing_3 = new Varien_Object();
        $thing_3->setName('Spot');
        $thing_3->setLastName('The Dog');
        $thing_3->setAge(7);

        var_dump($thing_1->getName());
        echo '<br /><br />';

        var_dump($thing_3->getData());
        echo '<br /><br />';

        echo 'Making Collections...';
        echo '<br /><br />';

        $collection_of_things = new Varien_Data_Collection();

        $collection_of_things
            ->addItem($thing_1)
            ->addItem($thing_2)
            ->addItem($thing_3);
        foreach ($collection_of_things as $thing) {
            var_dump($thing->getData());
            echo '<br /><br />';
        }        
        var_dump($collection_of_things->toXml());
        echo '<br /><br />';
        var_dump($collection_of_things->getColumnValues('name'));
        echo '<br /><br />';
        var_dump($collection_of_things->getItemsByColumnValue('name','Spot'));

    }
    /**
     * Function for testing stuff
     * 
     * @return ''
     */
    public function testAction(){
        $collection_of_products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addFieldToFilter('type_id', 'simple');

        echo 'Our Collection now has '. count($collection_of_products) .' items';
        var_dump($collection_of_products->getFirstItem()->getData());
        /*
        var_dump((string) $collection_of_products->getSelect());      
        */

        
        
         
    }
}