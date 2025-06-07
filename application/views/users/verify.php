<?php
//session_start(['cookie_lifetime'=>60,'gc_maxlifetime'=>60]);
require_once(ROOT . DS . 'library' . DS .'geetestlib.php');
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
$code_flag=false;
if(empty($_SESSION['user_id'])){
	echo 'failure';
	return;
}
$data = array(
        "user_id" => $_SESSION['user_id'], # 网站用户id
        "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
        "ip_address" => $_SERVER['REMOTE_ADDR'] # 请在此处传输用户请求验证时所携带的IP
);
if(empty($_POST['geetest_challenge']) || empty($_POST['geetest_validate']) || empty($_POST['geetest_seccode'])){
    echo 'failure';
    return;
}
if($_SESSION['gtserver'] == 1) {   //服务器正常
    $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
    if ($result) {
        $code_flag=true;
    } else{
        $code_flag=false;
    }
}else{  //服务器宕机,走failback模式
    if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
        $code_flag=true;
    }else{
        $code_flag=false;
    }
}
$arr = array();
if($code_flag){
    if (empty($_POST['user']) || empty($_POST['password'])) {
        $arr=array('flag'=>'用户名或密码为空');
        echo json_encode($arr);
    }else{
        if(!empty($username)){
            if($status==1){
                if($admin==1){
                    $_SESSION["loginSuccess"]=true;
                    setcookie('username',$username);
                    setcookie('token',$token);
                    $indexUrl = $html->url('admin/index');
                    $arr=array('flag'=>'OK','url'=>$indexUrl);
                    echo json_encode($arr);
                }else{
                    $arr=array('flag'=>'抱歉，暂不支持普通用户登陆');
                    echo json_encode($arr);
                }
            }else{
                $arr=array('flag'=>'您的账户尚未激活');
                echo json_encode($arr);
            }
        }else{
            $arr=array('flag'=>'用户名或密码错误');
            echo json_encode($arr);     
        }
    }
}else{
    $arr=array('flag'=>'认证失败');
    echo json_encode($arr);
}

