<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Controller\AuthController;

class IndexController extends AuthController {
    public function index(){
    	//echo "wjl index";
    	//echo "<a href='".U('login/logout')."'>退出</a>";
    	//$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    	//$this->show("123");
    	$this->assign("title","IndexPage");
    	$this->display();
    }
    
    public function read(){
    	$data=M("Data")->find(2);
    	if($data){
	    	$this->assign("rs",$data);
    	}else{
    		$this->error("数据错误");
    	}
    		
    	$this->display();
    }
    public function read2(){
    	$data=M("form")->select();
    	dump($data);
//     	$this->assign("rs",$data);
//     	$this->display();
    }
    public function insert(){
    	$form=D("Form");
    	if($form->create()){
    		//$form->create_time=time();//直接加属性。从model自动添加了。
    		$rs=$form->add();
    		if($rs){
    			//$this->success("成功");
    			redirect(U("read2"));
    		}else{
    			$this->error("错误");
    		}
    	}else{
    		$this->error($form->getError());
    	}
    }
    
    function add2(){
    	//如果相信数据，可以直接add
    	$form=D("form");
    	$data['title']="inner4";
//     	$data["content"]="some";//要么使用array，要么使用orm，否则只会按照一个添加。
    	$form->content="some4";
//     	$form->add($data);//缺点：不会通过模型过滤、自动完成。
    	$form->add();//缺点：不会通过模型过滤、自动完成。
    	
    	redirect(U("read2"));
    }
    
    //修改和更新
    function edit($id=2){
    	$m=M("form");
    	$this->assign("vo",$m->find($id));
    	$this->display();
    }
    function update(){
    	$form=D('form');
    	if($form->create()){
    		$rs=$form->save();
    		if($rs){
    			//$this->success("成功");
    			redirect(U("read2"));
    		}else{
    			$this->error("写入失败");
    		}
    	}else{
    		$this->error($form->getError());
    	}
    }
    
    //递增递减操作
    function incre(){
    	$form=M("form");
    	$form->where('id=1')->setField("create_time",100);
    	$form->where('id=1')->setInc("create_time",20);
    	$form->where('id=1')->setDec("create_time",6);
    	echo $form->where('id=1')->getField("create_time");
    }
    
    
    
    //根据条件 返回sql语句
    //==============================
    private function sel($map='1'){
    	$m=M("form");
    	$sql=$m->where($map)->select(false);
    	return $sql;
    }
    //区间查询
    function sel2(){
//     	$map["id"]=array(array('gt',1),array('lt',10));
    	$map["id"]=array(array('gt',1),array('lt',10),'or');
    	echo $this->sel($map);
    }
    //组合查询：字符串查询
    function sel3(){
    	$map['id']=array('neq',1);
    	$map['user']='ok';//array('eq','ok');//这一句不起作用//todo
    	$map['_string']="status=1 and score>10";
    	echo $this->sel($map);
    }
    //组合查询：请求字符串查询
    function sel4(){
    	$map['id']=array('gt',10);
    	$map['user']='ok';//array('eq','ok');//这一句不起作用//todo
    	$map['_query']="status=1&score=100&_logic=or";
    	echo $this->sel($map);
    }
    
    //page用户
    function sel5(){
    	//Page('page[,listRows]')
    	echo M('form')->page(3)->select(false);//默认每页20条
    	echo "<br>";
    	//echo M('form')->page('3,10')->select(false);//设置每页10条
    }
    
    //独特
    function sel6(){
    	$data = M("form")->distinct(true)->field('id')->select();
    	dump($data);
    }
    
    
    
    
    //5.变量=======================================
    function get2(){
    	//I('变量类型.变量名/修饰符',['默认值'],['过滤方法'],['额外数据源'])
    	echo I('GET.name','null'),"<br>";
    	echo I("param.title"),"<br>";
    	echo I("title"),"<br>";
    	//http://my.dawneve.com/Index/get2/name/jimmy
    	//http://my.dawneve.com/Index/get2/name/jimmy/title/vp
    }
    
    //获取数组
    function get3(){
    	$data=I("get.");
    	dump($data);
    }
    
    //使用类似ci的path获取路径参数
    function get4(){
    	dump("path.");
    	echo I('path.1'),"<br>";
    	echo I('path.2'),"<br>";
    	echo I('path.3'),"<br>";
    	echo I('path.4'),"<br>";
    }
    
    //变量修饰符 I('变量类型.变量名/修饰符');	
    function get5(){
    	echo I("get.title/d");//转化为数字为0
    	echo I("get.title/s");//字符串为vp
    	//http://my.dawneve.com/Index/get5/name/jimmy/title/vp
    }
    //
    
    
    function set1(){
    	$m=M('member');
    	$data['name']="Robin";
    	$data['psw']="123456";
    	$data['score']=98;
    	$data['email']="Robin@163.com";
    	$data['add_time']=time();
    	$rs=$m->add($data);
    	dump($rs);
    }
    
    
    
    
    
    
    
    
}








