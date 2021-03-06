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
// | DateTime：2020-10-21 17:45:28
// +----------------------------------------------------------------------

use think\facade\Config;
use think\facade\Event;
use AcgCron\Cron;

return function () {
   //print_r("插件A启动<br>");
	// 设置插件
	Config::set(['ac_cron' => [
        'name' => '计划任务模块',
        'version' => '1.0.0',
        'description' => '常用计划任务管理模块',
        'author' => 'AcShop官方',
        'url' => 'https://oauth.acgice.com',
        'namespace' => 'AcShop\\plugin\\ac_cron',
        'admin' => 'index-index-index',//后台管理页面 留空就是没有
        ]], 'plugins_menu');

    // 例子：定时任务
    // Event::listen('cron.collectJobs', function($user) {
    //     Cron::add('acgice-plugin-a', '* * * * * *', function () {
    //         print_r('插件A的定时任务');
    //         return;
    //     });
    // });

    // 例子：禁止某个用户加入黑名单
    // Event::listen('MemberModify', function($arr) {
    //     if($arr['id'] == 1 && $arr['value'] == 0){
    //         api_return(0,"用户 ".$arr['id']." 不允许修改");
    //     }
    // });


};
