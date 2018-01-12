<?php

class Tsg_Exports_Block_Adminhtml_Exports_Render_Categories
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if (!empty($value)) {
            $categoryCollection = Mage::getModel('catalog/category')->getCollection();
            $categoryCollection->addAttributeToSelect('name');
            $categoryCollection->addFieldToFilter('entity_id', array('in' => explode(',', $value)));
            $out = '';
            foreach($categoryCollection as $category) {
                $out .= $category->getName() . ', ';
            }
            $out = rtrim($out,', ');
            return $out;
        }
    }
}