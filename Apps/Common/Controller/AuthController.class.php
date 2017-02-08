<?php
namespace Common\Controller;
use Think\Controller;
use Think\Auth;
class AuthController extends Controller {
	protected function _initialize(){
		//先判断session
		$session_auth=session('auth');
		//1.必须登陆后查看、操作
		if(!$session_auth){
			$this->error("非法访问，正在跳转到登陆页面！",U("Login/index"));
		}
		
		//2.超过10min不操作则自动退出
		if(time() - $session_auth['time']>10*60){
			$this->success("超时自动退出",U("Home/Login/logout"));
			exit();
		}else{
			$_SESSION['auth']['time']=time();
		}
		
		//3.如果是超级管理员，则不用验证，直接获取所有权限。
		if($session_auth['id']==1){
			return true;
		}

		//4.其他用户需要鉴权
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$auth=new Auth();
		if(!$auth->check($rule_name,$session_auth['id'])){
			$this->error("没有权限",U("Home/login/index"));
		}
	}
}