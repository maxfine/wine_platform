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
        'title' => '后台主页',
        'slug' => 'admin',
        'url' => '',
        'icon' => 'th-large',
        'active' => false,
        'childs' => false,
    ],
    [
        'title' => '控制面板',
        'slug' => '',
        'url' => 'javascript:void(0);',
        'icon' => 'th-large',
        'active' => false,
        'childs' => false,
    ],
    [
        'title' => '内容管理',
        'slug' => '',
        'url' => 'javascript:void(0);',
        'icon' => 'edit',
        'active' => false,
        'childs' =>
        [
            [
                'title' => '文章列表',
                'slug' => 'admin/articles',
                'url' => '',
                'icon' => '',
                'active' => false,
            ],
            [
                'title' => '文章分类',
                'slug' => 'admin/article/cats',
                'url' => '',
                'icon' => '',
                'active' => false,
            ],
            [
                'title' => '文章分类',
                'slug' => 'admin/pages',
                'url' => '',
                'icon' => '',
                'active' => false,
            ]
        ],
    ],
];