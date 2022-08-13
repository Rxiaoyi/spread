<?php

namespace app\spread\controller;

use app\spread\model\SpreadCompany;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

/**
 * 企业管理
 * Class Company
 * @package app\spread\controller
 */
class Company extends Controller
{

    /**
     * 企业管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '企业管理';
        $query = SystemUser::mQuery();
        $query->like('nickname')->equal('status')->dateBetween('create_at');
        $query->where(['is_deleted' => 0, 'usertype' => 1])->order('id desc')->page();
    }


    /**
     * 我的账户
     * @auth true
     * @menu true
     */
    public function balance()
    {
        $company = SystemUser::mk()->find(AdminService::getUserId());
        $this->company = $company;
        SystemUser::mForm('balance');
    }


    /**
     * 列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(array &$data)
    {

    }

    /**
     * 添加企业应用
     * @auth true
     */
    public function add()
    {
        SystemUser::mForm('form');
    }

    /**
     * 编辑企业应用
     * @auth true
     */
    public function edit()
    {
        SystemUser::mForm('form');
    }

    /**
     * 修改密码
     * @auth true
     * @menu true
     */
    public function editPassword()
    {
        if ($this->request->isGet()) {
            SystemUser::mForm('editPassword');
        } else {
            $data = $this->_vali([
                'password.require' => '新密码不能为空！',
                'repassword.require' => '重复密码不能为空！',
                'repassword.confirm:password' => '两次输入的密码不一致！',
            ]);
            $company = SystemUser::mk()->find(AdminService::getUserId());
            if (!empty($company) && $company->save(['password' => md5($data['password'])])) {
                $this->success('密码重置成功', '');
            } else {
                $this->error('密码重置失败，请稍候再试！');
            }
        }

    }


    /**
     * 重置密码
     * @auth true
     */
    public function password()
    {
        if ($this->request->isGet()) {
            SystemUser::mForm('password');
        } else {
            $data = $this->_vali([
                'id.require' => '用户ID不能为空！',
                'password.require' => '新密码不能为空！',
                'repassword.require' => '重复密码不能为空！',
                'repassword.confirm:password' => '两次输入的密码不一致！',
            ]);
            $company = SystemUser::mk()->find($data['id']);
            if (!empty($company) && $company->save(['password' => md5($data['password'])])) {
                $this->success('密码重置成功', '');
            } else {
                $this->error('密码重置失败，请稍候再试！');
            }
        }
    }

    /**
     * 下载单价
     * @auth true
     */
    public function price()
    {
        SystemUser::mForm('price');
    }

    /**
     * 上传资质
     * @auth true
     */
    public function intelligence()
    {
        SystemUser::mForm('intelligence');
    }

    /**
     * 重排重入库
     * @auth true
     */
    public function files()
    {
        SystemUser::mForm('files');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            if (isset($data['password'])) {
                $data['password'] = md5($data['password']);
            }
        }
    }

    /**
     * 修改企业应用状态
     * @auth true
     */
    public function state()
    {
        SystemUser::mSave($this->_vali([
            'status.in:0,1' => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除企业应用
     * @auth true
     */
    public function remove()
    {
        SystemUser::mDelete();
    }
}
