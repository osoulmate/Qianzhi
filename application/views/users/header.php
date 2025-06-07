<?php
/*******************************
* Author:osoulmate
* Email:askqingya@gmail.com
* Date: 2019-1-16
* header.php 后台主页
*******************************/
header('content-type:text/html;charset=utf-8');
if(!$_SESSION["loginSuccess"]){
  //echo "非法访问";
  echo '<script>window.location.href='.$html->url('admin/login').';</script>'; 
}
if(isset($_COOKIE['username'])){
  $token = md5($_COOKIE['username'].CURRENT_TIME.BASE_PATH.'/admin/login');
  if(!isset($_COOKIE['token'])||($_COOKIE['token']!=$token)){
    echo '<script>window.location.href='.$html->url('admin/login').';</script>';    
    exit;
  }
}else{
    echo '<script>window.location.href='.$html->url('admin/login').';</script>';    
    exit;
}
if(isset($ok)){
    echo '<script>window.location.href='.$html->url('admin/'.$ok).';</script>';
}
if(isset($preview)){
    $date = mb_substr($preview['Article']['date'],0,10,'utf-8');
    $dateFormat = explode('-', $date);
    $dateFormat = implode('/', $dateFormat);
    echo '<script>window.location.href='.$html->url($dateFormat.'/'.$preview['Article']['title']).';</script>';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="千知后台">
    <meta name="author" content="osoulmate">

    <!-- Favicon -->
    <?php echo $html->includeFacicon("assets/images/favicon.ico",' rel="shortcut icon" type="image/x-icon" '); echo PHP_EOL;?>
    <title><?php if(isset($htmlTitle)){echo $htmlTitle;}else{echo "千知博客/主页";}?></title>
    <!-- CSS Files -->

    <!--==== Bootstrap css file ====-->
    <?php echo $html->includeCssEx("assets/css/bootstrap.min"); echo PHP_EOL;?>
    <?php echo $html->includeCssEx('assets/css/font-awesome.min'); echo PHP_EOL;?>
    <!-- Custom styles for this template -->
    <?php echo $html->includeCss('admin'); echo PHP_EOL;?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>-->
    <?php echo $html->includeJsEx("assets/js/jquery-1.12.1.min"); echo PHP_EOL;?>
  </head>
<body>
<!--顶栏-->
<header class="header">
  <div class="header-fixed">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 col-lg-2 .no-gutters qz-left">
          <h1 class="qz-brand">千知博客</h1>
        </div>
        <div class="col-10 col-lg-10 offset-md-2 offset-lg-2 .no-gutters qz-right">
          <ul class="qz-breadcrumb">
            <?php if(isset($location)&&isset($name)):
              $location = explode('/',$location);
              $name = explode('/',$name);
              $l1 = $location[0];
              $name1 = $name[0];
              array_shift($location);
              array_shift($name);
              if(isset($location[0])){$l2 = $location[0];}
              if(isset($name[0])){$name2 = $name[0];}
            ?>
            <?php if(!empty($name1) && !empty($l1) && empty($l2)):?>
            <li><?php echo $html->link('首页','admin/index');?></li>
            <li><?php echo $html->link($name1,'admin/'.$l1);?></li>
            <?php elseif (!empty($name1) && !empty($l1) && !empty($l2)):?>
            <li><?php echo $html->link('首页','admin/index');?></li>
            <li><a href="javascript:;"><?php echo $name1;?></a></li>
            <li><?php echo $html->link($name2,'admin/'.$l1.'/'.$l2);?></li>
            <?php else:?>
            <?php endif?>
            <?php else:?>
            <li><?php echo $html->link('首页','admin/index');?></li>
            <?php endif ?>
          </ul>
      </div>
    </div>
  </div>
</header>
<div class="container-fluid">
  <div class="row">