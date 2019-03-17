1 新建主文件 index.php
2 根目录下建立文件夹并引入 smarty
3 创建核心处理文件夹 include
4 在核心文件夹下创建配置文件 include/config.php
5 在核心文件夹下创建通用方法文件 include/function.php
6 建立前台控制器文件夹 index
7 建立模板文件夹 templates/default
8 在前台控制器文件夹中 创建前台通用包含文件 index/basic.func.php
9 在模板文件夹中  创建模板前台文件夹 templates/default/index
10 在前台模板文件夹中创建首页模板 templates/default/index/index.php
11 在basic.func.php中
    （1）创建全局变量 $globals $smarty
	（2）声明主方法main方法 并在main方法中 引用自定义控制器方法controller
	（3）通过 set_more_global 方法 得到当前页的相关全局变量
12 在通用方法文件中
	（1）声明set_global方法来设置全局变量数组
	（2）声明get_global(a,b)方法,声明一个全局数组$globals,通过判断是否存在此全局变量$globals[a]，有则使用，没有就默认定义$globals[a]=b
13 通过通用方法中的controller方法 引入首页控制文件index.php
14 在首页控制文件 index.php 中引入smarty和common.func.php文件
15 在common.func.php文件中定义三个方法
	（1）set_smarty 声明全局变量$smarty 并设置smarty的相关路径 模板路径 编译路径 缓存路径
	（2）initial 定义模板中的数据及变量
	（3）creathtml 静态文件生成
	