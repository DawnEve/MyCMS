基于bootstrap和thinkPHP结合做后台管理


=============================================
bootstrap:I:\xampp\htdocs\bootstrap
thinkPHP:I:\xampp\htdocs\think\ThinkPHP

I:\BaiduYunDownload\PHP
=============================================

1.配制环境、配制域名
//my.dawneve.com

2.重新熟悉一下框架细节。
看到6 路由。

首先总结一下，框架执行的大致流程： 
index.php->载入框架->读取配置项->生成应用->载入类->框架new这些类的方法->模板渲染display展示；

具体的类和文件如下：
--> index.php（入口、调试模式、应用路径）
--> ThinkPHP.php（定义路径与访问模式）
--> Think\Think（类加载器、异常处理、读取共有配置）
--> Think\App（请求url调度解析、执行调度解析结果）
--> exec 执行用户定义的Controller的Action方法
--> Think\Dispatcher（根据url模式解析M、C、A和参数，加载模块配置）
--> Think\Controller（调用视图、包装和重定向）

可以看到，框架的内部流程其实比较简单，还有2个很重要的类：
Think\Hook： 监听App、Action、View的各个阶段，执行Behavior
Think\Behavior： 可配置（配置文件）可增删（代码）

3.
===========================完成了auth认证。比较完成的一个流程。
http://baijunyao.com/article/67

DROP TABLE IF EXISTS `tp_member`;
create table `tp_member`(
    id int(4) not null primary key auto_increment,
    name char(20) not null,
    psw char(20) not null,
    `email` varchar(30),
    `add_time` varchar(25)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;


4.配置BootStrap到tp系统中。
bs文档：http://v3.bootcss.com/components/#dropdowns



5.订购管理系统。Order/index(),Order/add(),
不同数据库之间复制表的数据的方法：
当表目标表存在时：
	insert into 目的数据库..表 select * from 源数据库..表  
当目标表不存在时：
	select * into 目的数据库..表 from 源数据库..表


CREATE TABLE MyCMS.tp_order (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_name` varchar(50) NOT NULL COMMENT '名字',
  `order_unit` varchar(5) DEFAULT '单位' COMMENT '单位',
  `order_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `order_price` int(10) NOT NULL DEFAULT '0' COMMENT '单价',
  `order_note` text COMMENT '备注',
  `order_time` varchar(30) DEFAULT NULL COMMENT '订单时间',
  `add_time` varchar(30) DEFAULT NULL COMMENT '添加时间',
  `modi_time` varchar(30) DEFAULT NULL COMMENT '修改时间',
  `supplier_id` int(10) DEFAULT NULL COMMENT '供应商id',
  `order_status` int(10) DEFAULT NULL COMMENT '状态：0表示订货，1表示到货，2表示对账，3.表示报销过',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8;

insert into mycms.tp_order select * from think.think_order;


CREATE TABLE MyCMS.tp_supplier(
  `supplier_id` int(10) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) NOT NULL COMMENT '供应商名字',
  `supplier_url` text COMMENT '网址',
  `supplier_phone` varchar(25) DEFAULT NULL COMMENT '电话',
  `supplier_QQ` varchar(25) DEFAULT NULL COMMENT 'QQ',
  `supplier_email` varchar(25) DEFAULT NULL COMMENT 'email',
  `supplier_person` varchar(10) DEFAULT '暂无' COMMENT '联系人',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

insert into mycms.tp_supplier select * from think.think_supplier;


这个为什么是2个点号？
 insert   库2..表2   select   字段1，字段2   from   库1..表1　where 条件

===========================
	//todo
	弹出层怎么搞？
	怎么防止iframe内嵌套打开？
	怎么分页
===========================
5.2 实现 Order/del().

ajax删除：http://www.thinkphp.cn/topic/8988.html
bootstrap弹出框： http://www.jb51.net/article/76013.htm

5.3 修改title，修改add()页js小数点。
5.4 del()删后toast式通知。
===============================
	添加toast效果：https://github.com/CodeSeven/toastr
	// Display a warning toast, with no title
	toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!')
	
	// Display a success toast, with a title
	toastr.success('Have fun storming the castle!', 'Miracle Max Says')
	
	// Display an error toast, with a title
	toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
	
	// Clears the current list of toasts
	toastr.clear()

	更多通知效果：https://www.oschina.net/news/57207/best-jquery-notification-plugins
	“zebra_dialog居然没推荐，不管是常规模式样式，还是扁平样式的都很漂亮，很好用”
===============================


5.5 删除使用bootbox提示。添加订单状态，显示是否已经报销。添加按钮。
==========================================
Bootbox.js： https://github.com/makeusabrew/bootbox

alert
bootbox.alert(message, callback)

prompt
bootbox.prompt(message, callback)

confirm
bootbox.confirm(message, callback)

Each of these three functions calls a fourth public function which you too can use to create your own custom dialogs:
bootbox.dialog(options)
==========================================

bootbox.confirm({
    title: "Destroy planet?",
    message: "Do you want to activate the Deathstar now? This cannot be undone.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
        }
    },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result);
    }
});


//修改toast看不到问题：
http://blog.csdn.net/wk313753744/article/details/40394583/
<style>
	.toast-top-center {	top: 40px;}
</style>


CREATE TABLE `tp_order` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_name` varchar(50) NOT NULL COMMENT '名字',
  `order_unit` varchar(5) DEFAULT '单位' COMMENT '单位',
  `order_quantity` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `order_price` int(10) NOT NULL DEFAULT '0' COMMENT '单价',
  `order_note` text COMMENT '备注',
  `order_time` varchar(30) DEFAULT NULL COMMENT '订单时间',
  `add_time` varchar(30) DEFAULT NULL COMMENT '添加时间',
  `modi_time` varchar(30) DEFAULT NULL COMMENT '修改时间',
  `supplier_id` int(10) DEFAULT NULL COMMENT '供应商id',
  `order_status` int(10) DEFAULT NULL COMMENT '状态：0表示订货，1表示到货，2表示对账，3.表示报销过',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8


5.6 jq全选、反选
checkbox标签已有checked=checked但是不显示勾选？不用attr，使用prop

$(function() {
	//全选
	$("#chk_all").click(function(){
	     $("input[name='chk_list']").prop("checked",true);
	});
	
	//反选
	$("#chk_invert2").click(function(){
        $("input[name='chk_list']:checkbox").each(function(i,o){
            $(o).prop("checked",!$(o).prop("checked"));
        });
    });
});

 
==============================
//调试：输出变量到文件。
function mylog($some){
	file_put_contents('backup/log.txt',var_export($some,true));
}
==============================

5.8 Order/edit(),

5.9 添加统计结果。
http://www.cnblogs.com/zeroone/archive/2013/08/04/3236022.html
http://blog.csdn.net/ACMAIN_CHM/article/details/4283943

5.9.1 统计
公司id=0表示其他。
更新order表。不用。。。
修改add，edit代码。只有view去掉一行。

todo//还缺少小结功能。








