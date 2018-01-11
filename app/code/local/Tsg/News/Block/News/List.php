<?php

class Tsg_News_Block_News_List
    extends Mage_Core_Block_Template
{

    /**
     * Tsg_News_Block_News_List constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $collection = $this->getProductNews();
        $this->setCollection($collection);
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var Mage_Page_Block_Html $pager */
        $pager = $this->getLayout()->createBlock('page/html_pager', 'list.pager');
        $pager->setAvailableLimit(array(5 => 5, 10 => 10, 20 => 20, 'all' => 'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    /**
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @param $newsContent
     * @param $newsId
     * @return string
     */
    public function renderNewsContent($newsContent, $newsId)
    {
        $link = $this->getUrl('*/*/read/news/' . $newsId);
        $content = substr($newsContent, 0, 40) . " <a href=" . $link . ">Read the News </a>";
        return $content;
    }

    /**
     * @param $productId
     * @return Tsg_News_Model_Resource_News_Collection
     */
    public function getProductNews()
    {
        $productId = $this->getRequest()->getParam('product');
        if ($productId === null) {
            /** @var Tsg_News_Model_Resource_News $collection */
            $collection = Mage::getModel('tsg_news/news')->getCollection();
        } else {
            $product = Mage::getModel('catalog/product')->load($productId);
            $newsIds = explode(',', $product->getNewslist());
            /** @var Tsg_News_Model_Resource_News_Collection $collection */
            $collection = Mage::getModel('tsg_news/news')->getCollection()->addIdsFilter($newsIds);
            //return $collection;
        }
        return $this->sortNewsByOrder($collection);
    }

    /**
     * This function is adding order by params to news collection
     *
     * @param $collection
     * @return Tsg_News_Model_Resource_News_Collection
     */
    public function sortNewsByOrder($collection)
    {
        $order = array(
            'dir' => 'asc',
            'order' => 'created_at',
        );
        $params = $this->getRequest()->getParams();
        if (isset ($params['dir'], $params['order'])) {
            $paramsToCheck = array(
                'dir' => $params['dir'],
                'order' => $params['order'],
            );
            $result = $this->checkAllowedParams($paramsToCheck);
            if ($result) {
                $order = $paramsToCheck;
            }
        }
        /** @var Tsg_News_Model_Resource_News_Collection $collection */
        $collection->setOrder($order['order'], $order['dir']);
        return $collection;
    }

    /**
     * @param $paramsToCheck
     * @return bool
     */
    public function checkAllowedParams($paramsToCheck)
    {
        $result = false;
        $allowedOrder = array(
            '0' => 'news_priority',
            '1' => 'created_at',
        );
        $allowedDir = array(
            '0' => 'asc',
            '1' => 'desc',
        );

        if (in_array($paramsToCheck['dir'], $allowedDir) && in_array($paramsToCheck['order'], $allowedOrder)) {
            $result = true;
        }

        return $result;
    }

}