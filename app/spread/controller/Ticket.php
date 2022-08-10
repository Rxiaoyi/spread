<?php

namespace app\spread\controller;

use app\spread\model\SpreadRecharge;
use app\spread\model\SpreadTicket;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * 开票信息管理
 * Class Recharge
 * @package app\spread\controller
 */
class Ticket extends Controller {

   /**
    * 企业管理
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function index() {
      $this->title = '开票信息';
      $query = SpreadTicket::mQuery();
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
   protected function _index_page_filter(array &$data) {

   }

   /**
    * 添加企业应用
    * @auth true
    */
   public function add() {
      SpreadTicket::mForm('form');
   }

   /**
    * 编辑企业应用
    * @auth true
    */
   public function edit() {
      SpreadTicket::mForm('form');
   }

   /**
    * 表单数据处理
    * @param array $data
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   protected function _form_filter(array &$data) {

   }

   /**
    * 修改企业应用状态
    * @auth true
    */
   public function state() {
      SpreadTicket::mSave($this->_vali([
         'status.in:0,1' => '状态值范围异常！',
         'status.require' => '状态值不能为空！',
      ]));
   }

   /**
    * 删除企业应用
    * @auth true
    */
   public function remove() {
      SpreadTicket::mDelete();
   }
}