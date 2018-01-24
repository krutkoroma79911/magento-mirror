<?php

class Tsg_Productalert_Model_Observer
{

    protected $productAttributes = array('name', 'price', 'url_key');

    public function sendNotificationsEmail()
    {
        $this->priceProcess();
        $this->stockProcess();
    }

    /**
     * @param $params
     * @param string $case
     * @return bool
     */
    public function send($params, $case = 'price')
    {
        $template = 'tsg_productalert_tsg_productgroup_tsg_email_price_template';
        if ($case === 'stock') {
            $template = 'tsg_productalert_tsg_productgroup_tsg_email_stock_template';
        }


        $senderConfig = Mage::getStoreConfig('tsg_productalert/tsg_productgroup/tsg_email_identity',
            Mage::app()->getStore());
        $senderName = Mage::getStoreConfig('trans_email/ident_' . $senderConfig . '/name');
        $senderMail = Mage::getStoreConfig('trans_email/ident_' . $senderConfig . '/email');
        $result = true;
        /** @var Tsg_ProductAlert_Model_Email $model */
        $model = Mage::getModel('tsg_productalert/email');
        try {
            $model->sendEmail(
                $template,
                array('name' => $senderName, 'email' => $senderMail),
                $params['customer_email'],
                'Guest',
                'Price Alert Subscription',
                $params
            );
        } catch (Exception $e) {
            $result = false;
        }
        return $result;
    }

    public function priceProcess()
    {
        $websiteUrls = $this->getWebsitesUrls();
        /** @var Tsg_ProductAlert_Model_PriceSubscriptions $stockSubModel */
        $priceSubModel = Mage::getModel('tsg_productalert/pricesubscriptions');
        /** @var Tsg_ProductAlert_Model_Resource_PriceSubscriptions_Collection $collection */
        $collection = $priceSubModel->getCollection();
        $collection->getSelect()->joinLeft(
            array('cust' => 'catalog_product_entity'),
            'cust.entity_id = main_table.product_id');
        $collection->addProductAttributes($this->productAttributes);
        foreach ($collection as $subscription) {
            $params = array(
                'product_price' => (int)$subscription->getProductPrice(),
                'price' => (int)$subscription->getPrice(),
                'product_name' => $subscription->getProductName(),
                'product_url' => $websiteUrls[$subscription->getWebsiteId()] . $subscription->getProductUrlKey() . '.html',
                'customer_email' => $subscription->getCustomerEmail(),
                'currency' => Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(),);
            $result = $this->send($params);
            if ($result) {
                $subscription->delete();
            }
        }

    }

    public function stockProcess()
    {
        $websiteUrls = $this->getWebsitesUrls();
        $this->productAttributes = array('name', 'url_key');
        /** @var Tsg_ProductAlert_Model_StockSubscriptions $stockSubModel */
        $stockSubModel = Mage::getModel('tsg_productalert/stocksubscriptions');
        /** @var Tsg_ProductAlert_Model_Resource_StockSubscriptions_Collection $collection */
        $collection = $stockSubModel->getCollection();
        $collection->getSelect()->joinLeft(
            array('cust' => 'catalog_product_entity'),
            'cust.entity_id = main_table.product_id')->joinLeft(
            array('stock' => 'cataloginventory_stock_item'),
            'stock.product_id = main_table.product_id AND stock.is_in_stock != main_table.stock', 'is_in_stock');
        $collection->addProductAttributes($this->productAttributes);
        foreach ($collection as $subscription) {
            $params = array(
                'product_name' => $subscription->getProductName(),
                'customer_email' => $subscription->getCustomerEmail(),
                'product_url' => $websiteUrls[$subscription->getWebsiteId()] . $subscription->getProductUrlKey() . '.html',
                'currency' => Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(),
            );
            $result = $this->send($params, 'stock');

            if ($result) {
                $subscription->delete();
            }

        }
    }

    /**
     * @return array
     */
    public function getWebsitesUrls()
    {
        $websiteUrls = array();
        $websites = Mage::getModel('core/website')->getCollection();
        foreach ($websites as $website) {
            $websiteUrls[$website->getId()] = Mage::getConfig()->getNode('web/unsecure/base_url', 'website',
                $website->getCode());
        }
        return $websiteUrls;
    }
}