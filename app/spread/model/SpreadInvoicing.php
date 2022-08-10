<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 开票记录管理
 * Class SpreadCompany
 * @package app\spread\model
 */
class SpreadInvoicing extends Model {

   /**
    * 格式化创建时间
    * @param string $value
    * @return string
    */
   public function getCreateAtAttr(string $value): string {
      return format_datetime($value);
   }
}
