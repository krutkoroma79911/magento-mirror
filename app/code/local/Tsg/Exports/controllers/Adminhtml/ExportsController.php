<?php

class Tsg_Exports_Adminhtml_ExportsController
    extends Mage_Adminhtml_Controller_Action
{

    protected $xml;

    public function indexAction()
    {
        $this->_title($this->__('Exports'))
            ->_title($this->__('Manage Exports'));
        $this->loadLayout();
        $this->renderLayout();

    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Exports'));
        $this->_initExport();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function _initExport()
    {
        $exportId = $this->getRequest()->getParam('id');
        $entity = Mage::getModel('tsg_exports/exports');
        if ($exportId) {
            $entity->load($exportId);
            if (!$entity->getExportId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This export no longer exists.'));
                $this->_redirect('*/*/');
            }
        }
        $this->_title($entity->getId() ? $this->__('Edit Export') : $this->__('New Export'));

        $data = Mage::getSingleton('adminhtml/session')->getExportsData(true);
        if (!empty($data)) {
            $entity->setData($data);
        }
        Mage::register('tsg_exports', $entity);
        return $entity;
    }

    public function categoriesAction()
    {
        $this->_initExport();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function categoriesJsonAction()
    {
        $this->_initExport();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('tsg_exports/adminhtml_exports_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    public function saveAction()
    {
        $helper = Mage::helper('tsg_exports');
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('tsg_exports/exports');
            if (array_key_exists('categories', $data)) {
                $catIds = explode(',', $data['categories']);
                $catIds = array_diff(array_unique($catIds), array('', null, false));
                $data['categories'] = implode(',', $catIds);
            }
            if (array_key_exists('shares_filter', $data)) {
                $data['shares_filter'] = implode(',', $data['shares_filter']);
            } else {
                $data['shares_filter'] = '';
            }
            if (array_key_exists('markdown_filter', $data)) {
                $data['markdown_filter'] = implode(',', $data['markdown_filter']);
            } else {
                $data['markdown_filter'] = '';
            }
            if (array_key_exists('provider_filter', $data)) {
                $data['provider_filter'] = implode(',', $data['provider_filter']);
            } else {
                $data['provider_filter'] = '';
            }
            if (substr($data['file_name'], -4) === '.yml') {
                $data['file_name'] = substr($data['file_name'], 0, -4);
            } elseif (substr($data['file_name'], -5) === '.json') {
                $data['file_name'] = substr($data['file_name'], 0, -5);
            }
            switch ($data['format']) {
                case 'yaml' :
                    $data['file_name'] = $data['file_name'] . '.yml';
                    break;
                case 'json' :
                    $data['file_name'] = $data['file_name'] . '.json';
                    break;
            }
            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            $backToEdit = (bool)$this->getRequest()->getParam('save_and_continue');
            $success = false;
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $success = true;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
            }
            if (!$success || $backToEdit) {
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } else {
                $this->_redirect('*/*/index');
            }
        }
    }

    /**
     * Generating export file
     *
     * @param null $export
     */
    public
    function generateAction(
        $export = null
    ) {
        /** @var Tsg_Exports_Model_Exports $exportModel */
        $exportModel = Mage::getModel('tsg_exports/exports');
        $massAction = true;
        if ($export === null) {
            $exportId = $this->getRequest()->getParam('id');
            if ($exportId !== null) {
                $export = $exportModel->load($exportId);
            }
            $massAction = false;
        }
        $exportModel->generateExport($export);
        if ($massAction === false) {
            Mage::getSingleton('adminhtml/session')
                ->addSuccess(Mage::helper('tsg_exports')->__('Export file created'));
            $this->_redirect('*/*/edit', array('id' => $exportId));
        }
    }

    /**
     * Mass action for exports generate
     *
     */
    public
    function massGenerateAction()
    {
        $exportIds = $this->getRequest()->getPost('mass_action');
        $exportCollection = Mage::getModel('tsg_exports/exports')->getCollection()->addIdsFilter($exportIds);
        foreach ($exportCollection as $export) {
            $this->generateAction($export);
        }
        Mage::getSingleton('adminhtml/session')
            ->addSuccess(Mage::helper('tsg_exports')->__('Exports are generated'));
        $this->_redirect('*/*/');
    }

    protected
    function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/exports');
    }
}