<?php

class Tsg_Trial_Block_View
    extends Mage_Core_Block_Template
{
    /**
     * @var Tsg_Trial_Model_News|null
     */
    protected $news;

    public function loadNewsById($id)
    {
        $this->news = $model = Mage::getModel('tsg_trial/news')->load($id);
        return $this->news;
    }

}