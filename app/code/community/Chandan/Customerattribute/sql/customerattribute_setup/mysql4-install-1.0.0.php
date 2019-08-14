<?php
$installer = $this;
$installer->startSetup();
$vCustomerEntityType = $installer->getEntityTypeId('customer');
$vCustAttributeSetId = $installer->getDefaultAttributeSetId($vCustomerEntityType);
$vCustAttributeGroupId = $installer->getDefaultAttributeGroupId($vCustomerEntityType, $vCustAttributeSetId);

$installer->addAttribute('customer', 'avatar', array(
        'label' => 'Avatar Image',
        'input' => 'image',
        'type'  => 'varchar',
        'forms' => array('customer_account_edit','customer_account_create','adminhtml_customer','checkout_register'),
        'required' => 0,
        'user_defined' => 1,
));

$installer->addAttributeToGroup($vCustomerEntityType, $vCustAttributeSetId, $vCustAttributeGroupId, 'avatar', 0);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'avatar');
$oAttribute->setData('used_in_forms', array('customer_account_edit','customer_account_create','adminhtml_customer','checkout_register'));
$oAttribute->save();

$installer->endSetup();