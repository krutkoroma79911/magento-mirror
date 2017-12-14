<?php

class Tsg_Trial_Model_Observer
{

    public function mainNews($observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productNewsBeforeSave = explode(',', Mage::getResourceModel('catalog/product')
            ->getAttributeRawValue($product->getId(), 'news', '0'));
        $newsIds = $product->getNews();
        $mainNews = $product->getMainNews();
        if ($newsIds['0'] != 'no' && $mainNews == 'no') {
            $theNewestNews = Mage::getModel('tsg_trial/news')->getCollection()
                ->setOrder('created_at', 'DESC')
                ->getFirstItem();
            $product->setMainNews($theNewestNews->getId());
        } elseif ($productNewsBeforeSave !== $newsIds) {
            $topNewsId = $this->mostPriorityNews($newsIds);
            $product->setMainNews($topNewsId);
        }
    }

    public function mostPriorityNews($newsIds)
    {
        $news = Mage::getModel('tsg_trial/news')->getCollection()
            ->addIdFilter($newsIds);
        $rating = [];
        foreach ($news as $item) {
            $rating[$item->getId()] = ['rating' => strtotime($item->getCreatedAt())];
            if ($item->getPriority() != 0) {
                $ratingPoint = $item->getPriority() * 86400;
                $rating[$item->getId()]['rating'] += $ratingPoint;
            }
        }
        $topNewsId = array_search(max($rating), $rating);
        return $topNewsId;
    }

    public function mainColumnsExport()
    {
        $a = 1;
    }
}