<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="linux,运维，数据库">
    <meta name=generator content="mshtml 8.00.7600.16853">
    <meta content="text/html; charset=utf-8" http-equiv=content-type>
    <?php echo $html->includeFacicon("assets/images/favicon.ico",' rel="shortcut icon" type="image/x-icon" '); echo PHP_EOL;?>
    <!-- block meta  -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--==== zico css file ====-->
    <?php echo $html->includeCssEx("zico/css/zico.min"); echo PHP_EOL;?>
    <title>千知博客-用户登录</title>
    <?php echo $html->includeCss('base')?>
    <?php echo $html->includeCss('iconfont')?>
    <?php echo $html->includeCss('reg')?>
    <!--<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>-->
    <?php echo $html->includeJsEx("assets/js/jquery-1.12.1.min"); echo PHP_EOL;?>
</head>
<body>
<div id="ajax-hook"></div>
<div class="wrap">
    <div class="wpn">
        <div class="form-data pos">
            <a href=""><?php echo $html->includeImg('logo.png','class="head-logo "')?></a>
            <div class="change-login">
                <p class="account_number on">账号登录</p>
                <p class="message">短信登录</p>
            </div>
            <div class="form1">
                <p class="p-input pos">
                    <label for="num">用户名/邮箱</label>
                    <input type="text" id="num" autocomplete='new-user'>
                    <span class="tel-warn num-err hide"><em></em><i class="icon-warn"></i></span>
                </p>
                <p class="p-input pos">
                    <label for="pass">密码</label>
                    <input type="password" id="pass" autocomplete="new-password">
                    <span class="tel-warn pass-err hide"><em></em><i class="icon-warn"></i></span>
                </p>
                <div class="captcha code pos">
                    <div class="text">行为验证™ 安全组件加载中</div>
                    <div class="wait">
                        <div class="loading">
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                            <div class="loading-dot"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form2 hide">
                <p class="p-input pos">
                    <label for="num2">手机号</label>
                    <input type="number" id="num2">
                    <span class="tel-warn num2-err hide"><em>账号或密码错误</em><i class="icon-warn"></i></span>
                </p>
                <p class="p-input pos">
                    <label for="veri-code">输入验证码</label>
                    <input type="number" id="veri-code">
                    <a href="javascript:;" class="send">发送验证码</a>
                    <span class="time hide"><em>120</em>s</span>
                    <span class="tel-warn error hide">验证码错误</span>
                </p>
            </div>
            <div><span id='tip'></span></div>
            <div class="r-forget cl">
                <?php echo $html->link('账号注册','admin/registry','','','class="z"')?>
                <?php echo $html->link('忘记密码','admin/getpass','','','class="y"')?>
            </div>
            <button class="lang-btn off log-btn">登录</button>
            <div class="third-party">
                <a href="/auth/weixin"><i class="zi zi_tmWeixin zi_2x"></i></a>
                <a href="/auth/github"><i class="zi zi_tmGithub zi_2x"></i></a>
                <a href="/auth/gitee"><i class="zi zi_tmGitee zi_2x"></i></a>
            </div>
        </div>
    </div>
</div>
<?php echo $html->includeJs('gt');echo PHP_EOL;?>
<?php echo $html->includeJs('agree');echo PHP_EOL;?>
<?php echo $html->includeJs('md5');echo PHP_EOL;?>
<?php echo $html->includeJs('login');echo PHP_EOL;?>
<div style="text-align:center;">
<p><?php echo $html->link('千知博客','')?></p>
</div>
</body>
</html>
