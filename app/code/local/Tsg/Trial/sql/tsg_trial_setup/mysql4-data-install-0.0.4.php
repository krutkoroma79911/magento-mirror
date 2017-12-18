<?php
$installer = $this;
$installer->startSetup();
/**
 * Category setup
 */
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
        $category = new Mage_Catalog_Model_Category();
        $category->setName('Product News');
        $category->setUrlKey('product-news');
        $category->setIsActive(1);
        $category->setDisplayMode('PRODUCTS');
        $category->setIsAnchor(0);

        $parentCategory = Mage::getModel('catalog/category')->load($rootCatId);
        $category->setPath($parentCategory->getPath());

        $category->save();
        unset($category);
    }
}


/**
 * News setup
 */

$news = array(
    array(
        'title' => 'This is custom Title 1',
        'content' => 'Just the 1 news that created by install data script!!!',
        'image' => '',
        'priority' => '5',
        'created_at' => date('Y-m-d H:i:s')
    ),
    array(
        'title' => 'This is custom Title 2',
        'content' => 'Just the 2 news that created by install data script!!!',
        'image' => '',
        'priority' => '4',
        'created_at' => date('Y-m-d H:i:s')
    ),
    array(
        'title' => 'This is custom Title 3',
        'content' => 'Just the 3 news that created by install data script!!!',
        'image' => '',
        'priority' => '3',
        'created_at' => date('Y-m-d H:i:s')
    ),
    array(
        'title' => 'This is custom Title 4',
        'content' => 'Just the 4 news that created by install data script!!!',
        'image' => '',
        'priority' => '0',
        'created_at' => date('Y-m-d H:i:s')
    ),
    array(
        'title' => 'This is custom Title 5',
        'content' => 'Just the 5 news that created by install data script!!!',
        'image' => '',
        'priority' => '0',
        'created_at' => date('Y-m-d H:i:s')
    ),
);
$model = Mage::getModel('tsg_trial/news');
foreach ($news as $item) {
    $model->setData($item)->save();
}

/**
 * Products setup
 */
$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', 'Product News')
    ->getFirstItem();
$catId = $category->getEntityId();
$newsIds = Mage::getModel('tsg_trial/news')->getCollection()
    ->addFieldToSelect('id');
foreach ($newsIds as $id) {
    $ids[] = $id->getId();
}
$ids = array_flip($ids);
$newsIds = array_rand($ids, rand(1, count($ids)));

$i = 1;
while ($i != 4) {
    $product = Mage::getModel('catalog/product');
    $newsIds = array_rand($ids, rand(1, count($ids)));
    $product->setSku("product $i");
    $product->setName("Product $i");
    $product->setDescription("Desc for product $i");
    $product->setShortDescription("Product $i short");
    $product->setPrice(100);
    $product->setTypeId('simple');
    $product->setAttributeSetId(4);
    $product->setCategoryIds($catId);
    $product->setWeight(1.0);
    $product->setTaxClassId(2);
    $product->setVisibility(4);
    $product->setStatus(1);
    $product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));
    $product->setNews($newsIds);
    $product->setMainNews(array_rand($ids), 1);
    $stockData = $product->getStockData();
    $stockData['qty'] = 10;
    $stockData['is_in_stock'] = 1;
    $stockData['manage_stock'] = 1;
    $stockData['use_config_manage_stock'] = 0;
    $product->setStockData($stockData);
    $product->save();
    $i++;
}
$product = Mage::getModel('catalog/product');
$newsIds = array_rand($ids, rand(1, count($ids)));
$product->setSku("product $i");
$product->setName("Product $i");
$product->setDescription("Desc for product $i");
$product->setShortDescription("Product $i short");
$product->setPrice(100);
$product->setTypeId('simple');
$product->setAttributeSetId(4);
$product->setCategoryIds($catId);
$product->setWeight(1.0);
$product->setTaxClassId(2);
$product->setVisibility(4);
$product->setStatus(1);
$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));
$stockData = $product->getStockData();
$stockData['qty'] = 10;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);
$product->save();