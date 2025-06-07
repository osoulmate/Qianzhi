<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no">
    <meta name="keywords" content="Linux,运维">
    <!-- block meta  -->
    <title><?php if(isset($htmlTitle)){echo $htmlTitle;}else{echo '千知博客';}?></title>

    <!-- Favicon -->
    <?php echo $html->includeFacicon("assets/images/favicon.ico",' rel="shortcut icon" type="image/x-icon" '); echo PHP_EOL;?>

    <!--==== Google Fonts ====-->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500%7CSpectral:400,400i,500,600,700" rel="stylesheet">

    <!-- CSS Files -->

    <!--==== Bootstrap css file ====-->
    <?php echo $html->includeCssEx("assets/css/bootstrap.min"); echo PHP_EOL;?>
    <!--==== Font-Awesome css file ====-->
    <?php echo $html->includeCssEx("assets/css/font-awesome.min"); echo PHP_EOL;?>
    <!--==== zico css file ====-->
    <?php echo $html->includeCssEx("zico/css/zico.min"); echo PHP_EOL;?>
    <!--==== Animate CSS ====-->
    <?php echo $html->includeCssEx("assets/plugins/animate/animate.min"); echo PHP_EOL;?>

    <!--==== Owl Carousel ====-->
    <?php echo $html->includeCssEx("assets/plugins/owl-carousel/owl.carousel.min"); echo PHP_EOL;?>

    <!--==== Magnific Popup ====-->
    <?php echo $html->includeCssEx("assets/plugins/magnific-popup/magnific-popup"); echo PHP_EOL;?>

    <!--==== Style css file ====-->
    <?php echo $html->includeCssEx("assets/css/style"); echo PHP_EOL;?>

    <!--==== Responsive css file ====-->
    <?php echo $html->includeCssEx("assets/css/responsive"); echo PHP_EOL;?>

    <!--==== Custom css file ====-->
    <?php echo $html->includeCssEx("assets/css/custom"); echo PHP_EOL;?>
    <?php echo $html->includeJsEx("assets/js/jquery-1.12.1.min"); echo PHP_EOL;?>
</head>
<body>
    <!-- Nav Search Box -->
    <div class="nav-search-box">
        <form method="post" action="/search">
            <div class="input-group">
                <input type="text" class="form-control" name="key" placeholder="Search..." style="text-decoration: none;outline: none !important;border: 0px;box-shadow: none;">
                <span class="b-line"></span>
                <span class="b-line-under"></span>
                <div class="input-group-append">
                    <button type="submit" class="btn">
                        <?php echo $html->includeimgEx("assets/images/search-icon.svg",' class="img-fluid svg" alt="" '); echo PHP_EOL;?>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- End of Nav Search Box -->
    
    <!-- Header -->
    <header class="header">
        <div class="header-fixed">
            <div class="container-fluid pl-120 pr-120 position-relative">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-5 col-md-4 col-6">
                        <!-- Logo -->
                        <div class="logo">
                            <h1 class="navbar-brand">千知博客</h1> 
                        </div>
                        <!-- End of Logo -->
                    </div>

                    <div class="col-lg-7 col-md-8 col-6 d-flex justify-content-end position-static">
                        <!-- Nav Menu -->
                        <div class="nav-menu-cover">
                            <?php $tempResultsChild = array();$i=0;
                            foreach ($categories as $subcategory) 
                            {
                                if (!empty($subcategory['Parent']['id'])){
                                    $tempResultsChild[$subcategory['Parent']['id']][$i]=$subcategory['Category']['name'];
                                    $i=$i+1;
                                }
                            }
                            ?>
                            <ul class="nav nav-menu">
                                <li><a href="/">首页</a></li>
                                <?php foreach ($categories as $category):?>
                                <?php if(!empty($tempResultsChild[$category['Category']['id']])):?>
                                <li class="menu-item-has-children">
                                    <a href="#"><?php echo $category['Category']['name'];?></a>
                                    <ul class="sub-menu">
                                    <?php foreach ($tempResultsChild[$category['Category']['id']] as $subcategory):?>
                                            <li>
                                            <?php echo $html->link($subcategory,'category/'.$subcategory.'/');?>
                                            </li>
                                    <?php endforeach?>
                                    </ul>  
                                </li>
                                <?php endif?>
                                <?php if((empty($tempResultsChild[$category['Category']['id']]))&&$category['Category']['parent_id']==0):?>
                                <li>
                                <?php echo $html->link($category['Category']['name'],'category/'.$category['Category']['name'].'/');?>
                                </li>
                                <?php endif?>
                                <?php endforeach?>
                                <li><?php echo $html->link('归档','归档');?></li>
                            </ul>
                        </div>
                        <!-- End of Nav Menu -->

                        <!-- Mobile Menu -->
                        <div class="mobile-menu-cover">
                            <ul class="nav mobile-nav-menu">
                                <li class="search-toggle-open">
                                    <?php echo $html->includeimgEx("assets/images/search-icon.svg",'  alt="" class="img-fluid svg" '); echo PHP_EOL;?>
                                </li>
                                <li class="search-toggle-close hide">
                                    <?php echo $html->includeimgEx("assets/images/close.svg",' alt="" class="img-fluid" '); echo PHP_EOL;?>
                                </li>
                                <li class="nav-menu-toggle">
                                    <?php echo $html->includeimgEx("assets/images/menu-toggler.svg",' alt="" class="img-fluid svg" '); echo PHP_EOL;?>
                                </li>
                            </ul>
                        </div>
                        <!-- End of Mobile Menu -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End of Header -->
<div>


