<?php
class Chandan_Customerattribute_ProfileimageController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {    	    	
		//$this->loadLayout();    		
		$this->loadLayout(array('default','profile_profileimage_index'));
		$this->getLayout()->getBlock('head')->setTitle('Profile Image');		
		$this->renderLayout();
    }

     public function uploadAction(){		
		$_helper = Mage::helper('customerattribute');
		$root_path = Mage::getBaseDir(); 

		//Get the tmp url
		$photo_src = $_FILES['avatar']['tmp_name'];
		$photo_path = $_FILES['avatar']['name'];		
		$ext = $_helper->getFileExt($photo_path);
				
		if (is_file($photo_src)) { 									
			if (!file_exists($root_path.'/media/customer/')) { 				
				mkdir($root_path.'/media/customer/', 0777, true); 
			}			 		
			$img_name = $_helper->generateImgName($ext);
			$photo_dest = $root_path.'/media/customer/'.$img_name;
			copy($photo_src, $photo_dest);											
		}
		$this->saveImage($img_name);
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('customerattribute')->__('Profile Image has uploaded successfully'));
		$this->_redirect('*/*/index');
	}
   
	public function saveImage($img_name){		
		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customer = Mage::getSingleton('customer/session')->getCustomer();			
			$custObj = Mage::getModel('customer/customer')->load($customer->getId());						
				if($img_name != ''){
					$img_name = '/'.$img_name;
					$custObj->setavatar($img_name);
					$custObj->save();			
			}
		}
	}

    public function getImageAction(){
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
		     $customerData = Mage::getSingleton('customer/session')->getCustomer();
		      $custid = $customerData->getId();
		 } 

		$customer = Mage::getModel('customer/customer')->load($custid);
		$file = $customer->getavatar();

		$path = Mage::getBaseDir('media') . DS . 'customer';
		$ioFile = new Varien_Io_File();
        $ioFile->open(array('path' => $path));
        $fileName = $ioFile->getCleanPath($path . $file);
        $path = $ioFile->getCleanPath($path);
        $ioFile->streamOpen($fileName, 'r');
        $contentLength = $ioFile->streamStat('size');
        $contentModify = $ioFile->streamStat('mtime');


		if ($plain) {
	            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
	            switch (strtolower($extension)) {
	                case 'gif':
	                    $contentType = 'image/gif';
	                    break;
	                case 'jpg':
	                    $contentType = 'image/jpeg';
	                    break;
	                case 'png':
	                    $contentType = 'image/png';
	                    break;
	                default:
	                    $contentType = 'application/octet-stream';
	                    break;
	        }
	    }

        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', $contentLength)
                ->setHeader('Last-Modified', date('r', $contentModify))
                ->clearBody();
        $this->getResponse()->sendHeaders();
        while (false !== ($buffer = $ioFile->streamRead())) {
            echo $buffer;
        }
        //echo $fileName;
		exit();
	} 
}