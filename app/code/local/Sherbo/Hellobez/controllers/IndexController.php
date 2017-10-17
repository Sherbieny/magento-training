<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/16/17
 * Time: 1:00 PM
 */

class Sherbo_Hellobez_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
//        $this->loadLayout();
//        $this->renderLayout();

        $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_read');

        $results = $connection->query('SELECT * FROM core_store')
            ->fetchAll();
        Zend_Debug::dump($results);

    }

    public function helloAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function flatAction(){
        //Working directly with DB queries
//        $resource = Mage::getSingleton('core/resource');
//        $connection = $resource->getConnection('core_read');
//
//        $results = $connection->query('SELECT * FROM review_detail')
//            ->fetchAll();
//        Zend_Debug::dump($results);


        //Working with Magento collections
        $reviews = Mage::getModel('review/review')
            ->getCollection();
        foreach ($reviews as $review){
            Zend_Debug::dump($review->debug());
            echo $review->getReviewUrl().'<br />';
        }

    }

    public function subscriptionAction(){
        $subscription = Mage::getModel('hellobez/subscription');

        $subscription->setFirstName('Adham');
        $subscription->setLastName('Sabry');
        $subscription->setEmail('adham.sabry@zobry.com');
        $subscription->setMessage('Ragol al Mosta7eel');

        $subscription->save();

        echo 'success';

    }

    public function collectionAction(){

        $productCollection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('image')
            ->addAttributeToFilter('name', ['like' => '%shirt%'])
            ->setPageSize(10,1);

        $productCollection->setDataToAll('price', 20);

        //$productCollection->save();

        foreach ($productCollection as $product){
            Zend_Debug::dump($product->debug());
        }
//        $productCollection->load();
//
//        echo $productCollection->getSelect()->__toString();

    }
}