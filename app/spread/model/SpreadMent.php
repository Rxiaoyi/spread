<?php

namespace app\spread\model;

use think\admin\extend\DataExtend;
use think\admin\Model;

/**
 * 结算单管理
 * Class SpreadMent
 * @package app\spread\model
 */
class SpreadMent extends Model
{


    /**
     * 获取单条业务数据
     * @param $androidId
     * @return SpreadCategory|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getInfo($androidId)
    {
        $map = ['id' => $androidId];
        return static::mk()->where($map)->order('id desc')->field('id,name,icon,packageName')->find();
    }

    /**
     * 获取单条业务数据
     * @param $userId
     * @return SpreadCategory|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getList($userId)
    {
        $map = ['user_id' => $userId, 'status' => 0];
        return static::mk()->where($map)->order('id desc')->field('id,code,amount,month')->select();
    }

    /**
     * @param $ids
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function checkInvoiceStatus($ids)
    {
        $invoiceList = static::mk()->where('id', 'in', implode(',', $ids))->field('id')->select();
        foreach ($invoiceList as $item) {
            $item->save(['status' => 1]);
        }
    }

    /**
     * 计算开票金额
     * @param $ids
     * @return float
     */
    public static function getAmount($ids): float
    {
        return static::mk()->where('id', 'in', implode(',', $ids))->sum('amount');
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
