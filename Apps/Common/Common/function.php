<?php 

//调试：输出变量到文件。
function mylog($some){
	file_put_contents('backup/log.txt',var_export($some,true));
}