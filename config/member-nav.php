<?php
/**
 * Created by 正言网络.
 * User: maxfine
 * Email: max_fine@qq.com
 * Date: 2015/8/23
 * Time: 17:41
 *
 * 后台导航配置
 */

return [
    [
        'id' => 1,
        'parent_id' => 0,
        'title' => '会员中心',
        'slug' => 'member',
        'url' => '',
        'icon' => 'th-large',
        'active' => false,
    ],
    [
        'id' => 2,
        'parent_id' => 1,
        'title' => '网站列表',
        'slug' => '',
        'url' => '/member/poster/themes',
        'icon' => 'list',
        'active' => false,
    ],
    [
        'id' => 3,
        'parent_id' => 1,
        'title' => '添加网站',
        'slug' => '',
        'url' => '/member/poster/themes/create',
        'icon' => 'plus',
        'active' => false,
    ],
    [
        'id' => 4,
        'parent_id' => 1,
        'title' => '在线充值',
        'slug' => '',
        'url' => '/member/pay',
        'icon' => 'rmb',
        'active' => false,
    ],
];