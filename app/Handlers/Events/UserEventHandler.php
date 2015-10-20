<?php namespace App\Handlers\Events;

use App\Repositories\UserRepository;

/**
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/8/24
 * Time: 10:21
 */

class UserEventHandler {

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event)
    {
        $user = $event->user;
        $this->user->updateUserGroup($user);
    }

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event)
    {
        //
    }

    /**
     * 处理用户积分更新事件.
     * @param $event
     */
    public function onUserPointUpdate($event)
    {
        $user = $event->user;
        $this->user->updateUserGroup($user);
    }

    /**
     * 注册监听器给订阅者。
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('App\Events\UserLoggedIn', 'App\Handlers\Events\UserEventHandler@onUserLogin');
        $events->listen('App\Events\UserLoggedOut', 'App\Handlers\Events\UserEventHandler@onUserLogout');
        $events->listen('App\Events\UserPointUpdate', 'App\Handlers\Events\UserEventHandler@onUserPointUpdate');
    }
}