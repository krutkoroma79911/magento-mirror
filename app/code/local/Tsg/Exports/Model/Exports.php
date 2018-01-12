<?php

class Tsg_Exports_Model_Exports
    extends Mage_Core_Model_Abstract
{

    protected $_categoryInstance = null;

    protected $_attributesToSelect = array(
        '0' => 'price',
        '1' => 'image',
    );

    protected function _construct()
    {
        $this->_init('tsg_exports/exports');
    }

    /**
     * @param $export
     */
    public function generateExport($export)
    {
        $productCollection = array();
        if (!empty($export['categories'])) {
            /** @var  Mage_Catalog_Model_Resource_Product_Collection $productCollection */
            $productCollection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect($this->_attributesToSelect)
                ->joinField(
                    'category_id', 'catalog/category_product', 'category_id',
                    'product_id = entity_id', null, 'left'
                )->joinField('qty', 'cataloginventory/stock_item', 'qty', 'product_id=entity_id', null,
                    'left'
                )->joinTable('cataloginventory/stock_item', 'product_id=entity_id',
                    array('stock_status' => 'is_in_stock'))
                ->addAttributeToSelect('stock_status')
                ->addAttributeToFilter('category_id', array('in' => explode(',', $export['categories'])));
            if (!empty($export['shares_filter'])) {
                $productCollection->addAttributeToFilter('tsg_shares',
                    array('in' => explode(',', $export['shares_filter'])));
            }
            if (!empty($export['markdown_filter'])) {
                $productCollection->addAttributeToFilter('tsg_markdown',
                    array('in' => explode(',', $export['markdown_filter'])));;
            }
            if (!empty($export['provider_filter'])) {
                $productCollection->addAttributeToFilter('tsg_provider',
                    array('in' => explode(',', $export['provider_filter'])));;
            }
            if ($export['qty_filter'] !== null) {
                $productCollection->addAttributeToFilter('qty',
                    array('gteq' => $export['qty_filter']));;
            }
            $productCollection->getSelect()->group('e.entity_id');
        }

        switch ($export['format']) {
            case 'yaml' :
                $content = $this->exportYml($productCollection);
                $exportFileName = $export['file_name'];
                break;
            case 'json' :
                $content = $this->exportJson($productCollection);
                $exportFileName = $export['file_name'];
                break;
            default :
                $content = 'Export format is invalid';
                $exportFileName = 'default';
        }

        $baseMediaDir = Mage::getBaseDir('media');
        $baseTsgMediaDir = $baseMediaDir . DS . 'tsg';
        $baseTsgExportDir = $baseTsgMediaDir . DS . 'exports';
        if (!file_exists($baseTsgMediaDir)) {
            mkdir($baseTsgMediaDir, 755);
        }
        if (!file_exists($baseTsgExportDir)) {
            mkdir($baseTsgExportDir, 755);
        }
        $baseExportPath = false;
        $ext = pathinfo($exportFileName, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'yml' :
                $baseTsgExportYmlDir = $baseTsgExportDir . DS . 'yml';
                if (!file_exists($baseTsgExportYmlDir)) {
                    mkdir($baseTsgExportYmlDir, 755);
                }
                $baseExportPath = $baseTsgExportYmlDir . DS . $exportFileName;
                break;
            case 'json' :
                $baseTsgExportYmlDir = $baseTsgExportDir . DS . 'json';
                if (!file_exists($baseTsgExportYmlDir)) {
                    mkdir($baseTsgExportYmlDir, 755);
                }
                $baseExportPath = $baseTsgExportYmlDir . DS . $exportFileName;
                break;
        }

        if ($baseExportPath !== '') {
            file_put_contents($baseExportPath, $content);
        }
    }

    /**
     * Export products in yml format
     *
     * @param $productCollection
     * @return string
     */
    public function exportYml($productCollection)
    {
        $currencyСode = $this->getDefaultCurrencyCode();
        /** @var XMLWriter xml */
        $this->xml = new XMLWriter();
        $this->xml->openMemory();
        $this->xml->setIndentString('  ');
        $this->xml->startDocument('1.0', 'windows-1251');
        $this->xml->writeDTD('yml_catalog', null, 'shops.dtd');
        $this->xml->text("\n");
        $this->xml->setIndent(true);
        $this->xml->startElement('yml_catalog');
        $this->xml->writeAttribute('date', date('Y-m-d H:i:s'));
        $this->xml->startElement('offers');
        foreach ($productCollection as $product) {
            $this->xml->startElement('offer');
            $this->xml->writeAttribute('id', $product->getEntityId());
            $this->xml->writeAttribute('type', 'vendor.model');
            $stockValue = 'false';
            if ($product->getStockStatus()) {
                $stockValue = 'true';
            }
            $this->xml->writeAttribute('available', $stockValue);
            $this->xml->writeElement('url', $product->getProductUrl());
            $this->xml->writeElement('price', $product->getPrice());
            $this->xml->writeElement('currencyId', $currencyСode);
            $this->xml->writeElement('categoryId', $product->getData('category_id'));
            $productImageContent = 'no_selection';
            if ($product->getImage() !== 'no_selection') {
                $productImageContent = Mage::helper('catalog/image')->init($product, 'image')->resize(200,
                    200)->__toString();

            }
            $this->xml->writeElement('picture', $productImageContent);
            $this->xml->writeElement('qty', $product->getQty());
            $this->xml->endElement();
        }
        $this->xml->endElement();
        $this->xml->endElement();
        $this->xml->endDocument();
        return $this->xml->outputMemory();
    }

    /**
     * Retuning json Product content
     *
     * @param $productCollection
     * @return string
     */
    public function exportJson($productCollection)
    {
        $content = '';
        $productsData = array();
        $currencyCode = $this->getDefaultCurrencyCode();
        foreach ($productCollection as $product) {
            if ($product->getImage() !== 'no_selection') {
                $product['image'] = Mage::helper('catalog/image')->init($product, 'image')->resize(200,
                    200)->__toString();
            }
            $product->setCurrencyId($currencyCode);
            $dataArray = [
                'url' => $product->getProductUrl(),
                'price' => $product->getPrice(),
                'currencyId' => $product->getCurrencyId(),
                'categoryId' => $product->getData('category_id'),
                'picture' => $product->getImage(),
                'qty' => $product->getQty(),
            ];
            $date = date('Y-m-d H:i:s');
            $stockValue = 'false';
            if ($product->getStockStatus()) {
                $stockValue = 'true';
            }
            $productKey = 'offer ' . $product->getEntityId() . ' available ' . $stockValue;
            $productsData['json_catalog ' . $date]['offers'][$productKey] = $dataArray;
        }
        $content .= json_encode($productsData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        return $content;
    }

    /**
     * @return mixed
     */
    public function getSelectedCategories()
    {
        if (!$this->hasSelectedCategories()) {
            $categories = array();
            foreach ($this->getSelectedCategoriesArray() as $category) {
                $categories[] = $category;
            }
            $this->setSelectedCategories($categories);
        }
        return $this->getData('selected_categories');
    }

    /**
     * @return array
     */
    public function getSelectedCategoriesArray()
    {
        $categoryArray = explode(',', $this->getCategories());
        if (!is_array($categoryArray)) {
            $categoryArray[] = $categoryArray;
        }
        return $categoryArray;
    }

    /**
     * @return string
     */
    public function getDefaultCurrencyCode()
    {
        $defaultStoreId = Mage::app()
            ->getWebsite(true)
            ->getDefaultGroup()
            ->getDefaultStoreId();
        return Mage::app()->getStore($defaultStoreId)->getCurrentCurrencyCode();

    }


}