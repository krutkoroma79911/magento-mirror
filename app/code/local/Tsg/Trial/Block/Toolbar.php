<?php

class Tsg_Trial_Block_Toolbar
    extends Mage_Catalog_Block_Product_List_Toolbar
{
    public function getAvailableOrders()
    {
        $sortArray = ['created_at' => 'Date', 'content' => 'Content'];
        return $sortArray;
    }

}