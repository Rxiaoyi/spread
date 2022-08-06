<?php


namespace app\spread\controller;

use app\spread\model\SpreadAndroid;
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
        $query = SpreadAndroid::mQuery();
        $query->like('name|packageName')->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('id desc')->page();
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
//            $business = SpreadCategory::getInfo($item['categoryId']);
//            $item['categoryName'] = $business['name'];
        }
    }

    /**
     * 添加安卓应用
     * @auth true
     */
    public function add()
    {
        SpreadAndroid::mForm('form');
    }

    /**
     * 编辑安卓应用
     * @auth true
     */
    public function edit()
    {
        SpreadAndroid::mForm('form');
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
            $this->category = SpreadCategory::getList();
        }
    }

    /**
     * 修改安卓应用状态
     * @auth true
     */
    public function state()
    {
        SpreadAndroid::mSave($this->_vali([
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
        SpreadAndroid::mDelete();
    }
}