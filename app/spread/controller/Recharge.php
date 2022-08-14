<?php

namespace app\spread\controller;

use app\spread\model\SpreadCompany;
use app\spread\model\SpreadRecharge;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;
use think\admin\Library;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 充值记录管理
 * Class Recharge
 * @package app\spread\controller
 */
class Recharge extends Controller
{

    /**
     * 充值记录
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '充值记录';
        $query = SpreadRecharge::mQuery();
        if (Library::$sapp->session->get('user.usertype', '') === 1) {
            $query->where(['user_id' => AdminService::getUserId()]);
        }
        $query->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('id desc')->page();
    }


    /**
     * 充值记录
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function admin()
    {
        $this->title = '充值记录';
        $query = SpreadRecharge::mQuery();
        if (Library::$sapp->session->get('user.usertype', '') === 1) {
            $query->where(['user_id' => AdminService::getUserId()]);
        }
        $query->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('id desc')->page();
    }


    /**
     * 列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _admin_page_filter(array &$data)
    {
        foreach ($data as &$item) {
            $user = SystemUser::mk()->where(['id' => $item['user_id']])->field('nickname,username')->find();
            $item['companyName'] = $user['nickname'];
            $item['companyMobile'] = $user['username'];
            $item['companyBalance'] = $user['balance'];
        }
    }

    /**
     * 添加企业应用
     * @auth true
     */
    public function add()
    {
        SpreadRecharge::mForm('form');
    }

    /**
     * 编辑企业应用
     * @auth true
     */
    public function edit()
    {
        SpreadRecharge::mForm('form');
    }


    public function toTransfer()
    {
        if ($this->request->isPost()) {
            [$post] = [$this->request->post()];
            if ((int)$post['amount'] !== (int)$post['amount2']) {
                $this->error('两次金额不一致', '', 400);
            }
            SpreadRecharge::create([
                'code' => CodeExtend::uniqidNumber(20, 'G'),
                'amount' => $post['amount'],
                'user_id' => $post['user_id'],
                'status' => 4,
                'type' => 1,
            ]);
            $this->error('提交成功，等待审核', '', 200);
        }
    }

    public function confirmBalance()
    {
        if ($this->request->isPost()) {
            [$post] = [$this->request->post()];
            $code = $post['code'];
            $status = $post['status'];
            $recharge = SpreadRecharge::getInfo($code);
            if ((int)$status === 5) {
                $user = SystemUser::mk()->where(['id' => $recharge['user_id']])->field('total,balance')->find();
                $user->save(['total' => $user['total'] + $recharge['amount'], 'balance' => $user['balance'] + $recharge['amount']]);
                $recharge->save(['status' => $status, 'balance' => $recharge['balance']]);
            }
            $this->success('操作成功', '', 1);
        }
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
        $user = SystemUser::mk()->find(AdminService::getUserId());
        $data['name'] = $user['nickname'];
        $data['user_id'] = $user['id'];
        $opt = sysdata('account');
        $data['companyName'] = $opt['company'];
        $data['accountBank'] = $opt['bank'];
        $data['account'] = $opt['account'];
    }

    /**
     * 修改企业应用状态
     * @auth true
     */
    public function state()
    {
        SpreadRecharge::mSave($this->_vali([
            'status.in:0,1,2,3,4,5' => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除企业应用
     * @auth true
     */
    public function remove()
    {
        SpreadRecharge::mDelete();
    }
}
