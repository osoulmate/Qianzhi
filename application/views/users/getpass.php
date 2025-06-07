<?php
//session_start();
if($callback == 'success'){
    if(isset($flag)){
        echo json_encode($flag);
        return;
    }
    $_SESSION['code']=$code;
    $_SESSION['time']=time();
    require_once (ROOT . DS . 'library' . DS . 'smtp.class.php');
    try{
        $mailto=$email;
        $mailsubject="用户密码重置";
        $content="【千知博客】 验证码:".$code."<br/>您正在使用重置密码功能，该验证码仅用于身份验证，请勿泄露给他人使用。如非您本人操作，请忽略!";
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
        $smtp->sendmail($mailto,$smtpusermail, $mailsubject, $mailbody, $mailtype, $cc, $bcc, $additional_headers, $sender,$smtpreplyto);
        echo json_encode("ok");
    }catch (Exception $e) {
                //echo '邮件发送失败', $smtp->smtp_error;
                echo json_encode('failure');
    }
}
if($callback == 'reset'){
    if(isset($success)){
        echo json_encode($success);
    }else{
        echo json_encode('failure');
    }
}
if($callback == 'next'){
    $nowtime = time();
    if(($nowtime-$_SESSION['time'])>120){
        echo json_encode('expire');
        return;
    }
    if($_SESSION['code']==$code){
        echo json_encode('success');
    }else{
        echo json_encode('failure');
    }    
}
?>
<?php if($callback == 'no'):?>
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
    <title>千知博客-找回密码</title>
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
        <div class="form-data find_password form1">
            <h4>找回密码</h4>
            <p class="right_now">已有账号，<?php echo $html->link('马上登录','admin/login')?></p>
            <p class="p-input pos">
                <label for="pc_tel">手机号/邮箱</label>
                <input type="text" id="pc_tel">
                <span class="tel-warn pc_tel-err hide"><em>请输入邮箱</em><i class="icon-warn"></i></span>
            </p>
            <p class="p-input pos pc-very show">
                <label for="veri-code">输入验证码</label>
                <input type="text" id="veri-code">
                <a href="#" class="send">发送验证码</a>
                <span class="time hide">重新发送(<em></em>s)</span>
                <span class="tel-warn error hide"><em>验证码错误，请重新输入</em><i class="icon-warn"></i></span>
            </p>
            <button class="lang-btn next">下一步</button>
            <p class="p-input pos pw hide" id="pwd">
                <label for="passport">新密码</label>
                <input type="password" id="passport" autocomplete='new-user'>
                <span class="tel-warn pwd-err hide"><em></em><i class="icon-warn" style="margin-left: 5px"></i></span>
            </p>
            <p class="p-input pos pw2 hide" id="confirmpwd">
                <label for="passport2">确认密码</label>
                <input type="password" id="passport2"  autocomplete='new-user'>
                <span class="tel-warn confirmpwd-err hide"><em></em><i class="icon-warn" style="margin-left: 5px"></i></span>
            </p>
            <button class="lang-btn reset hide">重置密码</button>
        </div>
    </div>
</div>
<?php echo $html->includeJs('agree')?>
<script type="text/javascript">
$(".next").addClass("off");
function validate(obj){
  var atpos=obj.indexOf("@");
  var dotpos=obj.lastIndexOf(".");
  if (atpos<1 || dotpos<atpos+2 || dotpos+2>=obj.length){
    return false;
  }else{
    return true;
  }
}
function checkBtn(){
    if(($('#pc_tel').val()!='') && ($("#veri-code").val()!='')){
        $(".next").removeClass("off");
    }else{
        $(".next").addClass("off");
    }  
}
$('#veri-code').keyup(function(event) {
    $("#veri-code").focus(function(){$('.error').addClass('hide');});
    checkBtn();
});
$('#pc_tel').keyup(function(event) {
    $("#pc_tel").focus(function(){$('.pc_tel-err').addClass('hide');});
    checkBtn();
});
$('#pc_tel').blur(function(event) {
    if(!validate($('#pc_tel').val())){
        $('.pc_tel-err').removeClass('hide').find('em').text('不是有效的Email地址');
        return;
    }
});
function resetCode(){
    $('.send').addClass('hide');
    $('.time').removeClass('hide');
    $('.time').find('em').text('120');
    var second = 120;//倒计时时间
    var timer = null;
    timer = setInterval(function(){
        second -= 1;
        if(second >0 ){
            $('.time').find('em').text(second);
        }else{
            clearInterval(timer);
            $('.send').removeClass('hide');
            $('.time').addClass('hide');
        }
    },1000);
}
$(".send").click(function(event){
    $('.error').addClass('hide');
    if(!$('#pc_tel').val()){
        $('.pc_tel-err').removeClass('hide');
        return;
    }else{
        $('.pc_tel-err').addClass('hide');
    }
    $.ajax({
        url: <?php echo $html->url('admin/getpass/send')?>,
        type: 'post',
        dataType: 'json',
        data: {
            pctel:$('#pc_tel').val()
        },
        success: function (data,status,xhr) {
            if(data == 'ok'){
                resetCode();
            }else if(data == 'failure'){
                $('.pc_tel-err').removeClass('hide').find('em').text('邮件发送失败');
            }else{
                $('.pc_tel-err').removeClass('hide').find('em').text(data);
            }           
        },
        error: function (data,status,xhr) {
        }
    });
});   
</script>
<script type="text/javascript">
$(".next").click(function(event){
    if(!$('#pc_tel').val()|| !$("#veri-code").val()){
        event.preventDefault();
        return;
    }
    $.ajax({
        url: <?php echo $html->url('admin/getpass/next')?>,
        type: 'post',
        dataType: 'json',
        data: {
            code: $('#veri-code').val()
        },
        success: function (data,status,xhr) {
            console.log(data);
            if(data=='success'){
                $('.pc-very').addClass('hide');
                $('.next').addClass('hide');
                $('.pw').removeClass('hide');
                $('.pw2').removeClass('hide');
                $('.reset').removeClass('hide');
            }else if(data=='expire'){
                $('.error').removeClass('hide').find('em').text('验证码已过期');
            }
            else{
                $('.error').removeClass('hide');
            }
        },
        error: function (data,status,xhr) {
            console.log(data);
            console.log(status);
        }
    });
});
</script>
<script type="text/javascript">
$(".reset").click(function(event){
    if(!$('#passport').val()){
        $('.pwd-err').removeClass('hide').find('em').text('密码不能为空');
        return;
    }else if(!$('#passport2').val()){
        $('.confirmpwd-err').removeClass('hide').find('em').text('确认密码不能为空');
        return;
    }else if($('#passport').val() != $('#passport2').val()){
        $('.pwd-err').removeClass('hide').find('em').text('两次输入密码不一致');
        $('.confirmpwd-err').removeClass('hide').find('em').text('两次输入密码不一致');
        return;
    }else{
        if(!$('#pc_tel').val()){
            return;
        }
    }
    $.ajax({
        url: <?php echo $html->url('admin/getpass/reset')?>,
        type: 'post',
        dataType: 'json',
        data: {
            pctel:$('#pc_tel').val(),
            newpass:$('#passport2').val()
        },
        success: function (data,status,xhr) {
            if(data == 'success'){
                $('.wpn').addClass('hide');
                $('.wrap').css("background-color","#fff").append('重置成功')
            }else{
                $('.wpn').addClass('hide');
                $('.wrap').append('重置失败')
            }           
        },
        error: function (data,status,xhr) {
        }
    });
});   
</script>

<div style="text-align:center;">
<p><?php echo $html->link('千知博客','')?></p>
</div>
</body>
</html>
<?php endif?>
