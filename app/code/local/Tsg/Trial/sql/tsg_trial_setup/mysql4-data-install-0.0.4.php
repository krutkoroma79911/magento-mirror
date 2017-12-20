<?php
$installer = $this;
$installer->startSetup();

// Category setup
$allStores = Mage::app()->getStores();
foreach ($allStores as $_eachStoreId => $val) {
    $_storeId = Mage::app()->getStore($_eachStoreId)->getId();
    $rootCatId = Mage::app()->getStore($_storeId)->getRootCategoryId();
    $parentCategory = Mage::getModel('catalog/category')->load($rootCatId);
    $childCategory = Mage::getModel('catalog/category')->getCollection()
        ->addAttributeToFilter('is_active', true)
        ->addIdFilter($parentCategory->getChildren())
        ->addAttributeToFilter('name', 'Product News')
        ->getFirstItem();
    if ($childCategory->getId() == null) {
        $category = Mage::getModel('catalog/category');
        $category->setName('Product News');
        $category->setUrlKey('product-news');
        $category->setIsActive(1);
        $category->setDisplayMode('PRODUCTS');
        $category->setIsAnchor(0);
        $category->setPath($parentCategory->getPath());
        $category->save();
        unset($category);
    }
}

// News setup
$news = array();
for ($newsCount = 1; $newsCount <= 5; $newsCount++) {
    $news[] = array(
        'title' => 'This is custom Title ' . $newsCount,
        'content' => 'Just the ' . $newsCount . ' news that created by install data script!!!',
        'image' => '',
        'priority' => $newsCount,
        'created_at' => date('Y-m-d H:i:s')
    );
}

$model = Mage::getModel('tsg_trial/news');
foreach ($news as $item) {
    $model->setData($item)->save();
}

//Products setup
$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', 'Product News')
    ->getFirstItem();
$catId = $category->getEntityId();
$newsIds = Mage::getModel('tsg_trial/news')->getCollection()
    ->addFieldToSelect('id');
foreach ($newsIds as $id) {
    $ids[] = $id->getId();
}
$ids = array_flip($ids);
$stockData = array(
    'qty' => 10,
    'is_in_stock' => 1,
    'manage_stock' => 1,
    'use_config_manage_stock' => 0,
);
$i = 1;
while ($i != 5) {
    $data = array(
        'sku' => "product $i",
        'name' => "Product $i",
        'description' => "Desc for product $i",
        'short_description' => "Short Desc for product $i",
        'price' => 100,
        'type_id' => 'simple',
        'attribute_set_id' => 4,
        'category_ids' => $catId,
        'weight' => 1.0,
        'tax_class_id' => 2,
        'visibility' => 4,
        'status' => 1,
        'website_ids' => array(Mage::app()->getStore(true)->getWebsite()->getId()),
        'stock_data' => $stockData
    );
    if ($i != 4) {
        $newsIds = array_rand($ids, rand(1, count($ids)));
        if (is_array($newsIds)) {
            $mainNewsId = array_rand(array_flip($newsIds), 1);
        } else {
            $mainNewsId = $newsIds;
        }
        $newsArray = array(
            'news' => $newsIds,
            'main_news' => $mainNewsId,
        );
        $data = array_merge($data, $newsArray);
    }
    $product = Mage::getModel('catalog/product');
    $product->addData($data);
    $product->save();
    $i++;
}