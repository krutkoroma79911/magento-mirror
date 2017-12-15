<?php

class Tsg_Trial_Block_News
    extends Mage_Core_Block_Template
{

    /**
     * @var Tsg_Trial_Model_News|null
     */
    protected $news;

    /**
     * @var Tsg_Trial_Model_News|array
     * default params to sorting news collection
     */
    protected $params = ['order' => 'id', 'dir' => 'DESC'];
    /**
     * @var Tsg_Trial_Model_News|null
     */
    protected $newsIds;

    /**
     * Returns all the news
     *
     * @return null|object|Tsg_Trial_Model_News
     */
    public function getNews()
    {
        $model = Mage::getModel('tsg_trial/news');
        $this->news = $model->getCollection();
        return $this->news;
    }

    public function __construct()
    {
        parent::__construct();
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @param $img
     * @return string
     */
    public function newsImage($img)
    {
        $out = '<img src = "' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .
            $img . '" width="120" height="120" class="news-img"/>';
        return $out;
    }

    /**
     * @param $content
     * @param $id
     * @return string
     */
    public function newsContent($content, $id)
    {
        $link = Mage::getUrl() . 'trial/index/newsview/view/' . $id;
        $content = substr($content, 0, 40) . "..." . '<a href=' . $link . '>Read More</a>';
        return $content;
    }

    /**
     * @param $productId
     * @return mixed
     */
    public function getProductNews($productId)
    {
        $product = Mage::getModel('catalog/product')->load($productId);
        return $product->getNews();
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $dir = Mage::app()->getRequest()->getParam('dir');
        $order = Mage::app()->getRequest()->getParam('order');
        if ($dir && $order) {
            $params['dir'] = $dir;
            $params['order'] = $order;
            $this->setParams($params);
        }
        return $this->params;
    }

    /**
     * @param $newsIds
     * @return $this
     */
    public function setProductNews($newsIds)
    {
        $this->newsIds = explode(',', $newsIds);
        return $this;
    }

    /**
     * @param $collection
     * @return $this
     */
    public function getPager($collection)
    {
        $pager = $this->getLayout()->createBlock('page/html_pager', 'news.pager');
        $pager->setAvailableLimit(array(5 => 5, 10 => 10, 20 => 20, 'all' => 'all'));
        $pager->setCollection($collection);
        $this->setChild('pager', $pager);
        $collection->load();
        return $this;
    }


    /**
     * @param $params |array
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }


    /**
     * @return Tsg_Trial_Model_Resource_News_Collection|Varien_Data_Collection
     */
    public function getCollection()
    {
        /** @var $collection Tsg_Trial_Model_Resource_News_Collection */
        $this->getParams();
        $collection = Mage::getModel('tsg_trial/news')->getCollection();
        $productId = Mage::app()->getRequest()->getParam('product');
        if ($productId != null) {
            $newsIds = $this->getProductNews($productId);
            if ($newsIds != null) {
                $this->setProductNews($newsIds);
                if (is_array($this->newsIds)) {
                    $collection->addIdFilter($this->newsIds);
                }
                $collection->setOrder($this->params['order'], $this->params['dir']);
                return $collection;
            } else {
                return new Varien_Data_Collection;
            }
        } else {
            $collection->setOrder($this->params['order'], $this->params['dir']);
            return $collection;
        }
    }
}