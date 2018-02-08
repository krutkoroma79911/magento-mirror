<?php

class Tsg_Review_Model_Observer
{
    public function customerLogin()
    {
        Mage::getModel('core/cookie')->set('loggin', 'yes', 86400, '/', '', false, false);
    }

    public function customerLogout()
    {
        Mage::getModel('core/cookie')->set('loggin', 'no', 86400, '/', '', false, false);
    }
}