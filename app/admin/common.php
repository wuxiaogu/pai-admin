<?php

use think\facade\Cache;

if (!function_exists('unCamelize'))
{
    /**
     * 驼峰法转下划线
     * @param $camelCaps
     * @param string $separator
     * @return string
     */
    function unCamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}

if (!function_exists('authIsExit'))
{
    /**
     * 判断授权信息是否存在
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function authIsExit(int $adminId): bool
    {
        return Cache::store('redis')->has('store_'.$adminId);
    }
}