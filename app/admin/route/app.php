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
// | DateTime：2020-10-19 14:56:20
// +----------------------------------------------------------------------
use think\facade\Route;

/**
 * /admin/plugins.a-index-index-index
 */
Route::rule('plugins.<p1>-<p2>-<p3>-<p4>','AcShop\plugin\<p1>\admin\<p2>\<p3>@<p4>');

/**
 * /admin/plugins.a-index-index/index
 */
Route::rule('plugins.<p1>-<p2>-<p3>/<p4>','AcShop\plugin\<p1>\admin\<p2>\<p3>@<p4>');


