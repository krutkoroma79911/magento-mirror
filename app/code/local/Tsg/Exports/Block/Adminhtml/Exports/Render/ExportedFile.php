<?php

class Tsg_Exports_Block_Adminhtml_Exports_Render_ExportedFile
    extends Varien_Data_Form_Element_Abstract
{
    protected $_element;

    public function getElementHtml()
    {
        $output = 'There is no generated file ';
        $exportFileName = Mage::registry('tsg_exports')->getFileName();
        if (!empty($exportFileName)) {
            $tsgExportPath = 'tsg' . DS . 'exports';
            $baseExportDirPath = Mage::getBaseDir('media') . DS . $tsgExportPath;
            $baseMediaUrl = Mage::getBaseUrl('media');
            $fileType = pathinfo($exportFileName, PATHINFO_EXTENSION);
            switch ($fileType) {
                case 'yml' :
                    $baseExportDirPath .= DS . 'yml' . DS . $exportFileName;
                    $exportMediaUrlPath = $baseMediaUrl . DS . $tsgExportPath . DS . 'yml' . DS . $exportFileName;
                    break;
                case 'json' :
                    $baseExportDirPath .= DS .'json' . DS . $exportFileName;
                    $exportMediaUrlPath = $baseMediaUrl . DS . $tsgExportPath . DS . 'json' . DS . $exportFileName;
                    break;
            }
            if (file_exists($baseExportDirPath)) {
                $output = '<a href = ' . $exportMediaUrlPath . ' download >Save file</a>';
            }
        }
        return $output;

    }
}