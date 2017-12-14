<?php

class Tsg_Trial_Model_Resource_News_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('tsg_trial/news');
    }

    public function addIdFilter($ids)
    {
        if (is_array($ids)) {
            $this->addFieldToFilter('id', array('in' => $ids));
        } elseif (is_numeric($ids) || is_string($ids)) {
            $this->addFieldToFilter('id', $ids);
        }
        return $this;
    }

}