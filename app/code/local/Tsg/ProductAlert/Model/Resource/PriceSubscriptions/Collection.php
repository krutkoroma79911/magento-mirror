<?php

class Tsg_ProductAlert_Model_Resource_PriceSubscriptions_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_productalert/pricesubscriptions');
    }

    /**
     * @param $ids
     * @return $this
     */
    public function addEmailFilter($emails)
    {
        if (is_array($emails)) {
            $this->addFieldToFilter('export_id', array('in' => $emails));
        } elseif (is_numeric($emails) || is_string($emails)) {
            $this->addFieldToFilter('export_id', $emails);
        }
        return $this;
    }

    /**
     * @param $productAttributes
     * @return $this
     */
    public function addProductAttributes($productAttributes)
    {
        foreach ($productAttributes as $attributeCode) {
            $alias = $attributeCode . '_table';
            $attribute = Mage::getSingleton('eav/config')
                ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode);
            $condition = "main_table.product_id = $alias.entity_id AND $alias.attribute_id={$attribute->getId()}";
            if ($attributeCode === 'price') {
                $condition .= " AND main_table.price != $alias.value";
            }
            /** Adding eav attribute value */
            $this->getSelect()->join(
                array($alias => $attribute->getBackendTable()), $condition
                ,
                array('product_' . $attributeCode => 'value')
            );
            $this->_map['fields'][$attributeCode] = 'value';
        }
        return $this;
    }
}

