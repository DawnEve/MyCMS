<?php
namespace Admin\Controller;

use Common\Controller\AuthController;
class OrderController extends AuthController {
    public function index($supplier_id=-1){
        if($supplier_id>0){
            //http://tp.dawneve.com/order/index/supplier_id/1
            $data=M('order')->alias('a')
                            ->field('order_id, order_name, order_unit, order_quantity, order_price, order_note, order_time,order_status, add_time, a.supplier_id,b.supplier_name')
                            ->join('__SUPPLIER__ b ON a.supplier_id = b.supplier_id', 'LEFT')
//                             ->where('a.supplier_id=' . $supplier_id . ' and a.order_status >0')
                            ->where('a.supplier_id=' . $supplier_id)
                            ->order('order_time DESC,order_id DESC')
                            ->select();
	        $this->assign('current_supplier_name', $data[0]['supplier_name']);
        }else{
            //http://tp.dawneve.com/order/
             $data=M('order')->alias('a')
                            ->field('order_id, order_name, order_unit, order_quantity, order_price, order_note, order_time,order_status, add_time, a.supplier_id,b.supplier_name')
                            ->join('__SUPPLIER__ b ON a.supplier_id = b.supplier_id', 'LEFT')
                            //->where('a.order_status >0')
                            ->order('order_time DESC,order_id DESC')
                            ->select();
            $this->assign('current_supplier_name',"");
        }
        //dump($data[0]);die();
        $this->assign('order', $data);
        $this->assign('order_status_arr', array(
        		0=>"订货",
        		1=>"到货",
        		2=>"对账",
        		3=>"报销",
        ));
        $this->display('Order/index');
    }
    
    //添加
	function add(){
		if(!IS_POST){
	        //获取供应商信息
	        $supplier=M('supplier')->field("supplier_id,supplier_name")->select();        
	        $this->assign('supplier', $supplier);
			$this->display();
		}else{
			if(D('order')->insert()){
				//$this->success('添加成功',U("index"),1);
				$this->redirect('index',array(),0,'添加成功');
			}else{
				$this->error('添加失败！');
			}
		}
	}
	

    
    //编辑表单
    function edit(){
    	if(!IS_POST){
    		$id=I('get.id');
    		if(empty($id)){
    			$this->error("please input an id",U('index'));
    		}
    		$data=M("order")->find($id);
    		$this->assign('data',$data);
    		$this->assign('supplier',M('supplier')->select());
    		$this->display();
    	}else{
    	 	//如果order_time为空，则补充为当前时间
            $time=I("order_time");
            if($time==""){
                $_POST['order_time']=time();
            }else{
                $_POST['order_time']= _getTimeStamp($time);
            }

            $data=array(
                "supplier_id"=>I("supplier_id"),
                "order_time"=>I("order_time"),
                "order_status"=>1,
                "add_time"=>time(),
            );
            
            //需要使用事务保证数据一致性
    	    $form=D('order');
            $data['order_name']=I('order_name');
            $data['order_unit']=I('order_unit');
            $data['order_quantity']=I('order_quantity');
            $data['order_price']=I('order_price');
            $data['order_note']=I('order_note');
            $data['order_id']=I('order_id');
			//创建表格
            if($form->save($data)){
                $this->redirect('index',array(),0,'修改成功');
            }else{
                $this->error('修改失败！');
            }
    	}
    }

    //删除条目
    function del($id){
    	if(empty($id)){
    		echo $this->ajaxReturn(array(0,'没有传入id!'));
    		exit();
    	}
    	$rs=M('order')->where('order_id='.$id)->delete();
    	if($rs){
	    	echo $this->ajaxReturn(array($rs,'删除成功'));    		
    	}else{
	    	$this->ajaxReturn(array(0,'删除失败')); 
    	}
    }

    //显示全部
    public function archive(){
            $weibo=M('weibo')->alias('a')
                    ->field('a.id, a.uid, a.content, a.add_time, a.cid, b.name, b.pid')
                    ->join('think_weibo_category b ON a.cid = b.id', 'LEFT')
                    ->order('add_time DESC')
                    ->select();

            //dump($weibo);

            $this->assign('weibo', $weibo);
            $this->display();
    }

    //改变订单状态：订货、到货、对账、报销。
    public function status(){
    	if(!IS_AJAX){
    		$this->ajaxReturn(array(0,"非法访问"));
    		exit();
    	}
    	
    	$status=I("post.status");
    	$list=I("post.list");
    	$list=join('","',$list);
    	
    	//实例化对象
    	$data=array("order_status"=>$status);
    	$order=M('order');
    	$rs=$order->where('order_id in ("'.$list.'")')->setField($data);
    	
    	//返回结果
    	if($rs){
	    	$this->ajaxReturn(array(1,'成功修改了'.$rs.'条记录.'));
    	}else{
	    	$this->ajaxReturn(array(0,'失败：已经是类别。'.$order->getError()));
    	}
    }
    
	//汇总、统计
    function summary(){
    	$data=D("Order")->getSummary();
    	
    	
    	$this->assign('data',$data[0]);
    	$this->assign('supplier_arr',$data[1]);
    	$this->assign('status_arr',$data[2]);
    	$this->display();
    }
    

    
    //防范非法操作
    function _empty(){
        echo 'This page ['.CONTROLLER_NAME . '->' .ACTION_NAME. '] is not found!';
    }
	
}