<?php

class Tsg_Trial_Block_News
    extends Mage_Core_Block_Template
{

    /**
     * @var Tsg_Trial_Model_News|null
     */
    protected $news;

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
        $collection = Mage::getModel('tsg_trial/news')->getCollection();
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'news.pager');
        $pager->setAvailableOrders(array('created_at'=> 'Created Time','id'=>'ID'));
        $pager->setAvailableLimit(array(5 => 5, 10 => 10, 20 => 20, 'all' => 'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    public function newsImage($img)
    {
        $out = '<img src = "' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .
            $img . '" width="120" height="120" class="news-img"/>';
        return $out;
    }

    public function newsContent($content, $id)
    {
        $link = Mage::getUrl() . 'trial/index/newsview/view/' . $id;
        $content = substr($content, 0, 40) . "..." . '<a href=' . $link . '>Read More</a>';
        return $content;
    }

    public function getAvailableOrders()
    {
        return array(
            'created_at' => $this->__('Date'),
            'content' => $this->__('Content'));
    }

    public function getProductNews($productId)
    {
        $product = Mage::getModel('catalog/product')->load($productId);
        return $product->getNews();
    }

    public function loadProductNews($ids)
    {

        $newsIds = explode(',', $ids);
        $news = Mage::getModel('tsg_trial/news')->getCollection()
            ->addIdFilter($newsIds);
        return $news;
        
    }
}