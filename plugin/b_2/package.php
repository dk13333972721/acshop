<?php
// +----------------------------------------------------------------------
// | AcShop (Acgice商城)
// +----------------------------------------------------------------------
// | 团队官网: https://oauth.acgice.com
// +----------------------------------------------------------------------
// | 联系我们: https://oauth.acgice.com/sdk/contact.html
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/acshop
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/orzice/acshop
// +----------------------------------------------------------------------
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-10-19 14:59:34
// +----------------------------------------------------------------------

use think\facade\Config;
use think\facade\Event;
use AcgCron\Cron;


return function () {
    //print_r("插件B启动<br>");
	// 设置插件
	Config::set(['b_2' => [
        'name' => '插件B模块',
        'version' => '1.0.0',
        'description' => '测试插件B说明',
        'author' => '',
        'url' => '',
        'namespace' => 'AcShop\\plugin\\b_2',
        'permit' => 1,//如果不设置则不会做权限检测
        'menu' => 1,//如果不设置则不显示菜单，子菜单也将不显示
        'parents' => [],
        ]], 'plugins_menu');

	// 监听事件
	//Event::subscribe(AcShop\plugin\b\listener\index::class);
	
    Event::listen('cron.collectJobs', function($user) {
        Cron::add('acgice-plugin-b', '* * * * * *', function () {
            print_r('插件B的定时任务');
            return;
        });
    });


};
