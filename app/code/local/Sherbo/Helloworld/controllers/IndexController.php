<?php

    class Sherbo_Helloworld_IndexController extends  Mage_Core_Controller_Front_Action {

        public function indexAction(){
            //echo 'Hello Indexxxxx';
            $this->loadLayout();
            $this->renderLayout();
        }

        public function helloAction(){
            $this->loadLayout();
            $this->renderLayout();
        }

    }