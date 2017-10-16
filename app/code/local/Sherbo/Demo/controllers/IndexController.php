<?php

class Sherbo_Demo_IndexController extends Mage_Core_Controller_Front_Action {
    
    public function sayHelloAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function indexAction(){
        echo 'Default Ya wlaad!';
    }
}