<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * IOS应用管理
 * Class SpreadAndroid
 * @package app\spread\model
 */
class SpreadIos extends Model {

   /**
    * 获取单条业务数据
    * @param $androidId
    * @return SpreadCategory|array|mixed|\think\Model|null
    * @throws \think\db\exception\DataNotFoundException
    * @throws \think\db\exception\DbException
    * @throws \think\db\exception\ModelNotFoundException
    */
   public static function getInfo($androidId) {
      $map = ['id' => $androidId];
      return static::mk()->where($map)->order('id desc')->field('id,name,icon')->find();
   }

   /**
    * 获取所有应用
    * @return array
    */
   public static function items(): array {
      $map = ['status' => 1];
      return static::mk()->where($map)->order('id desc')->column('id,name');
   }

   /**
    * 格式化创建时间
    * @param string $value
    * @return string
    */
   public function getCreateAtAttr(string $value): string {
      return format_datetime($value);
   }
}
