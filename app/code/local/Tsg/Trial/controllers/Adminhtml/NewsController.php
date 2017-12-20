<?php

class Tsg_Trial_Adminhtml_NewsController
    extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('News'))
            ->_title($this->__('Manage News'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_title($this->__('News'))
            ->_title($this->__('Create News'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction()
    {
        $newsId = (int)$this->getRequest()->getParam('id');
        $this->_initNews($newsId);
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @param $newsId
     */
    public function _initNews($newsId)
    {
        $this->_title($this->__('News'))->_title($this->__('Edit'));
        /** @var Tsg_Trial_Model_News $news */
        $news = Mage::getModel('tsg_trial/news')
            ->setStoreId($this->getRequest()->getParam('store', 0));
        $news->setData('_edit_mode', true);
        if ($newsId) {
            $news->load($newsId);
        }
        Mage::register('current_news', $news);
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            if (!empty($id)) {
                $data['id'] = $id;
            }
            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . '/news/';
                    $uploader->save($path, $_FILES['image']['name']);
                    $data['image'] = 'news/' . $_FILES['image']['name'];
                } catch (Exception $e) {
                }
            } else {
                if (isset($data['image']['delete'])) {
                    $data['image'] = '';
                } else {
                    $data['image'] = $data['image']['value'];
                }
            }
            $data['created_at'] = Mage::getModel('core/date')->timestamp(time());
            $model = Mage::getModel('tsg_trial/news')->setData($data);
            try {
                $model->save()->getId();
                $this->_getSession()->addSuccess($this->__('News is saved.'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        }
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('tsg_trial/news');
            $model->load($id);
            $model->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('tsg_trial')->__('The news has been deleted.'));
            $this->_redirect('*/*/');
            return;
        }
    }


}