<?php

class Tsg_ProductAlert_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    /**
     * Checking if mail exists in db table
     *
     * @param $model
     * @param $email
     * @param $productId
     * @return bool
     */
    public function checkIfMailExists($model,$email,$productId) {
        $priceSubCollection = $model->getCollection()
            ->addFieldToSelect('customer_email')
            ->addFilter('customer_email', $email, 'eq')
            ->addFilter('product_id', $productId, 'eq');
        $email = $priceSubCollection->getFirstItem()->getCustomerEmail();
        if (!$email) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}