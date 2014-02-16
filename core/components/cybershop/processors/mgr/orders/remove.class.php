<?php

class csOrderRemoveProcessor extends modObjectRemoveProcessor  {
	public $checkRemovePermission = true;
	public $classKey = 'csOrder';
	public $languageTopics = array('cybershop');

}
return 'csOrderRemoveProcessor';