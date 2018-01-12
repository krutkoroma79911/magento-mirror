<?php

class Tsg_Exports_Block_Adminhtml_Exports_Render_File
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $output = '';
        $fileName = $row->getData($this->getColumn()->getIndex());
        if (!empty($fileName)) {
            $tsgExportPath = 'tsg' . DS . 'exports';
            $baseExportDirPath = Mage::getBaseDir('media') . DS . $tsgExportPath;
            $baseMediaUrl = Mage::getBaseUrl('media');
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            switch ($fileType) {
                case 'yml' :
                    $baseExportDirPath .= DS . 'yml' . DS . $fileName;
                    $exportMediaUrlPath = $baseMediaUrl . DS . $tsgExportPath . DS . 'yml' . DS . $fileName;
                    break;
                case 'json' :
                    $baseExportDirPath .= DS .'json' . DS . $fileName;
                    $exportMediaUrlPath = $baseMediaUrl . DS . $tsgExportPath . DS . 'json' . DS . $fileName;
                    break;
            }
            if (file_exists($baseExportDirPath)) {
                $output = '<a href = ' . $exportMediaUrlPath . ' download >Save file</a>';
            }
        }
        return $output;
    }
}