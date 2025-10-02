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
    <?php echo $html->includeCssEx("assets/css/add.min"); echo PHP_EOL;?>
    <!--==== Style css file ====-->
    <?php echo $html->includeCssEx("assets/css/style"); echo PHP_EOL;?>

    <!--==== Responsive css file ====-->
    <?php echo $html->includeCssEx("assets/css/responsive"); echo PHP_EOL;?>

    <!--==== Custom css file ====-->
    <?php echo $html->includeCssEx("assets/css/custom"); echo PHP_EOL;?>
    <?php echo $html->includeJsEx("assets/js/jquery-1.12.1.min"); echo PHP_EOL;?>
</head>
<body class="<?php echo($_COOKIE['night'] == '1' ? 'night' : ''); ?>">
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
                                <li>
                                    <a href="javascript:switchNightMode()" target="_self" class="toggle-theme toggle-radius" ><i><svg viewBox="0 0 1024 1024"><path d="M512 33.408c288.832 0 480 227.008 480 428.16 0 126.528-84.864 225.6-186.048 264.576-23.36 8.96-52.224 14.464-86.016 17.28-31.68 2.56-63.104 2.752-99.392 1.472l-20.672-0.64c-6.4 0-21.248 16.256-21.248 42.88 0 10.496 0.384 11.456 6.08 17.472l3.392 3.584c18.176 19.648 26.496 41.28 26.496 79.68 0 45.184-23.232 76.16-59.328 91.712-19.52 8.384-38.4 11.072-52.736 10.88-291.776 0-470.528-237.12-470.528-480C32 269.568 215.936 33.472 512 33.472z m87.872 646.784c3.2 0 29.76 1.024 23.04 0.768 33.92 1.152 63.104 1.024 91.712-1.28 28.224-2.432 51.584-6.784 68.288-13.248 78.528-30.272 145.088-107.904 145.088-204.8 0-168.064-165.184-364.224-416-364.224-256.704 0-416 204.416-416 413.12 0 210.752 154.688 416 406.848 416 6.464 0 17.216-1.472 27.008-5.76 13.952-5.952 20.736-14.976 20.736-32.896 0-22.4-2.304-28.48-9.472-36.224l-3.008-3.2c-16.192-17.152-23.488-33.28-23.488-61.376 0-60.672 42.112-106.88 85.248-106.88zM238.912 512a77.76 77.76 0 1 1-0.064-155.52 77.76 77.76 0 0 1 0 155.52z m146.688-192.512a77.76 77.76 0 1 1-0.064-155.52 77.76 77.76 0 0 1 0.064 155.52z m249.472 0a77.824 77.824 0 1 1 0.064-155.648 77.824 77.824 0 0 1 0 155.648zM783.232 512a77.824 77.824 0 1 1 0-155.648 77.824 77.824 0 0 1 0 155.648z"></path></svg></i></a>
                                </li>
                            </ul>
                        </div>
                        <!-- End of Nav Menu -->

                        <!-- Mobile Menu -->
                        <div class="mobile-menu-cover">
                            <ul class="nav mobile-nav-menu">
                                <li class="search-toggle-open"><?php echo $html->includeimgEx("assets/images/search-icon.svg",'  alt="" class="img-fluid svg" '); echo PHP_EOL;?>
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


