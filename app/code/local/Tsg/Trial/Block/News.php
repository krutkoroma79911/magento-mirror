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

    public function newsImage($img)
    {
        $out = '<img src = "' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS .
            $img . '" width="120" height="120" class="news-img"/>';
        return $out;
    }

    public function newsContent($content, $id)
    {
        $link = 'newsview/view/' . $id;
        $content = substr($content, 0, 40) . "..." . '<a href=' . $link . '>Read More</a>';
        return $content;
    }


}