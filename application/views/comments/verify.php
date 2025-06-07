<?php
if (empty($_POST['user']) || empty($_POST['password'])) {
    $arr=array('flag'=>'用户名或密码为空');
    echo json_encode($arr);
}else{
    if(!empty($username)){
        if($status==1){
            $arr=array('flag'=>'OK','name'=>$name,'token'=>$token,'id'=>$userid);
            echo json_encode($arr);
        }else{
            $arr=array('flag'=>'您的账户尚未激活');
            echo json_encode($arr);
        }
    }else{
        $arr=array('flag'=>'用户名或密码错误');
        echo json_encode($arr);     
    }
}
