<?php 

//调试：输出变量到文件。
function mylog($some){
	file_put_contents('backup/log.txt',var_export($some,true));
}


//由于20170101获取时间戳
function _getTimeStamp($time){
	$y=substr($time,0,4);
	$m=substr($time,4,2);
	$d=substr($time,6,2);
	//int mktime(时, 分, 秒, 月, 日, 年)
	return mktime(0, 0, 0, $m, $d, $y);
}