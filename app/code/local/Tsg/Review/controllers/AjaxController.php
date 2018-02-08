<?php

class Tsg_Review_AjaxController
    extends Mage_Core_Controller_Front_Action
{

    /**
     *  Function check if there is any viewed products in DB and returning products or false
     */
    public function getProductsAction()
    {
        if ($this->getRequest()->getPost('ajax')) {
            /** @var Tsg_Review_Block_Product_Viewed $block */
            $block = $this->getLayout()->createBlock('tsg_review/product_viewed');
            $collection = $block->getItemsCollection();
            if ($collection->getSize() > 0) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $products = $this->getProductsData($collection);
                $this->getResponse()->setBody(json_encode($products));
            } else {
                $this->getResponse()->setBody(null);
            }
        } else {
            $this->norouteAction();
        }
    }

    /**
     *
     * @param $collection
     * @return array
     */
    public function getProductsData($collection)
    {
        $products = [];
        foreach ($collection as $product) {
            $products[] = [
                'id' => $product->getId(),
                'url' => $product->getUrlModel()->getUrl($product),
                'img' => Mage::helper('catalog/image')->init($product, 'thumbnail')->resize(50,
                    50)->setWatermarkSize('30x10')->__toString(),
                'name' => $product->getName(),
            ];
        }
        return $products;
    }


    public function deleteCookieAction()
    {
        $cookieName = $this->getRequest()->getPost('cookie');
        if ($cookieName === 'loggin') {
            /** @var Mage_Core_Model_Cookie $model */
            $model = Mage::getModel('core/cookie');
            $model->set($cookieName, 'yes', -1, '/', '', false, false);
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody('test');
        } else {
            $this->norouteAction();
        }

    }


}