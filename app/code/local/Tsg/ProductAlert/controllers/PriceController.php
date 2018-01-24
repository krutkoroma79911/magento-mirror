<?php

class Tsg_ProductAlert_PriceController
    extends Mage_Core_Controller_Front_Action
{

    protected function checkMailAction()
    {
        $emailAddress = $this->getRequest()->getPost('email');
        $productId = $this->getRequest()->getPost('productId');
        if ($emailAddress && $productId) {
            /** @var Tsg_ProductAlert_Model_PriceSubscriptions $emailAddressCheck */
            $priceSubModel = Mage::getModel('tsg_productalert/pricesubscriptions');
            /** @var Tsg_ProductAlert_Helper_Data $helper */
            $helper = Mage::helper('tsg_productalert');
            $result = $helper->checkIfMailExists($priceSubModel, $emailAddress, $productId);
            $this->getResponse()->setBody($result);
        } else {
            $this->norouteAction();
        }
    }

    protected function savePriceSubscriptionAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $session = Mage::getSingleton('core/session');
            $model = Mage::getModel('tsg_productalert/pricesubscriptions');
            $model->setData($data);
            try {
                $model->save();
            } catch (Exception $e) {
                $session->addError('Error while subscribing, try again please');
                return;
            }
            $session->addSuccess('You successfully subscribed on this product price');
        } else {
            $this->norouteAction();
        }
    }
}