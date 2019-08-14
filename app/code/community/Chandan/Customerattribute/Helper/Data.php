<?php
class Chandan_Customerattribute_Helper_Data extends Mage_Core_Block_Template
{
	public function getImage(){
		echo $this->getUrl('profile/profileimage/getimage');
	}

	 public function getUploadUrl(){
        return Mage::getUrl('profile/profileimage/upload');
    }

    public function getFileExt($file_path)
    {
        return pathinfo($file_path, PATHINFO_EXTENSION);
    }

    public function generateImgName($ext)
    {
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customerData = Mage::getSingleton('customer/session')->getCustomer();
			$customerid =  $customerData->getId();
		}		
        return 'avtar'.'_'.$customerid.".".$ext;
    }
}