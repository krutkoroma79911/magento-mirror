<?php

class Tsg_Trial_IndexController
    extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo "Hello Magento";
    }

    public function advertisingAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newsListAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newsViewAction()
    {
        $this->loadLayout();
        $this->renderLayout();

    }
}