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
}
