<?php

namespace app\data\model;

use app\data\service\RebateService;
use think\admin\Model;

/**
 * 用户等级配置模型
 * Class BaseUserUpgrade
 * @package app\data\model
 */
class BaseUserUpgrade extends Model
{
    /**
     * 获取用户等级
     * @return array
     */
    public static function items(): array
    {
        return static::mk()->where(['status' => 1])
            ->hidden(['id', 'utime', 'status', 'create_at'])
            ->order('number asc')->column('*', 'number');
    }

    /**
     * 获取最大级别数
     * @return int
     */
    public static function maxNumber(): int
    {
        return static::mk()->max('number', 0) + 1;
    }

    /**
     * 规格化奖励配置
     * @param mixed $value
     * @return array
     */
    public function getRebateRuleAttr($value): array
    {
        [$data, $rules] = [[], array_column(RebateService::PRIZES, 'code')];
        foreach (is_string($value) ? str2arr($value, ',', $rules) : [] as $rule) {
            $data[$rule] = RebateService::name($rule);
        }
        return $data;
    }

    /**
     * 格式化奖励配置
     * @param mixed $value
     * @return string
     */
    public function setRebateRuleAttr($value): string
    {
        return is_array($value) ? arr2str($value) : $value;
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