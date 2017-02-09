<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
	function index(){
		if(IS_POST){
			$user=M("member")->where('user="'.I('post.user').'"')->find();
			if(I("post.psw")==$user['psw']){
				$user['time']=time();//10min不操作则session失效
				session('auth',$user);
				$this->success("登陆成功",U("Index/index"));
			}else{
				echo "用户名或密码错误";
				echo "<a href='/login'>登陆</a>";
			}
		}else{
			if(!empty(session("auth"))){
				redirect(U('index/index'));
			}
			$this->assign("title","Please login");
			$this->display();
		}
	}
	
	
	//读取session
	function sh(){
		dump($_SESSION);
	}
	
	
	/*
	 * 退出登陆
	 * */
	function logout(){
		session("[destroy]");
		//http://www.cnblogs.com/BensonHe/archive/2011/01/15/1936159.html
		//如果是iframe，则刷新外部窗口。
		echo "<script>if(parent.location.href!=document.location.href){
			parent.location.reload();};</script>";
		$this->success('退出成功！',U("Login/index"));
	}
}