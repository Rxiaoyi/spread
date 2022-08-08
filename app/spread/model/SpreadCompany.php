<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 企业管理
 * Class SpreadCompany
 * @package app\spread\model
 */
class SpreadCompany extends Model {


    /**
     * 获取单条业务数据
     * @param $companyId
     * @return SpreadCategory|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getInfo($companyId)
    {
        $map = ['id' => $companyId];
        return static::mk()->where($map)->order('id desc')->field('id,name,mobile')->find();
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
