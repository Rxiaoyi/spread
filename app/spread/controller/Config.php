<?php

namespace app\spread\controller;

use think\admin\Controller;

/**
 * 应用参数配置
 * Class Config
 * @package app\spread\controller
 */
class Config extends Controller {

   /**
    * 下载单价规则
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function price() {
      $this->skey = 'price';
      $this->title = '下载单价规则';
      $this->__sysdata('price');
   }


   /**
    * 投放规则
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function release() {
      $this->skey = 'release';
      $this->title = '投放规则';
      $this->__sysdata('release');
   }

   /**
    * 投放规则
    * @auth true
    * @menu true
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public function account() {
      $this->skey = 'account';
      $this->title = '对公账户';
      $this->__sysdata('account');
   }




   /**
    * 显示并保存数据
    * @param string $template 模板文件
    * @param string $history 跳转处理
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   private function __sysdata(string $template, string $history = '') {
      if ($this->request->isGet()) {
         $this->data = sysdata($this->skey);
         $this->fetch($template);
      }
      if ($this->request->isPost()) {
         if (is_string(input('data'))) {
            $data = json_decode(input('data'), true) ?: [];
         } else {
            $data = $this->request->post();
         }
         if (sysdata($this->skey, $data) !== false) {
            $this->success('内容保存成功！', $history);
         } else {
            $this->error('内容保存失败，请稍候再试!');
         }
      }
   }
}
