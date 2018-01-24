<?php

class Tsg_Exports_Block_Adminhtml_Exports_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Tsg_Exports_Block_Adminhtml_Exports_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('export_id');
        $this->setId('tsg_exports_exports_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Returning collection Model of exports
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'tsg_exports/exports_collection';
    }

    protected function _prepareColumns()
    {
        $this->addColumn('export_id',
            array(
                'header' => $this->__('Export ID'),
                'align' => 'right',
                'index' => 'export_id',
            ));
        $this->addColumn('export_name',
            array(
                'header' => $this->__('Export Name'),
                'align' => 'right',
                'index' => 'export_name',
            ));
        $this->addColumn('file_name',
            array(
                'header' => $this->__('File Name'),
                'align' => 'right',
                'index' => 'file_name',
            ));
        $this->addColumn('enable',
            array(
                'header' => $this->__('Status'),
                'align' => 'right',
                'index' => 'enable',
                'type' => 'options',
                'options' => array(
                    '0' => 'Disable',
                    '1' => 'Enable'
                ),
            ));
        $this->addColumn('format',
            array(
                'header' => $this->__('Format'),
                'align' => 'right',
                'index' => 'format',
                'type' => 'options',
                'options' => array(
                    'json' => 'JSON',
                    'yaml' => 'YAML'
                ),
            ));
        $this->addColumn('categories',
            array(
                'header' => $this->__('Categories'),
                'align' => 'right',
                'index' => 'categories',
                'renderer' => 'tsg_exports/adminhtml_exports_render_categories'
            ));
        $this->addColumn('qty_filter',
            array(
                'header' => $this->__('Filter by quantity'),
                'align' => 'right',
                'index' => 'qty_filter',
            ));
        $this->addColumn('tsg_shares',
            array(
                'header' => $this->__('Filter by shares'),
                'align' => 'right',
                'index' => 'shares_filter',
                'renderer' => 'tsg_exports/adminhtml_exports_render_attribute'
            ));
        $this->addColumn('tsg_markdown',
            array(
                'header' => $this->__('Filter by markdown'),
                'align' => 'right',
                'index' => 'markdown_filter',
                'renderer' => 'tsg_exports/adminhtml_exports_render_attribute',
            ));
        $this->addColumn('tsg_provider',
            array(
                'header' => $this->__('Filter by provider'),
                'align' => 'right',
                'index' => 'provider_filter',
                'renderer' => 'tsg_exports/adminhtml_exports_render_attribute',
            ));
        $this->addColumn('file', array(
            'header' => $this->__('File'),
            'align' => 'center',
            'renderer' => 'tsg_exports/adminhtml_exports_render_file',
            'index' => 'file_name',
        ));


        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getExportId()));
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('mass_action');
        $this->getMassactionBlock()->addItem('generate', array(
            'label' => Mage::helper('tsg_exports')->__('Generate'),
            'url' => $this->getUrl('*/*/massGenerate'),
            'confirm' => Mage::helper('tsg_exports')->__('Are you sure?')
        ));

        return $this;
    }

}