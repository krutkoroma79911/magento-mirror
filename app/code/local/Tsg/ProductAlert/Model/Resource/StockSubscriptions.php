<?php

class Tsg_ProductAlert_Model_Resource_StockSubscriptions
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('tsg_productalert/stock','stock_alert_id');
    }
}