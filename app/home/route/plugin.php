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
// | DateTime：2020-10-19 14:58:00
// +----------------------------------------------------------------------
use think\facade\Route;

// Route::get('think', function () {
//     return 'hello,ThinkPHP6!';
// });

//Route::get('hello/:name', 'index/hello');

//Route::rule('plugin','app\api\controller\Index@index

// 绑定到类
/**
 * plugin.a-index-index-index    或者 home/ 都可以
 */
Route::rule('plugin.<p1>-<p2>-<p3>-<p4>','AcShop\plugin\<p1>\api\<p2>\<p3>@<p4>');

// Route::rule('plugin.<p1>-<p2>-<p3>-<p4>', function ($p1,$p2,$p3,$p4) {
// 	print_r($p1);
// 	print_r($p2);
// 	print_r($p3);
// 	print_r($p4);
// });

// plugin.orz-s1hop.api.Shop.banner
// Route::rule('plugin.<action>', function ($action) {
// 	//print_r($action);
// 	$url = explode(".",$action);
// 	//$code = "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2]."::".$url[3];
// 	$code = "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2];
	
// 	eval('$con = new '.$code.";");
// 	print_r($con);
// 	//print_r (explode(".",$action));
// 	//return "AcShop\plugin\\".$url[0]."\\src\\".$url[1]."\\".$url[2]."@".$url[3];
// });
//  plugin/a.index.index.index