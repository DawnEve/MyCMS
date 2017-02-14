<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model{

	//订单表的统计
	function getSummary(){
		$sql="SELECT b.supplier_name,a.order_status,sum(order_price*order_quantity) as sums FROM `tp_order` a, tp_supplier b
    			where a.supplier_id=b.supplier_id
    			GROUP BY a.supplier_id,a.order_status;";
		$data = M()->query($sql);//dump($data);
		
		$supplier_arr=M('supplier')->field("supplier_id,supplier_name")->select(); //dump($supplier_arr);
		$supplier_arr[]=array(
				"supplier_id"=>count($supplier_arr),
				"supplier_name"=>"小结"
		);
		
		$status_arr=C("ORDER_STATUS"); //dump($status_arr);
		$len=count($status_arr);//长度
		$status_arr[]=array( $len,"总计" );
		
		//===================
		/*
		$list_com=array();
		foreach($supplier_arr as $supplier){
			//dump($supplier);
			$list_com[$supplier['supplier_name']]=array();
			foreach($status_arr as $status){
				$list_com[$supplier['supplier_name']][]=getSumsBy($supplier['supplier_name'], $status[0], $data);
			}
		}
		$list_sta=array();
		dump($list_com);
		*/
		//===================
		
		//最后加一行小结
		return array($data,$supplier_arr,$status_arr);
	}
	
	//插入数据表
	function insert(){
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
		$result=1;
		$form=D('order');
		for($i=0;$i<count($_POST['order_name']);$i++){
			$data['order_name']=$_POST['order_name'][$i];
			$data['order_unit']=$_POST['order_unit'][$i];
			$data['order_quantity']=$_POST['order_quantity'][$i];
			$data['order_price']=$_POST['order_price'][$i];
			$data['order_note']=$_POST['order_note'][$i];
		
			if($data['order_name']=="") continue;
		
			$form->create($data);
			if(!$form->add()){
				$result *= 0;
			}
		}
		
		return $result;
	}

}

