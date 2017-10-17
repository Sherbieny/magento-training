<?php

require_once 'app/Mage.php';

Mage::app('admin');

$product = Mage::getModel("demo/product");
$product->sayHello();

$helper = Mage::helper("demo/customer");
$helper->sayHi();

$helper2 = Mage::helper("demo");
$helper2->sayHi();

echo "<br><br>";

$category = Mage::getModel("catalog/category")->load(4);

var_dump($category->getChildren());

echo "<br><br><p>---------------------------------------------------</p>";

$customer = Mage::helper("customer");
var_dump($customer->getCustomerName());


echo "<br><br><p>---------------------------------------------------</p>";

$products = Mage::getModel('catalog/product')->getCollection()
        ->addAttributeToSelect([
            'name',
            'price'
        ])
        ->addFieldToFilter('price', ["gt" => 700]);

foreach($products as $product){
    var_dump($product->getName());
    echo "<br />";
    
}






