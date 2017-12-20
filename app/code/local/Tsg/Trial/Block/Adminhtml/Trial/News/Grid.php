<?php

class Tsg_Trial_Block_Adminhtml_Trial_News_Grid
    extends Mage_Adminhtml_Block_Widget_Grid

{
    /**
     * Tsg_Trial_Block_Adminhtml_Trial_News_Grid constructor.
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct();
        $this->setId('tsg_trial_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('tsg_trial/news')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Preparing data and columns for grid
     */
    public function _prepareColumns()
    {
        $helper = Mage::helper('tsg_trial');
        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'index' => 'id',
        ));
        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
        ));
        $this->addColumn('content', array(
            'header' => $helper->__('Content'),
            'index' => 'content',
        ));
        $this->addColumn('image', array(
            'header' => $helper->__('Image'),
            'index' => 'image',
            'renderer' => 'Tsg_Trial_Block_Adminhtml_Trial_Render_Image'
        ));
        $this->addColumn('priority', array(
            'header' => $helper->__('Priority'),
            'index' => 'priority'
        ));
        $this->addColumn('action',
            array(
                'header' => $helper->__('News'),
                'width' => '50px',
                'index' => 'stores',
                'filter' => false,
                'sortable' => false,
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $helper->__('Edit'),
                        'url' => array(
                            'base' => '*/*/edit',
                            'params' => array('store' => $this->getRequest()->getParam('store'))
                        ),
                        'field' => 'id'
                    )
                ),

            ));
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
