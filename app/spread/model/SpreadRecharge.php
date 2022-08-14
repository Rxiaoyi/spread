<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 充值记录管理
 * Class SpreadCompany
 * @package app\spread\model
 */
class SpreadRecharge extends Model {
   
   /**
    * 格式化创建时间
    * @param string $value
    * @return string
    */
   public function getCreateAtAttr(string $value): string {
      return format_datetime($value);
   }


    /**
     * 获取单条业务数据
     * @param $code
     * @return SpreadCategory|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getInfo($code)
    {
        $map = ['code' => $code];
        return static::mk()->where($map)->order('id desc')->find();
    }
}
