<?php
/**
 * Created by PhpStorm.
 * User: Krut Roman
 * Date: 12/1/2017
 * Time: 3:50 PM
 */

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
}