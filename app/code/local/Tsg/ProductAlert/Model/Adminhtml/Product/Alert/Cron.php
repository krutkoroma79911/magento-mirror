<?php

class Tsg_ProductAlert_Model_Adminhtml_Product_Alert_Cron
    extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH = 'crontab/jobs/tsg_productalert_send/schedule/cron_expr';
    const CRON_MODEL_PATH   = 'crontab/jobs/tsg_productalert_send/run/model';

    protected function _afterSave()
    {
        $time = $this->getData('groups/tsg_productcrongroup/fields/time/value');
        $frequency = $this->getValue();

        $frequencyWeekly = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        $cronExprArray = array(
            (int)$time[1],                                   # Minute
            (int)$time[0],                                   # Hour
            ($frequency == $frequencyMonthly) ? '1' : '*',      # Day of the Month
            '*',                                                # Month of the Year
            ($frequency == $frequencyWeekly) ? '1' : '*',       # Day of the Week
        );
        $cronExprString = join(' ', $cronExprArray);

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();
            Mage::getModel('core/config_data')
                ->load(self::CRON_MODEL_PATH, 'path')
                ->setValue((string) Mage::getConfig()->getNode(self::CRON_MODEL_PATH))
                ->setPath(self::CRON_MODEL_PATH)
                ->save();
        } catch (Exception $e) {
            throw new Exception(Mage::helper('cron')->__('Unable to save the cron expression.'));

        }
    }
}