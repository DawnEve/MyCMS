<?php
namespace Admin\Controller;

use Common\Controller\AuthController;
class ArticleController extends AuthController {
	function _empty(){
		echo "name: ";
		echo MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
	}
}