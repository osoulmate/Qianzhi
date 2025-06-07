<?php

class CommentsController extends BaseController {
    function beforeAction () {

    }
    function exit(){
        setcookie('name','',time()-1);
        setcookie('newtoken','',time()-1);
        setcookie('id','',time()-1);
        $this->set('exit',true);
    }
    function verify() {
        $this->doNotRenderHeader = 1;
        if(!empty($_POST)){
            $user=trim($_POST['user']);
            $password=md5(trim($_POST['password']));
            $arr = array('user'=>$user,'pass'=>$password);
            $result = $this->Comment->verify($arr);
            if(!empty($result)){
                $token=md5($result['username'].CURRENT_TIME.BASE_PATH.'/admin/login'.$_COOKIE['PHPSESSID']);
                setcookie('name',$result['username']);
                setcookie('newtoken',$token);
                setcookie('id',$result['userid']);
                $this->set('userid',$result['userid']);
                $this->set('username',$result['username']);
                $this->set('name',$result['name']);
                $this->set('admin',$result['admin']);
                $this->set('status',$result['status']);
                $this->set('token',$token);
            }else{
                $this->set('userid','');
                $this->set('username','');
                $this->set('admin','');
                $this->set('status','');
            }
        }
    }
    function check($id = null,$token = null){
        $this->doNotRenderHeader = 1;
        if(!empty($id)&&(is_int(intval($id)))&&!empty($token)){
            $sql = "select username,name,admin,status from users where id={$id}";
            $result = $this->Comment->common($sql);
            if(!empty($result)){
                $realToken = md5($result['username'].CURRENT_TIME.BASE_PATH.'/admin/login'.$_COOKIE['PHPSESSID']);
                if($realToken==$token){
                    $this->set('pass','pass');
                }
            }
        }

    }
    function add(){
        $this->doNotRenderHeader = 1;
        if(!empty($_POST)&&!empty($_POST['userid'])&&!empty($_POST['usertoken'])&&!empty($_POST['articleid'])&&!empty($_POST['content'])){
            $checkSql = "select username,name,admin,status from users where id={$_POST['userid']}";
            $checkResult = $this->Comment->common($checkSql);
            if(!empty($checkResult)&&!empty($checkResult['username'])){
                $realToken = md5($checkResult['username'].CURRENT_TIME.BASE_PATH.'/admin/login'.$_COOKIE['PHPSESSID']);
                if($realToken == $_POST['usertoken']){
                    $sql = "insert into comments(parent_id,article_id,user_id,content,date) values({$_POST['parentid']},{$_POST['articleid']},{$_POST['userid']},'{$_POST['content']}',now())";
                    $ok = $this->Comment->save($sql);
                    if($ok != -1){
                        $this->set('flag','success');
                    }else{
                        $this->set('flag','failure');
                    }
                }else{
                    $this->set('flag','noMatch');
                }
            }
        }else{
            $this->set('flag',$_POST);
        }
    }
    function del(){
        $this->doNotRenderHeader = 1;
        if(!empty($_POST)&&!empty($_POST['userid'])&&!empty($_POST['usertoken'])&&!empty($_POST['commentid'])){
            $checkSql = "select username,name,admin,status from users where id={$_POST['userid']}";
            $checkResult = $this->Comment->common($checkSql);
            if(!empty($checkResult)&&!empty($checkResult['username'])){
                $realToken = md5($checkResult['username'].CURRENT_TIME.BASE_PATH.'/admin/login'.$_COOKIE['PHPSESSID']);
                if($realToken == $_POST['usertoken']){
                    $sql = "delete from comments where id={$_POST['commentid']}";
                    $ok = $this->Comment->delete($sql);
                    if($ok == 1){
                        $this->set('flag','success');
                    }else{
                        $this->set('flag','failure');
                    }
                }else{
                    $this->set('flag','noMatch');
                }
            }
        }else{
            $this->set('flag','error');
        }
    }
    function afterAction() {

    }
}


