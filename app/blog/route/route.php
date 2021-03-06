<?php

use think\facade\Route;

// 不需要登录
Route::group(function () {
    Route::get('auth/code', 'index/code');
    Route::get('auth/auth', 'index/auth');
});

// 需要登录
Route::group(function () {

})->middleware(\learn\middleware\AllowOriginMiddleware::class)->middleware(\learn\middleware\AuthTokenMiddleware::class);