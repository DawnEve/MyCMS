<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model{

	//订单表的统计
	function getSummary(){
		$sql="SELECT b.supplier_name,a.order_status,sum(order_price*order_quantity) as sums FROM `tp_order` a, tp_supplier b
    			where a.supplier_id=b.supplier_id
    			GROUP BY a.supplier_id,a.order_status;";
		return M()->query($sql);//dump($data);
	}
	

}

