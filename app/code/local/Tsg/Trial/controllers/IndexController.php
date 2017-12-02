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
        $this->loadLayout();
        $this->renderLayout();
    }

    public function advertisingAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock(
            'Tsg_Trial_Block_Advertising',
            'advertising',
            array('template' => 'trial/advertising.phtml')
        );
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }
}