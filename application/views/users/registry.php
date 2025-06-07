<?php
if($render == 'two'){
    require_once (ROOT . DS . 'library' . DS . 'smtp.class.php');
    if(isset($ok)&&($ok == 'ok'))
    {
    try{
        $mailto=$email;
        $mailsubject="用户帐号激活";
        $content="亲爱的" . $username . "：<br/>您的帐号已经注册成功。<br/>请点击链接激活您的帐号。<br/>".$html->link('激活','admin/active/'.$token)."<  br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'></p>";
        $mailbody=$content;
        $smtpserver     = "ssl://smtp.qiye.aliyun.com";
        $smtpserverport = 465;
        $smtpusermail   = "admin@zhangqingya.cn";
        $smtpuser       = "admin@zhangqingya.cn";
        $smtppass       = "yourpassword";
        $mailsubject    = "=?UTF-8?B?" . base64_encode($mailsubject) . "?=";
        $mailtype       = "HTML";
        //可选，设置回信地址
        $smtpreplyto    = "***";
        $smtp           = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
        //$smtp->debug    = true;
        $cc   ="";
        $bcc  = "";
        $additional_headers = "";
        //设置发件人名称，名称用户可以自定义填写。
        $sender  = "admin";
        $result=$smtp->sendmail($mailto,$smtpusermail, $mailsubject, $mailbody, $mailtype, $cc, $bcc, $additional_headers, $sender,$smtpreplyto);
        //echo '恭喜您，注册成功！<br/>请登录到您的邮箱点击激活链接激活帐号！';
        if($result){
            echo json_encode('success');
        }else{
            echo json_encode('failure');
        }
        
    }catch (Exception $e) {
                //echo '邮件发送失败', $smtp->smtp_error;
                echo json_encode('failure');
            }
    }
}
?>
<?php if($render =='ok'):?>
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
    <title>千知博客-注册</title>
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
                <form>
                    <p class="p-input pos">
                        <label for="usr">用户名</label>
                        <input type="text" id="username" onblur="usercheck(this.value)" autocomplete='new-user'>
                        <span class="tel-warn num-err hide"><em></em><i class="icon-warn"></i></span>
                    </p>
                    <p class="p-input pos">
                        <label for="eml">邮箱</label>
                        <input type="email" id="email" onblur="emlcheck(this.value)" autocomplete='new-user'>
                        <span class="tel-warn tel-err hide"><em></em><i class="icon-warn"></i></span>
                    </p>
                    <p class="p-input pos show" id="pwd">
                        <label for="passport">输入密码</label>
                        <input type="password" id="passport" onblur="pwdcheck(this.value)"  autocomplete='new-user'>
                        <span class="tel-warn pwd-err hide"><em></em><i class="icon-warn" style="margin-left: 5px"></i></span>
                    </p>
                    <p class="p-input pos show" id="confirmpwd">
                        <label for="passport2">确认密码</label>
                        <input type="password" id="passport2" onblur="pwdcheck2(this.value)"  autocomplete='new-user'>
                        <span class="tel-warn confirmpwd-err hide"><em></em><i class="icon-warn" style="margin-left: 5px"></i></span>
                    </p>
                </form>
                <div class="reg_checkboxline pos">
                    <span class="z"><i class="icon-ok-sign boxcol" nullmsg="请同意!"></i></span>
                    <input type="hidden" name="agree" value="1">
                    <div class="Validform_checktip"></div>
                    <p>我已阅读并接受 <a href="#" target="_brack">《千知博客注册协议说明》</a></p>
                </div>
                <button class="lang-btn">注册</button>
                <div class="bottom-info">已有账号，<?php echo $html->link('马上登录','admin/login')?></div>
                <div class="third-party">
                    <a href="/auth/weixin"><i class="zi zi_tmWeixin zi_2x"></i></a>
                    <a href="/auth/github"><i class="zi zi_tmGithub zi_2x"></i></a>
                    <a href="/auth/gitee"><i class="zi zi_tmGitee zi_2x"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="success-page hide"></div>
    <?php echo $html->includeJs('agree')?>
<script>
function usercheck(str)
{
    if(!str){
        $('.num-err').removeClass('hide').find('em').text('用户名不能为空');
        $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        return;
    }
    $.ajax({
        url: '/admin/regCheck',
        type: 'post',
        dataType: 'json',
        data: {
            username: str
        },
        success: function (data,status,xhr) {
        $('.num-err').removeClass('hide').find('em').text(data['flag']);
        $('.num-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        }
    });
}
function pwdcheck(str)
{
    if(!str){
        $('.pwd-err').removeClass('hide').find('em').text('密码不能为空');
        $('.pwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        return;
    }
    $.ajax({
        url: '/admin/regCheck',
        type: 'post',
        dataType: 'json',
        data: {
            pass: str
        },
        success: function (data,status,xhr) {
            $('.pwd-err').removeClass('hide').find('em').text(data['flag']);
            $('.pwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
            //$("#pwdHint").text(data['flag']);
        }
    });
}
function pwdcheck2(str)
{
    if(!str){
        $('.confirmpwd-err').removeClass('hide').find('em').text('密码不能为空');
        $('.confirmpwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        return;
    }
    $.ajax({
        url: '/admin/regCheck',
        type: 'post',
        dataType: 'json',
        data: {
            pass: str
        },
        success: function (data,status,xhr) {
        $('.confirmpwd-err').removeClass('hide').find('em').text(data['flag']);
        $('.confirmpwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        }
    });
}
function emlcheck(str)
{
    if(!str){
        $('.tel-err').removeClass('hide').find('em').text('邮箱不能为空');
        $('.tel-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        return;
    }
    $.ajax({
        url: '/admin/regCheck',
        type: 'post',
        dataType: 'json',
        data: {
            email: str
        },
        success: function (data,status,xhr) {
        $('.tel-err').removeClass('hide').find('em').text(data['flag']);
        $('.tel-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        }
    });
}
</script>
<script type="text/javascript">
$(".lang-btn").click(function(event){
    if($('#passport').val() != $('#passport2').val()){
        $('.confirmpwd-err').removeClass('hide').find('em').text('两次输入密码不一致');
        $('.confirmpwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");
        $('.pwd-err').removeClass('hide').find('em').text('两次输入密码不一致');
        $('.pwd-err').find('i').attr('class', 'icon-warn').css("color","#d9585b");  
        return;
    }
    $.ajax({
        url: <?php echo $html->url('admin/registry')?>,
        type: 'post',
        dataType: 'json',
        data: {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#passport').val()
        },
        success: function (data,status,xhr) {
            if(data == 'success'){
                $('.wrap').addClass('hide');
                $('.success-page').removeClass('hide').html('恭喜您，注册成功！<br/>请登录到您的邮箱点击激活链接激活帐号！'); 
                $('body').css("background-color","white");
            }else{
                $('.wrap').addClass('hide');
                $('.success-page').removeClass('hide').html('抱歉，注册失败！<br/>请检查您输入的邮箱地址是否正确！'); 
                $('body').css("background-color","white");
            }
        },
    });
});
</script>
    <div style="text-align:center;">
<p><?php echo $html->link('千知博客','')?></p>
</div>
</body>
</html>
<?php endif?>
