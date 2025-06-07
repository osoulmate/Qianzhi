<?php 
//session_start();
require_once(ROOT . DS . 'library' . DS .'geetestlib.php');
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);

$data = array(
        "user_id" => uniqid(), # 网站用户id
        "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
        "ip_address" => $_SERVER['REMOTE_ADDR'] # 请在此处传输用户请求验证时所携带的IP
    );

$status = $GtSdk->pre_process($data, 1);
$_SESSION['gtserver'] = $status;
$_SESSION['user_id'] = $data['user_id'];
echo $GtSdk->get_response_str();
