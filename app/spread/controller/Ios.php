<?php

namespace app\spread\controller;

use app\spread\model\SpreadAndroid;
use app\spread\model\SpreadCategory;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;
use think\admin\Library;
use think\admin\model\SystemUser;
use think\admin\service\AdminService;

/**
 * Ios管理
 * Class Ios
 * @package app\spread\controller
 */
class Ios extends Controller {
   /**
    * Android管理
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function index() {

      $this->title = 'IOS应用管理';
      $query = SpreadAndroid::mQuery();
      if (Library::$sapp->session->get('user.usertype', '') === 1) {
         $query->where(['user_id' => AdminService::getUserId()]);
      }
      $query->like('name')->equal('status')->dateBetween('create_at');
      $query->where(['deleted' => 0])->order('id desc')->page();
   }

   /**
    * Android管理
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function admin() {
      $this->title = 'IOS应用管理';
      $query = SpreadAndroid::mQuery();
      $query->like('name')->equal('status')->dateBetween('create_at');
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
    * 列表数据处理
    * @param array $data
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   protected function _admin_page_filter(array &$data) {
      foreach ($data as &$item) {
         $user = SystemUser::mk()->where(['id' => $item['user_id']])->field('nickname,username')->find();
         $item['companyName'] = $user['nickname'];
         $item['companyMobile'] = $user['username'];
      }
   }

   /**
    * 拒绝添加内容
    * @auth true
    */
   public function refuse() {
      SpreadAndroid::mForm('refuse');
   }

   /**
    * 添加IOS应用
    * @auth true
    */
   public function add() {
      SpreadAndroid::mForm('form');
   }

   /**
    * 编辑IOS应用
    * @auth true
    */
   public function edit() {
      SpreadAndroid::mForm('form');
   }

   /**
    * 上传资质
    * @auth true
    */
   public function intelligence() {
      SpreadAndroid::mForm('intelligence');
   }

   /**
    * 重排重入库
    * @auth true
    */
   public function files() {
      SpreadAndroid::mForm('files');
   }

   /**
    * 表单数据处理
    * @param array $data
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   protected function _form_filter(array &$data) {
      if ($this->request->isPost()) {
         if (Library::$sapp->session->get('user.usertype', '') === 1) {
            $data['user_id'] = AdminService::getUserId();
         }
      }
   }

   /**
    * 修改IOS应用状态
    * @auth true
    */
   public function state() {
      SpreadAndroid::mSave($this->_vali([
         'status.in:0,1,2' => '状态值范围异常！',
         'status.require' => '状态值不能为空！',
      ]));
   }

   /**
    * 删除IOS应用
    * @auth true
    */
   public function remove() {
      SpreadAndroid::mDelete();
   }
}
