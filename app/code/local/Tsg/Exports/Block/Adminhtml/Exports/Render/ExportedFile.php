<?php

class Tsg_Exports_Block_Adminhtml_Exports_Render_ExportedFile
    extends Varien_Data_Form_Element_Abstract
{
    protected $_element;

    /**
     * @return string
     */
    public function getElementHtml()
    {
        $output = 'There is no generated file ';
        $exportFileName = Mage::registry('tsg_exports')->getFileName();
        $fileType = pathinfo($exportFileName, PATHINFO_EXTENSION);
        if (!empty($exportFileName)) {
            switch ($fileType) {
                case 'yml' :
                    $output = $this->getExportFileLink('yml',$exportFileName);
                    break;
                case 'json' :
                    $output = $this->getExportFileLink('json',$exportFileName);
                    break;
            }

        }
        return $output;

    }

    /**
     * Returning link of generated file
     *
     * @param $type
     * @param $exportFileName
     * @return string
     */
    public function getExportFileLink($type,$exportFileName)
    {
        $tsgExportPath = 'tsg' . DS . 'exports';
        $baseExportDirPath = Mage::getBaseDir('media') . DS . $tsgExportPath;
        $baseMediaUrl = Mage::getBaseUrl('media');
        $baseExportDirPath .= DS . $type . DS . $exportFileName;
        $exportMediaUrlPath = $baseMediaUrl . DS . $tsgExportPath . DS . $type . DS . $exportFileName;
        $link = '';
        if (file_exists($baseExportDirPath)) {
            $link =  '<a href = ' . $exportMediaUrlPath . ' download >Save file</a>';
        }
        return $link;
    }
}