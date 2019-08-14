<?php 
class Chandan_Customerattribute_Model_Mysql4 extends Mage_Eav_Model_Entity_Setup 
{   
    public function attributeExists($entityTypeId, $attributeId) 
    {
        try 
        {
            $entityTypeId = $this->getEntityTypeId($entityTypeId);
            $attributeId = $this->getAttributeId($entityTypeId, $attributeId);
            return !empty($attributeId);
        } 
        catch(Exception $e) 
        {
            return FALSE;
        }
    }
}