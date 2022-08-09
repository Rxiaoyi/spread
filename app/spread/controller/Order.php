<?php


namespace app\spread\controller;

use app\spread\model\SpreadAndroid;
use app\spread\model\SpreadCompany;
use app\spread\model\SpreadOrder;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * 订单管理
 * Class Cate
 * @package app\spread\controller
 */
class Order extends Controller
{


    /**
     * 订单管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {

        $this->title = '订单管理';
        $query = SpreadOrder::mQuery();
        $query->like('sn')->equal('status|android')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _page_filter(array &$data)
    {
        $this->android = SpreadAndroid::items();
    }


    /**
     * 列表数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$item) {
            $android = SpreadAndroid::getInfo($item['android_id']);
            $item['androidName'] = $android['name'];
            $item['androidIcon'] = $android['icon'];
            $item['androidPackageName'] = $android['packageName'];
            $company = SpreadCompany::getInfo($item['company_id']);
            $item['companyName'] = $company['name'];
            $item['companyMobile'] = $android['mobile'];
        }
    }

    /**
     * 添加安卓应用
     * @auth true
     */
    public function add()
    {
        SpreadOrder::mForm('form');
    }

    /**
     * 编辑安卓应用
     * @auth true
     */
    public function edit()
    {
        SpreadOrder::mForm('form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isGet()) {
            $this->android = SpreadAndroid::items();
        }
    }

    /**
     * 修改安卓应用状态
     * @auth true
     */
    public function state()
    {
        SpreadOrder::mSave($this->_vali([
            'status.in:0,1' => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除安卓应用
     * @auth true
     */
    public function remove()
    {
        SpreadOrder::mDelete();
    }
}
