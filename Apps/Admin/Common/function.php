<?php 
//通过s_id和status获取金额
function getSumsBy($s,$o,$data){
	foreach($data as $item){
		if($item['supplier_name']==$s && $item['order_status']==$o){
			return 0+$item["sums"];
		}
	}
	return 0;
}