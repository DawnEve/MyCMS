<?php
namespace Admin\Controller;

use Common\Controller\AuthController;
class ConsumerController extends AuthController {
	function _empty(){
		echo "name: ";
		echo MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
	}
}