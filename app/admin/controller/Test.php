<?php


namespace app\admin\controller;

use app\admin\model\mini\MiniVideo;
use app\admin\model\wechat\WechatNews;
use app\admin\model\wechat\WechatUser;
use app\api\model\user\UserOrder;
use app\models\user\UserBill;
use app\Request;
use learn\services\crawler\KanRankService;
use learn\services\crawler\KanService;
use learn\services\crawler\QQService;
use learn\services\ExcelService;
use learn\services\mail\MailService;
use learn\services\pay\PayService;
use learn\services\sms\QCloudSmsService;
use learn\services\storage\QcloudCoService;
use learn\services\WechatService;
use learn\utils\Curl;
use think\facade\Cache;

class Test extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = [];
    // 无需权限的
    protected $noNeedRight = [];

    public function index()
    {
//        https://www.360kan.com/ct/OUPkaZ7kNY7vDj.html
//        var_dump(KanService::app("OUPkaZ7kNY7vDj","dm")->message());
//        MiniVideo::updateVideoRank("tv");
//        var_dump(KanRankService::app("tv")->run());
//        MiniVideo::UpdateTimer();
//        $order = UserOrder::where("oid","O202005300921423654")->find()->toArray();
//        UserBill::addBill($order);
//        KanService::app("gKLoZBH5RnX0UB","movie")->message();
//        $data = KanService::app("PrNqb07lRGPnMX","tv")->message();
//        var_dump($data);
//        ExcelService::setHeader("订单导出",['订单编号','商品名称','商品规格']);
//        ExcelService::setHeader("订单导出",['订单id','订单号','电话','收货人姓名'])->setBody([[1,2,3,4],[1,2,3,4]])->save();
//        var_dump(WechatUser::select());
//        $res = PayService::app("wechat","scan")->pay([
//            'out_trade_no' => time(),
//            'body' => 'subject-测试',
//            'total_fee'      => '1',
//        ]);
//        var_dump($res);
//        $res = QCloudSmsService::app()->setPhoneNumbers(['18438622618'])->sendSingleSms(systemConfig("sms_login"),['123456'],"");
//        var_dump($res);
        //var_dump($sms->sendSingleSms(systemConfig("sms_login"),['123456'],""));
//        $wechat = SystemConfigMore(['wechat_appid','wechat_appsecret','wechat_token','wechat_aeskey','wechat_encry']);
//        Cache::store('redis')->set('abc','1234567890xsaxazczxc',3600);
//        var_dump($wechat);
//        echo json_encode(QQService::app("mzc00200mnujrjg","movie")->message());
//        var_dump(QcloudCoService::put("/upload/image/20200417/45f71819c29a85151806a57609fdade0.jpeg"));
        // 2516367843@qq.com
//        MailService::app()->to("2565275061@qq.com")->send("测试"," 模块首页
// 应用入口
// 参数设置
// 操作员权限
//业务菜单
// 视频管理
// 课程管理
// 课程分类
// 推荐板块
// 讲师管理
// 营销管理
// 课程订单
// VIP服务
// 评价管理
// 分销管理
// 财务管理
// 文章公告
// 基本设置
// PC端设置
// 清空缓存
// 日志管理
//日志列表
//删除日志
//筛选
//模块操作
//操作类型
//操作员操作时间
//总数：1928
//操作员	操作类型	操作模块	操作描述	操作IP	操作时间
//admin	删除	课程管理	删除ID:0的课程下ID:853的章节	180.175.1.70	2020-04-30 15:28:38");
//        return WechatNews::sync();
//        MiniVideo::updateVideoRank("movie");
//        MiniVideo::updateVideoRank("tv");
    }
}