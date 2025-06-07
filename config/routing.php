<?php

$routing = array(
    '/^db\/(.*)/' => 'users/download/\1',
    '/^category\/(.*)/' => 'categories/view/\1',
    '/^\d{4}\/\d{1,2}\/\d{1,2}\/(.*)/' => 'categories/article/$0',
    '/^\d{4}\/\d{1,2}\/\d{1,2}/' => 'categories/dayview/$0',
    '/^\d{4}\/\d{1,2}/' => 'categories/monthview/$0',
    '/^归档/' => 'categories/archive',
    '/^版权信息/' => 'categories/copyright',
    '/^关于本站/' => 'categories/about',
    '/^search/' => 'categories/soso/',
    '/^admin\/(.*?)/' => 'users/\1',
    '/^auth\/(.*?)/' => 'users/$0',
    '/^comment\/(.*)/' => 'comments/\1',
    '/^\d{4}/' => 'categories/yearview/$0'
);

$default['controller'] = 'categories';
$default['action'] = 'index';