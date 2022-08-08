<?php

namespace app\spread\controller;

use app\spread\model\SpreadCompany;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * 企业管理
 * Class Company
 * @package app\spread\controller
 */
class Company extends Controller {

   /**
    * 企业管理
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function index() {

      $this->title = '企业管理';
      $query = SpreadCompany::mQuery();
      $query->like('name|packageName')->equal('status')->dateBetween('create_at');
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
      SpreadCompany::mForm('form');
   }

   /**
    * 编辑企业应用
    * @auth true
    */
   public function edit() {
      SpreadCompany::mForm('form');
   }

   /**
    * 重置密码
    * @auth true
    */
   public function password() {
      if ($this->request->isGet()) {
         SpreadCompany::mForm('password');
      } else {
         $data = $this->_vali([
            'id.require' => '用户ID不能为空！',
            'password.require' => '登录密码不能为空！',
            'repassword.require' => '重复密码不能为空！',
            'repassword.confirm:password' => '两次输入的密码不一致！',
         ]);
         $company = SpreadCompany::mk()->find($data['id']);
         if (!empty($company) && $company->save(['password' => md5($data['password'])])) {
            $this->success('密码重置成功', '');
         } else {
            $this->error('密码重置失败，请稍候再试！');
         }
      }
   }

   /**
    * 上传资质
    * @auth true
    */
   public function intelligence() {
      SpreadCompany::mForm('intelligence');
   }

   /**
    * 重排重入库
    * @auth true
    */
   public function files() {
      SpreadCompany::mForm('files');
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
      SpreadCompany::mSave($this->_vali([
         'status.in:0,1' => '状态值范围异常！',
         'status.require' => '状态值不能为空！',
      ]));
   }

   /**
    * 删除企业应用
    * @auth true
    */
   public function remove() {
      SpreadCompany::mDelete();
   }
}
