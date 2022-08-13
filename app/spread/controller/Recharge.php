<?php

namespace app\spread\controller;

use app\spread\model\SpreadCompany;
use app\spread\model\SpreadRecharge;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

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
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$item) {
            $company = SpreadCompany::getInfo($item['company_id']);
            $item['companyName'] = $company['name'];
            $item['companyMobile'] = $company['mobile'];
            $item['companyBalance'] = $company['balance'];
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
        SpreadRecharge::mDelete();
    }
}
