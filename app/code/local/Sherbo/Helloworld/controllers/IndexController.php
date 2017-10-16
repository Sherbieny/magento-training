<?php

    class Sherbo_Helloworld_IndexController extends  Mage_Core_Controller_Front_Action {

        public function indexAction(){
            //echo 'Hello Indexxxxx';      
            $this->loadLayout();
            $this->renderLayout();
        }

        public function goodbyeAction(){
            //echo 'ma3a el salama ya boo7a';
            $this->loadLayout();
            $this->renderLayout();
        }

        public function paramsAction(){
            echo '<dl>';

            foreach($this->getRequest()->getParams() as $key=>$value){
                echo '<dt><strong>Param: </strong>'.$key.'</dt>';
                echo '<dl><strong>Value: </strong>'.$value.'</dl>';
            }

            echo '</dl>';
        }
    }