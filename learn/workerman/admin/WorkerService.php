<?php


namespace learn\workerman\admin;


use learn\workerman\ChannelService;
use learn\workerman\Response;
use think\worker\Server;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;
use Channel\Client;

/**
 * 后台ws服务
 * Class worker
 * @package learn\workerman\admin
 */
class WorkerService extends Server
{
    /**
     * 协议
     * @var string
     */
    protected $protocol = "websocket";

    /**
     * 监听地址
     * @var string
     */
    protected $host = '0.0.0.0';

    /**
     * 端口
     * @var string
     */
    protected $port = 1996;

    /**
     * 基础配置
     * @var array
     */
    protected $option = [
        'count'		=> 1,
        'name'		=> 'admin'
    ];

    /**
     * 定时程序
     * @var null
     */
    protected $time;

    /**
     * @var Worker
     */
    protected $worker;

    /**
     * @var TcpConnection[]
     */
    protected $connections = [];

    /**
     * @var TcpConnection[]
     */
    protected $user = [];

    /**
     * @var WorkerHandle
     */
    protected $handle;

    /**
     * @var Response
     */
    protected $response;

    public function setUser(TcpConnection $connection)
    {
        $this->user[$connection->adminInfo['id']] = $connection;
    }

    /**
     * worker constructor.
     * @param Worker|null $worker
     */
    protected function init(Worker $worker = null)
    {
        parent::init();
        $this->worker = $worker;
        $this->handle = new WorkerHandle($this);
        $this->response = new Response();
    }

    /**
     * 连接
     * @param TcpConnection $connection
     */
    public function onConnect(TcpConnection $connection)
    {
        $this->connections[$connection->id] = $connection;
        $connection->lastMessageTime = time();
    }

    /**
     * 当获取到信息
     * @param TcpConnection $connection
     * @param $res
     */
    public function onMessage(TcpConnection $connection, $res)
    {
        $connection->lastMessageTime = time();
        $res = json_decode($res, true);
        if (!$res || !isset($res['type']) || !$res['type'] || $res['type'] == 'ping') return;
        if (!method_exists($this->handle, $res['type'])) return;
        $this->handle->{$res['type']}($connection, $res + ['data' => []], $this->response->connection($connection));
    }

    /**
     * 开启时
     * @param Worker $worker
     */
    public function onWorkerStart(Worker $worker)
    {
        Timer::add(15, array($this->handle, 'timeoutClose'), array($worker,$this->response), true);
    }

    /**
     * 连接关闭
     * @param TcpConnection $connection
     */
    public function onClose(TcpConnection $connection)
    {
        unset($this->connections[$connection->id]);
    }
}