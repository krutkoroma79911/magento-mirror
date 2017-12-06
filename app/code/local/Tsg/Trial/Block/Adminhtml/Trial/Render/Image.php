<?php
/**
 * Created by PhpStorm.
 * User: Krut Roman
 * Date: 12/1/2017
 * Time: 11:06 AM
 */

class Tsg_Trial_Block_Adminhtml_Trial_Render_Image
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if (!empty($value)) {
            $out = '<center><img src = "' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .
                $value . '" width="50" height="50"/></center>';
            return $out;
        } else {
            return "";
        }
    }
}