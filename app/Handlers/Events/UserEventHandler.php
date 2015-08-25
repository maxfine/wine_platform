<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/24
 * Time: 10:21
 */

namespace App\Handlers\Events;


class UserEventHandler {
    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event)
    {
        //
    }

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event)
    {
        //
    }

    /**
     * 注册监听器给订阅者。
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('App\Events\UserLoggedIn', 'UserEventHandler@onUserLogin');

        $events->listen('App\Events\UserLoggedOut', 'UserEventHandler@onUserLogout');
    }
}