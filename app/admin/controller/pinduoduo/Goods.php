<?php


namespace app\admin\controller\pinduoduo;

use app\admin\controller\AuthController;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;
use app\admin\model\pinduoduo\PinduoduoStore as sModel;
use app\Request;
use learn\utils\Curl;
use think\facade\Cache;
use think\facade\Session;
use learn\services\UtilService as Util;

/**
 * 商品信息
 * Class Goods
 * @package app\admin\controller\pinduoduo
 */
class Goods extends AuthController
{
    /**
     * 商品列表
     * @return string|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $store = sModel::isBingInfo($this->adminId);
        if (!$store) $this->assign("isBind",false);
        else
        {
            if (!authIsExit($this->adminId))
            {
                $provider = pModel::get($store['pid']);
                if (!$provider)
                {
                    $this->assign("isBind",true);
                    $this->assign("provider",$provider);
                }
                else
                {
                    Session::set("provider",$provider);
                    return $this->redirect("https://mms.pinduoduo.com/open.html?response_type=code&client_id={$provider['client_id']}&redirect_uri=http://learn.leapy.cn/admin/pinduoduo.authorization/accessauth&state=2000");
                }
            }else $this->assign("isBind",true);
        }
        return $this->fetch();
    }

    /**
     * 商品列表
     * @param Request $request
     * @return
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['goods_name',''],
            ['is_onsale',''],
            ['page',1],
            ['limit',20],
        ]);
        if ($where['goods_name'] == '') unset($where['goods_name']);
        if ($where['is_onsale'] == '') unset($where['is_onsale']);
        $where['page_size'] = $where['limit'];
        unset($where['limit']);
        $where['type'] = 'pdd.goods.list.get';
        $provider = (sModel::getProviderInfo($this->adminId)->toArray())['provider'];
        $token = Cache::store('redis')->get('store_'.$this->adminId);
        $where['client_id'] = $provider['client_id'];
        $where['access_token'] = $token['access_token'];
        $where['timestamp'] = time();
        $where['data_type'] = 'JSON';
        $data = json_decode(Curl::app("https://gw-api.pinduoduo.com/api/router","POST",json_encode($where))->header(["Content-Type:application/json"])->buildSign($provider['client_secret'])->run(),true);
        $res['data'] = $data['goods_list_get_response']['goods_list'];
        $res['count'] = $data['goods_list_get_response']['total_count'];
        return app("json")->layui($res);
    }
}