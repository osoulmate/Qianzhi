<?php
class MenuConfig
{
  public $menu=[
  [
    'name' => '首页',
    'url' => 'admin/index',
    'icon' =>'fa fa-home',
    'status'=> 0,
    'sub'=> 0
  ],
  [
    'name' => '写文章',
    'url' => 'admin/write',
    'icon' =>'fa fa-edit',
    'status'=> 0,
    'sub'=> 0
  ],
  [
    'name' => '文章管理',
    'url' => '#',
    'icon' =>'fa fa-folder-o',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '文章列表',
          'url' => 'admin/wzgl/list',
          'status'=> 0,
        ],
        [
          'name' => '回收站',
          'url' => 'admin/wzgl/hsz',
          'status'=> 0,
        ],
    ]
  ],
  [
    'name'=> '评论管理',
    'url' => '#',
    'icon' =>'fa fa-comments',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '评论列表',
          'url' => 'admin/plgl/list',
          'status'=> 0,
        ]
    ]
  ],
  [
    'name' => '栏目管理',
    'url' => '#',
    'icon' =>'fa fa-chain',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '栏目列表',
          'url' => 'admin/lmgl/list',
          'status'=> 0,
        ],
        [
          'name' => '添加栏目',
          'url' => 'admin/lmgl/add',
          'status'=> 0,
        ],
    ]
  ],
  [
    'name' => '系统设置',
    'url' => '#',
    'icon' =>'fa fa-cog',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '网站设置',
          'url' => 'admin/system/setup',
          'status'=> 0,
        ],
        [
          'name' => '友链管理',
          'url' => 'admin/system/friend',
          'status'=> 0,
        ],
        [
          'name' => '导航管理',
          'url' => 'admin/system/nav',
          'status'=> 0,
        ],
        [
          'name' => '修改密码',
          'url' => 'admin/system/resetpass',
          'status'=> 0,
        ],
    ]
  ],
  [
    'name' => '用户管理',
    'url' => '#',
    'icon' =>'fa fa-user',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '用户列表',
          'url' => 'admin/yhgl/list',
          'status'=> 0,
        ],
        [
          'name' => '添加用户',
          'url' => 'admin/yhgl/add',
          'status'=> 0,
        ],
    ]
  ],
  [
    'name' => '数据库',
    'url' => '#',
    'icon' =>'fa fa-database',
    'status'=> 0,
    'sub'=>[
        [
          'name' => '备份数据库',
          'url' => 'admin/db/backup',
          'status'=> 0,
        ],
        [
          'name' => '还原数据库',
          'url' => 'admin/db/recovery',
          'status'=> 0,
        ],
    ]
  ],
  [
    'name' => '退出登陆',
    'url' => 'admin/exit',
    'icon' =>'fa fa-sign-out',
    'status'=> 0,
    'sub'=> 0
  ],
];
//$utils = new Utils();
//echo $utils->dump($menu);
}