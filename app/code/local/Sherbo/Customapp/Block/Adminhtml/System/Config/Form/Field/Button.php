<?php
/**
 * Created by PhpStorm.
 * User: sherbieny
 * Date: 10/17/17
 * Time: 8:25 PM
 */

class Sherbo_Customapp_Block_Adminhtml_System_Config_Form_Field_Button extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        $url = $this->getUrl('www.google.com');

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel('Generate Prices')
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }
}