<?php

class Sherbo_Catalog_Model_Category extends Mage_Catalog_Model_Category {

    /**
     * Retrieve children ids comma separated
     *
     * @return string
     */
     public function getChildren()
     {
         return $this->getResource()->getChildren($this, false);
     }
}