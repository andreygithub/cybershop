<?php

class csPaymentRemoveProcessor extends modObjectRemoveProcessor  {
	public $checkRemovePermission = true;
	public $classKey = 'csPayment';
	public $languageTopics = array('cybershop');

}
return 'csPaymentRemoveProcessor';