<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use app\admin\model\user\User;
use learn\services\WechatService;

/**
 * 微信用户
 * Class WechatUser
 * @package app\admin\model\wechat
 */
class WechatUser extends BaseModel
{
    use ModelTrait;

    /**
     * 订阅
     * @param string $openId
     * @return User|WechatUser|\think\Model
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function subscribe(string $openId)
    {
        $userInfo = WechatService::getUserInfo($openId);
        $data = [
            'openid' => $userInfo['openid'],
            'nickname' => $userInfo['nickname'],
            'avatar' => $userInfo['headimgurl'],
            'sex' => $userInfo['sex'],
            'city' => $userInfo['city'],
            'language' => $userInfo['language'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country'],
            'subscribe' => $userInfo['subscribe'],
            'subscribe_time' => $userInfo['subscribe_time'],
            'groupid' => $userInfo['groupid'],
            'tagid_list' => $userInfo['tagid_list'],
        ];
        return self::be($openId,"openid") ? self::updateUser($data) : self::addUser($data, User::addUser($data));
    }

    /**
     * 添加微信用户
     * @param array $data
     * @param int|string $uid
     * @return WechatUser|\think\Model
     */
    public static function addUser(array $data, int $uid)
    {
        $data['uid'] = $uid;
        return self::create($data);
    }

    /**
     * 更新微信用户
     * @param array $data
     * @return bool
     */
    public static function updateUser(array $data)
    {
        $uid = self::where("openid",$data['openid'])->column('uid');
        $res1 = self::update($data,['uid'=>$uid]);
        $res2 = User::updateUser($data, (int)$uid,1);
        return $res1 && $res2;
    }

    /**
     * 取消订阅
     * @param string $openId
     * @return WechatUser
     */
    public static function unSubscribe(string $openId)
    {
        return self::update(['subscribe'=>0],['openid'=>$openId]);
    }

    /**
     * 通过openid获取uid
     * @param string $openId
     * @return mixed
     */
    public static function getUidByOpenId(string $openId)
    {
        return self::where("openid",$openId)->value("uid") ?: 0;
    }
}