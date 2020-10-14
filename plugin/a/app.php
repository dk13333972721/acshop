<?php

//namespace app\event;

use think\facade\Config;
/**
 * 你可以在这个闭包的参数列表中使用类型提示
 * Laravel 会自动从容器中解析出对应的依赖并自动注入
 * 使用依赖注入之前你首先需要了解 Laravel 的服务容器机制
 *
 * 在这个闭包里你可以做任何准备工作，所有的代码都会在请求被处理之前执行
 * 包括不限于动态修改 config、修改 option、监听事件、绑定对象至服务容器等
 *
 * @see  https://laravel-china.org/docs/5.1/container
 */

return function () {
//return function Hook() {
	$sst = 1;
	// 批量设置参数
	Config::set(['a' => ''], 'plugins_menu');

   print_r(66666);

    /**
     * 创建订单
     * OrderCreatedListener
     */
    //$events->subscribe(AcShop\a\index::class);
   

};
