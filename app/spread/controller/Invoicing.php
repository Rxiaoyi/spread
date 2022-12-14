<?php

namespace app\spread\controller;

use app\spread\model\SpreadCompany;
use app\spread\model\SpreadInvoicing;
use app\spread\model\SpreadMent;
use app\spread\model\SpreadTicket;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;
use think\admin\Library;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

/**
 * 开票记录管理
 * Class Invoicing
 * @package app\spread\controller
 */
class Invoicing extends Controller
{

    /**
     * 开票记录
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '发票记录';
        $query = SpreadInvoicing::mQuery();
        if (Library::$sapp->session->get('user.usertype', '') === 1) {
            $query->where(['user_id' => AdminService::getUserId()]);
        }
        $query->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('id desc')->page();
    }


    /**
     * 后台开票记录
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function admin()
    {
        $this->title = '开票记录';
        $query = SpreadInvoicing::mQuery();
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
            $ticket = SpreadTicket::getInfo($item['ticket_id']);
            $item['invoice'] = $ticket['invoice'];
            $item['type'] = $ticket['type'];
            $item['collector'] = $ticket['collector'];
            $item['mobile'] = $ticket['mobile'];
            $item['address'] = $ticket['address'];
            $user = SystemUser::mk()->find($item['user_id']);
            $item['companyName'] = $user['nickname'];
            $item['companyMobile'] = $user['username'];
        }
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
            $ticket = SpreadTicket::getInfo($item['ticket_id']);
            $item['invoice'] = $ticket['invoice'];
            $item['type'] = $ticket['type'];
            $item['collector'] = $ticket['collector'];
            $item['mobile'] = $ticket['mobile'];
            $item['address'] = $ticket['address'];
            $user = SystemUser::mk()->find($item['user_id']);
            $item['companyName'] = $user['nickname'];
            $item['companyMobile'] = $user['username'];
        }
    }

    public function createInvoicing()
    {
        if ($this->request->isPost()) {
            [$post] = [$this->request->post()];
            $amount = SpreadMent::getAmount($post['orderIds']);
            SpreadInvoicing::create([
                'ticket_id' => $post['ticket_id'],
                'user_id' => AdminService::getUserId(),
                'hostIds' => $post['orderIds'],
                'amount' => $amount,
            ]);
            SpreadMent::checkInvoiceStatus($post['orderIds']);
            $this->success('操作成功', '', 200);
        }
    }

    /**
     * 添加开票记录
     * @auth true
     */
    public function add()
    {
        SpreadInvoicing::mForm('form');
    }

    /**
     * 编辑开票记录
     * @auth true
     */
    public function edit()
    {
        SpreadInvoicing::mForm('form');
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
            $data['status'] = 1;
        }
    }

    /**
     * 修改开票记录状态
     * @auth true
     */
    public function state()
    {
        SpreadInvoicing::mSave($this->_vali([
            'status.in:0,1' => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除开票记录
     * @auth true
     */
    public function remove()
    {
        SpreadInvoicing::mDelete();
    }
}
