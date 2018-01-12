<?php

class Tsg_Exports_Block_Adminhtml_Exports_Render_Attribute
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $output = '';
        $column = $this->getColumn();
        $value = $row->getData($column->getIndex());
        if (!empty($value)) {
            $values = explode(',', $value);
            $attributeModel = Mage::getModel('eav/config');
            $sharesAttribute = $attributeModel->getAttribute('catalog_product', $column->getId());
            if ($sharesAttribute->usesSource()) {
                foreach ($values as $value) {
                    $output .= $sharesAttribute->getSource()->getOptionText($value) . ', ';
                }
                $output = trim($output, ', ');
            }

            return $output;
        }
    }
}