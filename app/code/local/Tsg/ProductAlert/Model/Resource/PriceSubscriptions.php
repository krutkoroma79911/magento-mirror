<?php

class Tsg_ProductAlert_Model_Resource_PriceSubscriptions
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_productalert/price', 'price_alert_id');
    }

}
