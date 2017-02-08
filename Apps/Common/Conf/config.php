<?php
return array(
	//'配置项'=>'配置值'
	"URL_MODEL"=>2,//2REWRITE最友好的URL方式
	"name"=>"jimmy",
	
	//允许查看的模块
	'MODULE_ALLOW_LIST' => array('Admin','Home'),
		
		
	//页面调试开关
	'SHOW_PAGE_TRACE' => true,
	
	//数据库信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'MyCMS', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PARAMS' =>  array(), // 数据库连接参数
	'DB_PREFIX' => 'tp_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
	
	//auth验证
	'AUTH_CONFIG'=>array(
			'AUTH_ON' => true, //认证开关
			'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
			'AUTH_GROUP' => 'tp_auth_group', //用户组数据表名
			'AUTH_GROUP_ACCESS' => 'tp_auth_group_access', //用户组明细表
			'AUTH_RULE' => 'tp_auth_rule', //权限规则表
			'AUTH_USER' => 'tp_members'//用户信息表
	),
		
	//加入bootstrap资源链接
	"TMPL_PARSE_STRING"=>array(
			"__BS__"=>"/Public/bootstrap-3.3.7-dist",
			"__Public__"=>"/Public",
	),
);