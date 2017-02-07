bootstrap和thinkPHP结合做后台管理


=============================================
bootstrap:I:\xampp\htdocs\bootstrap
thinkPHP:I:\xampp\htdocs\think\ThinkPHP

I:\BaiduYunDownload\PHP
=============================================

1.配制环境、配制域名
//my.dawneve.com

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

2.重新熟悉一下框架细节。
看到6 路由。












