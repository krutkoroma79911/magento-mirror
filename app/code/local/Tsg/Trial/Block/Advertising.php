<?php

class Tsg_Trial_Block_Advertising
    extends Mage_Core_Block_Template
{
    /**
     * @var Mage_Catalog_Model_Product|null
     */
    private $product;

    /**
     * Returns current product
     *
     * @return Mage_Catalog_Model_Product|mixed|null
     */
    public function getProduct()
    {
        if (null === $this->product) {
            $this->product = Mage::registry('current_product');
        }

        return $this->product;
    }

    /**
     * @return string
     */
    public function getAdvertising()
    {
        return "Здесь могла бы быть ваша реклама";
    }

}