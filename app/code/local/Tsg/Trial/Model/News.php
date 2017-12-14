<?php

class Tsg_Trial_Model_News
    extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('tsg_trial/news');
    }

    public function getAllOptions()
    {
        $res[] = [
            'value' => 'no',
            'label' => 'There is no news'
        ];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = [
                'value' => $index,
                'label' => $value->getTitle()
            ];
        }
        return $res;
    }

    public function getAllOption()
    {
        $options = $this->getOptionArray();
        return $options;
    }

    public function getOptionArray()
    {
        return $this->getCollection();
    }
}