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
        'title' => '后台主页',
        'slug' => 'admin',
        'url' => '',
        'icon' => 'th-large',
        'active' => false,
    ],
    [
        'id' => 2,
        'parent_id' => 1,
        'title' => '控制面板',
        'slug' => '',
        'url' => 'http://jiu.znyes.com/admin/index_content',
        'icon' => 'th-large',
        'active' => false,
    ],
    [
        'id' => 3,
        'parent_id' => 1,
        'title' => '内容管理',
        'slug' => '',
        'url' => '',
        'icon' => 'edit',
        'active' => false,
    ],
    [
        'id' => 4,
        'parent_id' => 3,
        'title' => '文章列表',
        'slug' => 'admin/articles',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 5,
        'parent_id' => 3,
        'title' => '文章添加',
        'slug' => 'admin/articles/create',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 6,
        'parent_id' => 3,
        'title' => '文章分类列表',
        'slug' => 'admin/article/cats',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 7,
        'parent_id' => 3,
        'title' => '文章分类添加',
        'slug' => 'admin/article/cats/create',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 8,
        'parent_id' => 3,
        'title' => '单页列表',
        'slug' => 'admin/pages',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 9,
        'parent_id' => 3,
        'title' => '添加单页',
        'slug' => 'admin/pages/create',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 10,
        'parent_id' => 1,
        'title' => '用户管理',
        'slug' => '',
        'url' => '',
        'icon' => 'user',
        'active' => false,
    ],
    [
        'id' => 11,
        'parent_id' => 10,
        'title' => '管理员',
        'slug' => 'admin/managers',
        'url' => '',
        'icon' => '',
        'active' => false,
    ],
    [
        'id' => 12,
        'parent_id' => 10,
        'title' => '权限',
        'slug' => 'admin/permissions',
        'url' => '',
        'icon' => '',
        'active' => false,
    ]
];