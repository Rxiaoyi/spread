<?php

namespace app\spread\controller;

use app\spread\model\SpreadInvoicing;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * 开票记录管理
 * Class Recharge
 * @package app\spread\controller
 */
class Invoicing extends Controller {

   /**
    * 充值记录
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function index() {
      $this->title = '充值记录';
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
   protected function _index_page_filter(array &$data) {

   }

   /**
    * 添加开票记录
    * @auth true
    */
   public function add() {
      SpreadInvoicing::mForm('form');
   }

   /**
    * 编辑企业应用
    * @auth true
    */
   public function edit() {
      SpreadInvoicing::mForm('form');
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
      SpreadInvoicing::mSave($this->_vali([
         'status.in:0,1' => '状态值范围异常！',
         'status.require' => '状态值不能为空！',
      ]));
   }

   /**
    * 删除企业应用
    * @auth true
    */
   public function remove() {
      SpreadInvoicing::mDelete();
   }
}
