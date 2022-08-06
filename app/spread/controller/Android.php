<?php


namespace app\spread\controller;

use app\spread\model\SpreadAndroid;
use app\spread\model\SpreadCategory;
use think\admin\Controller;
use think\admin\extend\DataExtend;
use think\admin\helper\QueryHelper;

/**
 * Android管理
 * Class Cate
 * @package app\data\controller\shop
 */
class Android extends Controller
{
    /**
     * 最大级别
     * @var integer
     */
    protected $maxLevel = 5;

    /**
     * Android管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {

        $this->title = '安卓应用管理';
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
            $business = SpreadCategory::getInfo($item['categoryId']);
            $item['categoryName'] = $business['name'];
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
     * 上传资质
     * @auth true
     */
    public function intelligence()
    {
        SpreadAndroid::mForm('intelligence');
    }


    /**
     * 重排重入库
     * @auth true
     */
    public function files()
    {
        SpreadAndroid::mForm('files');
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