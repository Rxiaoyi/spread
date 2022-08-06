<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 安卓应用管理
 * Class SpreadAndroid
 * @package app\spread\model
 */
class SpreadAndroid extends Model
{


    /**
     * 格式化创建时间
     * @param string $value
     * @return string
     */
    public function getCreateAtAttr(string $value): string
    {
        return format_datetime($value);
    }
}