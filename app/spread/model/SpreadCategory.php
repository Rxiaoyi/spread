<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 安卓分类管理
 * Class SpreadCategory
 * @package app\spread\model
 */
class SpreadCategory extends Model
{


    public static function getList(): array
    {
        $query = static::mk()->where(['deleted' => 0]);
        return $query->field('id,name')->order('id desc')->select()->toArray();
    }


    /**
     * 获取单条业务数据
     * @param $businessId
     * @return SpreadCategory|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getInfo($businessId)
    {
        $map = ['id' => $businessId];
        return static::mk()->where($map)->order('id desc')->field('id,name')->find();
    }


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