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
// | DateTime：2020-10-29 11:32:11
// +----------------------------------------------------------------------

namespace app\admin\controller\member;


use think\App;
use think\facade\Config;
use app\common\model\Member;
use app\common\controller\AdminController;

use EasyAdmin\annotation\ControllerAnnotation;
use EasyAdmin\annotation\NodeAnotation;

/**
 * Class User
 * @package app\admin\controller\member
 * @ControllerAnnotation(title="会员管理")
 */
class User extends AdminController
{

    use \app\admin\traits\Curd;

    protected $sort = [
        'id'   => 'desc',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->model = new Member();
    }

    /**
     * @NodeAnotation(title="列表")
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            if (input('selectFields')) {
                return $this->selectList();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $count = $this->model
                ->where($where)
                ->count();
            $list = $this->model
                ->withoutField('password')
                ->where($where)
                ->page($page, $limit)
                ->order($this->sort)
                ->select();
            $data = [
                'code'  => 0,
                'msg'   => '',
                'count' => $count,
                'data'  => $list,
            ];
            return json($data);
        }
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="添加账号")
     */
    public function add()
    {
        event('MemberAddStart');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'mobile|手机' => 'require|mobile|length:4,20',
                'password|密码' => 'require|alphaNum|length:4,20',
                'content|备注' => 'chsDash|length:1,100',
            ];
            $this->validate($post, $rule);

            $post['password'] = password($post['password']);
    
            event('MemberAdd',$post);
            try {
                $save = $this->model->save($post);
            } catch (\Exception $e) {
                $this->error('新增失败');
            }

            if($save){
               event('MemberAddEnd',$post);
            }


            $save ? $this->success('新增成功') : $this->error('新增失败');
        }

        $plugin = Config::get('memberadd');
        $this->assign('plugin',$plugin);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="编辑账号")
     */
    public function edit($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        event('MemberEditStart',$id);

        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [];
            $this->validate($post, $rule);
            event('MemberEdit',$post);
            try {
                $save = $row->save($post);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
               event('MemberEditEnd',$post);
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $plugin = Config::get('memberedit');
        $this->assign('plugin',$plugin);
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="修改推荐人")
     */
    public function parent($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'mobile|手机'       => 'require|mobile|length:4,20',
            ];
            $this->validate($post, $rule);
            if($post['mobile'] == $row['mobile']){$this->error('不能设置自己为自己的上级');}
            $rows = $this->model->where('mobile',$post['mobile'])->find();
            $rows->isEmpty() && $this->error('数据不存在');

            event('MemberParent',array(
                'id' => $id,
                'parent' => $row['parent_id'],
                'new' => $rows['id'],
                ));

            try {
                $save = $row->save([
                    'parent_id' => $rows['id'],
                ]);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
                event('MemberParentEnd',array(
                    'id' => $id,
                    'parent' => $row['parent_id'],
                    'new' => $rows['id'],
                    ));
            }

            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="修改密码")
     */
    public function password($id)
    {
        $row = $this->model->find($id);
        $row->isEmpty() && $this->error('数据不存在');
        if ($this->request->isAjax()) {
            $post = $this->request->post();
            $rule = [
                'password|登录密码'       => 'require|alphaNum|length:4,20',
                'password_again|确认密码' => 'require|alphaNum|length:4,20',
            ];
            $this->validate($post, $rule);
            if ($post['password'] != $post['password_again']) {
                $this->error('两次密码输入不一致');
            }
            $post['id'] = $id;
            event('MemberPassword',$post);
            try {
                $save = $row->save([
                    'password' => password($post['password']),
                ]);
            } catch (\Exception $e) {
                $this->error('保存失败');
            }
            if($save){
                event('MemberPasswordEnd',$post);
            }
            $save ? $this->success('保存成功') : $this->error('保存失败');
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
    /**
     * @NodeAnotation(title="删除")
     */
    public function delete($id)
    {
        $row = $this->model->whereIn('id', $id)->select();
        $row->isEmpty() && $this->error('数据不存在');
        event('MemberDelete',$id);
        try {
            $save = $row->delete();
        } catch (\Exception $e) {
            $this->error('删除失败');
        }
        if($save){
            event('MemberDeleteEnd',$id);
        }
        $save ? $this->success('删除成功') : $this->error('删除失败');
    }
    /**
     * @NodeAnotation(title="属性修改")
     */
    public function modify()
    {
        $post = $this->request->post();
        $rule = [
            'id|ID'    => 'require',
            'field|字段' => 'require',
            'value|值'  => 'require',
        ];
        $this->validate($post, $rule);

        if (!in_array($post['field'], $this->allowModifyFileds)) {
            $this->error('该字段不允许修改：' . $post['field']);
        }
        $row = $this->model->find($post['id']);
        empty($row) && $this->error('数据不存在');
        event('MemberModify',$post);
        try {
            $row->save([
                $post['field'] => $post['value'],
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        event('MemberModifyEnd',$post);
        $this->success('保存成功');
    }
}
