<?php
require_once (ROOT . DS . 'config' . DS . 'menu.php');

class UsersController extends BaseController {
    function setMenu($menuData,$url){
        if (!is_array($menuData)){
            return 'is not array';
        }
        foreach ($menuData as $key => $value) {
            if($value['url'] == '#'){
                foreach ($value['sub'] as $k => $v) {
                    if($v['url'] == $url){
                        $menuData[$key]['status'] = 1;
                        $menuData[$key]['sub'][$k]['status'] = 1;
                    }
                }
            }else {
                if($value['url'] == $url){
                    $menuData[$key]['status'] = 1;
                }else{
                    $menuData[$key]['status'] = 0;
                }
            }
        }
        return $menuData;
    }
    function authByGitee(){
        $this->_gitee = new GiteeAuth();
        $queryString=explode("?",$_SERVER['REQUEST_URI']);
        $queryString=explode("=",$queryString[1]);
        $code=$queryString[1];
        //echo $this->_utils->dump($queryString);
        $this->_gitee->get_token($code);
        if($_SESSION['access_token']){
            $this->_gitee->get_user($_SESSION['access_token']);
            $name=$_SESSION['response']->name;
            //echo $this->_utils->dump($_SESSION['response']);
            $username=$_SESSION['response']->login;
            $email=$_SESSION['response']->email;
            if(!$email){
                $email=$username.'@gitee.com';
            }
            $sql = "select id from users where username='{$username}'";
            $users = $this->User->custom($sql);
            if(empty($users)){
                $regtime = time();
                $password=md5($username);
                $token = md5($username.$password.$regtime); //创建用于激活识别码
                $token_exptime = time()+60*60*24;//过期时间为24小时后
                $sql = "insert into users (name,email,username,password,registry_date,token,token_expire_time,registry_source) ";
                $sql.= " values('{$name}','{$email}','{$username}','{$password}',from_unixtime({$regtime}),'{$token}',from_unixtime({$token_exptime}),'gitee')";
                $this->User->save($sql);
                $sql = "select id from users where username='{$username}'";
                $users = $this->User->custom($sql);
            }
            if ($_SESSION['response']->name){
                $token=md5($_SESSION['response']->login.CURRENT_TIME.BASE_PATH.'/admin/login'.$_COOKIE['PHPSESSID']);
                $name=$_SESSION['response']->name;
                $id=$users[0]['User']['id'];
                header("Set-Cookie:newtoken=" . 
                    $token . "; expires=" . 
                    gmstrftime("%a, %d-%b-%Y %H:%M:%S GMT", time() + 3600*24) . 
                    "; Max-Age=3600; path=/; domain= ".$_SERVER['SERVER_NAME'].";");
                header("Set-Cookie:name=" . 
                    $name . "; expires=" . 
                    gmstrftime("%a, %d-%b-%Y %H:%M:%S GMT", time() + 3600*24) . 
                    "; Max-Age=3600; path=/; domain= ".$_SERVER['SERVER_NAME'].";",FALSE);
                header("Set-Cookie:id=" . 
                    $id . "; expires=" . 
                    gmstrftime("%a, %d-%b-%Y %H:%M:%S GMT", time() + 3600*24) . 
                    "; Max-Age=3600; path=/; domain= ".$_SERVER['SERVER_NAME'].";",FALSE);
                header("location:".$_SESSION['origURL']."#comment-area");
            }
        }
    }
    function authByGithub(){
        
    }
    function authByWeixin(){
        
    }
    function beforeAction () {
        session_start();
        //  会话保存24小时
        $lifeTime = 24*3600;
        setcookie(session_name(), session_id(), time() + $lifeTime, "/");
        //echo ini_get('session.save_path');
        /*
        登录流程：
        1.用户访问登录页面/admin/login，显示登录页面
        2.浏览器显示登录页面时，同时发送异步请求/admin/check?t=microtime()。
        3.异步请求成功则行为识别可用
        4.用户输入用户名和密码，并通过机器识别认证后，点击登录按钮后触发click事件
        5.click事件向/admin/verfify接口发送POST认证请求
        6.POST认证请求成功，设置$_SESSION["loginSuccess"]为true。
         */
        if($_SERVER['REQUEST_URI']!="/admin/login"
            &&$_SERVER['REQUEST_URI']!="/admin/verify"
            &&$_SERVER['REQUEST_URI']!="/admin/check?t=microtime()"
            &&$_SERVER['REQUEST_URI']!="/admin/registry"
            &&$_SERVER['REQUEST_URI']!="/admin/regCheck"
            &&(!preg_match("/admin\/active/i",$_SERVER['REQUEST_URI']))
            &&(!preg_match("/getpass/i",$_SERVER['REQUEST_URI']))
            &&(!preg_match("/auth/i",$_SERVER['REQUEST_URI']))){
            if (isset($_SESSION["loginSuccess"]) && $_SESSION["loginSuccess"] === true) {
                //登录成功后获取菜单列表
                $this->menuObj   = new MenuConfig();
                $this->_utils = new Utils();
                $clickUrl = $_SERVER['REQUEST_URI'];
                $clickUrl = substr($clickUrl,1);
                $newMenu = $this->setMenu($this->menuObj->menu, $clickUrl);
                $this->set('menu', $newMenu);
            } else {
                $_SESSION["loginSuccess"] = false;
                die("访问警告:未授权的访问，可能面临法律风险!");
            }
        }
        //$this->menuObj   = new MenuConfig();
        //$this->_utils = new Utils();
        //$clickUrl = $_SERVER['REQUEST_URI'];
        //$clickUrl = substr($clickUrl,1);
        //$newMenu = $this->setMenu($this->menuObj->menu, $clickUrl);
        //$this->set('menu', $newMenu);
        //echo ini_get('session.cookie_path');
        //echo $this->_utils->dump($_SERVER);
        //echo $this->_utils->dump($clickUrl);

    }
    /*第三方登录认证方法*/
    function auth($source = null,$callback = null,$extra=null) {
        $this->doNotRenderHeader = 1;
        //$this->_utils = new Utils();
        if($callback=='callback'){
            if($source=='gitee'){
                $this->authByGitee();
            }
        }else{
            $_SESSION["origURL"] = $_SERVER["HTTP_REFERER"];
            if($source=='gitee'){
                $this->_gitee = new GiteeAuth();
                $redirect_url=$this->_gitee->get_authorize_url();
                header('Location:'.$redirect_url); 
            }
        }
        //$this->_utils->dump($_SERVER);
    }
    /*登陆页面方法*/
    function login() {
        $this->doNotRenderHeader = 1;
    }
    /*登陆页面行为识别首次验证方法*/
    function check() {
        $this->doNotRenderHeader = 1;
    }
    /*登陆页面行为识别二次验证方法*/
    function verify() {
        $this->doNotRenderHeader = 1;
        if(!empty($_POST)){
            $user=trim($_POST['user']);
            $password_hash=trim($_POST['password']);
            $arr = array('user'=>$user,'pass'=>$password_hash);
            $result = $this->User->verify($arr);
            if(!empty($result)){
                $token=md5($result['username'].CURRENT_TIME.BASE_PATH.'/admin/login');
                $this->set('userid',$result['userid']);
                $this->set('username',$result['username']);
                $this->set('admin',$result['admin']);
                $this->set('status',$result['status']);
                $this->set('token',$token);
            }else{
                $this->set('userid','');
                $this->set('username','');
                $this->set('admin','');
                $this->set('status','');
                $this->set('token','');
            }
        }
    }
    /*找回密码方法*/
    function getpass($send = null){
        $this->doNotRenderHeader = 1;
        if(isset($send)&&$send == 'send'){
            $this->set('callback','success');
            $code='';
            for($i=0;$i<4;$i++){
                $code.=dechex(mt_rand(0,15));
            }
            $this->set('code',$code);
            $query = "select id from users where email='{$_POST['pctel']}'";
            $users = $this->User->custom($query);
            if(empty($users)){
                $this->set('flag','该邮箱尚未注册');
            }else{
                $this->set('email',$_POST['pctel']);
            }
        }elseif(isset($send)&&$send == 'next'){
            $this->set('callback','next');
            $this->set('code',$_POST['code']);
        }elseif(isset($send)&&$send == 'reset'){
            $this->set('callback','reset');
            $email = $_POST['pctel'];
            $pass = md5($_POST['newpass']);
            $query = "update users set password='{$pass}' where email='{$email}'";
            $ok = $this->User->save($query);
            if($ok != -1){
                $this->set('success','success');
            }
        }else{
            $this->set('callback','no');
        }
    }
    /*注册方法*/
    function registry(){
        $this->doNotRenderHeader = 1;
        if(empty($_POST)){
            $this->set('render','ok');
        }else{
            $this->set('render','two');
            if(!empty($_POST['username'])&&!empty($_POST['email'])&&!empty($_POST['password'])){
                $result=filter_var(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
                if($result){
                    $username = $this->User->filter($_POST['username']);
                    $password = md5($_POST['password']); //
                    $regtime = time();
                    $token = md5($username.$password.$regtime); //创建用于激活识别码
                    $token_exptime = time()+60*60*24;//过期时间为24小时后
                    $sql = "insert into users (name,email,username,password,registry_date,token,token_expire_time) ";
                    $sql.= " values('{$username}','{$_POST['email']}','{$username}','{$password}',from_unixtime({$regtime}),'{$token}',from_unixtime({$token_exptime}))";
                    $ok = $this->User->save($sql);
                    if($ok != -1){
                        $this->set('ok','ok');
                        $this->set('email',$_POST['email']);
                        $this->set('username',$username);
                        $this->set('token',$token);
                    }
                }
            } 
        }
    }
    /*注册表单内容检查方法*/
    function regCheck() {
        $this->doNotRenderHeader = 1;
        if(!empty($_POST['username'])){
            $sql = "select username from users where username='{$_POST['username']}'";
            $users = $this->User->custom($sql);
            if(empty($users)){
                $this->set('flag','用户名可用');
            }else{
                $this->set('flag','该用户名已占用');
            }
        }elseif (!empty($_POST['email'])) {
            $result=filter_var(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if($result){
                $sql = "select email from users where email='{$_POST['email']}'";
                $users = $this->User->custom($sql);
                if(empty($users)){
                    $this->set('flag','邮箱可用');
                }else{
                    $this->set('flag','该邮箱已注册');
                }                
            }else{
                $this->set('flag','邮箱格式错误');
            }

        }elseif (!empty($_POST['pass'])) {
            if (strlen($_POST['pass']) < 8 ){
                $this->set('flag','密码不能少于8位');
            }
            if(strlen($_POST['pass']) > 20){
                $this->set('flag','密码不能大于20位');
            }
            if (strlen($_POST['pass']) >= 8 && strlen($_POST['pass']) <=20){
                $this->set('flag','密码有效');
            }

        }else{
            $this->set('flag','错误');
        }

    }
    /*用户账号激活方法*/
    function active($token = null){
        $this->doNotRenderHeader = 1;
        if(!empty($token)){
            $nowtime = time();
            $query = "select id,name,email,registry_date,token,unix_timestamp(token_expire_time) as expire_time,status from users  where status=0 and token='{$token}'";
            $result = $this->User->common($query);
            if(!empty($result)){
                if($nowtime>$result['expire_time']){
                    $msg = '您的激活有效期已过，请重新注册.';
                    $query="delete from users where status=0 and token='{$token}'";
                    $ok = $this->User->delete($query);
                    $this->set('flag',$msg);
                }else{
                    $query="update users set status=1 where id='{$result['id']}'";
                    $ok = $this->User->save($query);
                    $this->set('flag','激活成功!');
                }
            }else{
                $this->set('flag','验证失败');
            }
        }
    }
    /*后台主页面 方法*/
    function index(){
        $levelOneNumber = $this->User->common('select count(id) as num from categories where parent_id=0');
        $levelTwoNumber = $this->User->common('select count(id) as num from categories where parent_id<>0');
        $postNumber = $this->User->common('select count(id) as num from articles where flag<>-1');
        $recycleNumber = $this->User->common('select count(id) as num from articles where flag=-1'); 
        $this->set('levelOneNumber',$levelOneNumber['num']);
        $this->set('levelTwoNumber',$levelTwoNumber['num']);
        $this->set('postNumber',$postNumber['num']);
        $this->set('recycleNumber',$recycleNumber['num']); 
        $this->set('htmlTitle','千知后台-首页');   
    }
    /*<文章管理>方法*/
    function wzgl($subaction=null,$name=null,$id=null){
        $this->set('action',$subaction);
        $this->set('location','wzgl/'.$subaction);
        if(empty($subaction) || $subaction == 'list'){
            /*<文章管理/文章列表>视图*/
            $this->set('htmlTitle','千知后台-文章列表');
            $this->set('name','文章管理/文章列表');
            if(empty($id)){
                $pagenum = 1;
            }else{
                $pagenum = $id;
            }
            $query = "SELECT articles.*,categories.name FROM articles,categories ";
            $query.= " WHERE articles.category_id=categories.id AND  articles.flag<>-1 ORDER BY articles.date DESC LIMIT 10";
            $articles = $this->User->custom($query,$pagenum);
            $postNumber = $this->User->common('select count(id) as num from articles where flag<>-1');
            $this->set('postNumber',$postNumber['num']);
            $this->set('articles',$articles);
            $this->set('page',$pagenum);           
        }elseif($subaction == 'hsz'){
            /*<文章管理/回收站>视图*/
            $this->set('htmlTitle','千知后台-回收站');
            $this->set('name','文章管理/回收站');
            if(empty($id)){
                $pagenum = 1;
            }else{
                $pagenum = $id;
            }
            $query = "SELECT articles.id,articles.title,articles.author,articles.hits,articles.date,categories.name ";
            $query .= " FROM articles,categories WHERE articles.category_id=categories.id and articles.flag=-1 order by articles.date desc limit 10";
            $recycle = $this->User->custom($query,$pagenum);
            $this->set('recycle',$recycle);
    
            $this->set('page',$pagenum);
            $postNumber = $this->User->common('select count(id) as num from articles where flag=-1');
            $this->set('postNumber',$postNumber['num']);             
        }elseif($subaction == 'del'){
            /*<文章管理/回收站>删除文章功能（从数据库中删除）*/
            if(!empty($id)){
                $ok = $this->User->delete("delete from articles where id={$id}");
                $this->set('ok','wzgl/hsz');
            }
        }elseif($subaction == 'update'){
            /*<文章管理/文章列表>删除文章功能（移入回收站）*/
            if(!empty($id)){
                $ok = $this->User->save("update articles set flag=-1 where id={$id}");
                $this->set('ok','wzgl/list');
            }else{
                $this->set('ok','wzgl/list');                    
            }
        }elseif ($subaction == 'recovery') {
            /*<文章管理/回收站>文章恢复功能（从回收站移入文章列表）*/
            if(!empty($id)){
                $ok = $this->User->save("update articles set flag=0 where id={$id}");
                $this->set('ok','wzgl/hsz');
            }else{
                /*<文章管理/显示与置顶>功能*/
                if(!empty($_POST['id'])){
                    $id = $_POST['id'];
                    $flag = $_POST['flag'];
                    $ok = $this->User->save("update articles set {$flag} where id={$id}");                   
                }
            }
        }elseif ($subaction == 'edit') {
            /*<文章管理/编辑文章>功能*/
            $indexTrees = $this->User->trees("select * from categories as son left join categories as parent on son.parent_id=parent.id");
            $this->set('users',$indexTrees);
            if (!empty($id)) {
                $article = $this->User->custom('select id,category_id,title,content,flag,isview from articles where id='.$id);
                $this->set('article',$article[0]);
            }  
        }elseif ($subaction == 'preview') {
            /*<文章管理/预览文章>功能*/
            if (!empty($id)) {
                $article = $this->User->custom('select * from articles where id='.$id);
                $this->set('preview',$article[0]);
            }   
        }else{
            $this->set('ok','index');
        }
    }
    /*评论管理方法*/
    function plgl($view=null,$name=null,$id=null){
        $this->set('view',$view);
        $this->set('location','plgl/'.$view);
        if($view == 'list'){
            /*<评论管理/评论列表>视图*/
            $this->set('htmlTitle','千知后台-评论列表');
            $this->set('name','评论管理/评论列表');
            if(empty($id)){
                $pagenum = 1;
            }else{
                $pagenum = $id;
            }
            $query = "SELECT comments.id,comments.parent_id,articles.title,comments.content,comments.date,users.username ";
            $query .=" FROM comments,articles,users WHERE comments.article_id=articles.id and comments.user_id=users.id order by id desc limit 10";;
            $comments = $this->User->custom($query,$pagenum);
            $commentsTotalNum = $this->User->common('select count(id) as num from comments');
            $this->set('postNumber',$commentsTotalNum['num']);
            $this->set('comments',$comments);
            $this->set('page',$pagenum);
        }elseif($view == 'del'){
        	if(!empty($id)){
        		$query = "delete from comments where id = {$id}";
        		$ok = $this->User->delete($query);
                $this->set('ok','plgl/list');

        	}
        }
        else{
            $this->set('ok','index');
        }
    }
    /*栏目管理方法*/
    function lmgl($subaction=null,$name=null,$id=null){
        $this->set('action',$subaction);
        $this->set('location','lmgl/'.$subaction);
        $categories = $this->User->trees("select * from categories as son left join categories as parent on son.parent_id=parent.id");
        $this->set('categories',$categories);

        if(empty($subaction) || $subaction == 'list'){
            /*<栏目管理/栏目列表>视图*/
            $this->set('htmlTitle','千知后台-栏目列表');
            $this->set('name','栏目管理/栏目列表');
        }elseif($subaction == 'add'){
             /*<栏目管理/添加栏目>功能*/
             $this->set('htmlTitle','千知后台-添加栏目');
             $this->set('name','栏目管理/添加栏目');
            if(isset($_POST['name'])&&!empty(trim($_POST['name']))){
                if($_POST['typeid']=='one'){
                    $query = "insert into categories(name,parent_id) values('{$_POST['name']}',0)";
                    $ok = $this->User->save($query);
                }else{
                    $query = "insert into categories(name,parent_id) values('{$_POST['name']}','{$_POST['typeid']}')";
                    $ok = $this->User->save($query);
                }
                $this->set('ok','lmgl/list');
            }else{
                $this->set('add','请填写分类名');
            }
        }elseif($subaction == 'modify'){
            $this->set('htmlTitle','千知后台-修改栏目');
            $this->set('name','栏目管理/修改栏目');
             /*<栏目管理/修改栏目>功能*/
            if(isset($_POST['newname'])&&!empty(trim($_POST['newname']))){
                 $query = "update categories set name='{$_POST['newname']}' where id='{$_POST['typeid']}'";
                 $ok = $this->User->save($query);
                 $this->set('ok','lmgl/list');
            }else{
                if(!empty($id)){
                    $query = "select * from categories as son left join categories as parent on son.parent_id=parent.id where son.id={$id}";
                    $result = $this->User->trees($query);
                    $result = $result[0];
                    $this->set('temp',$result);
                    $this->set('son',$result['Son']['name']);
                    $this->set('sonid',$result['Son']['id']);
                }
            }
        }elseif($subaction == 'del'){
             /*<栏目管理/删除栏目>视图*/
            if(isset($_POST['id'])&&!empty(trim($_POST['id']))){
                $query = "delete from  categories where id='{$_POST['id']}'";
                $ok = $this->User->delete($query);
                if($ok!=0){
                    $this->set('ok','lmgl/list');
                }
            }        
        }else{
            $this->set('ok','index');
        }   
    }
    /*<系统管理>方法*/
    function system($view=null,$action=null){
        $this->set('view',$view);
        $this->set('location','system/'.$view);
        $this->set('name','');
        if($view == 'setup'){
             /*<系统管理/系统设置>功能*/
             $this->set('htmlTitle','千知后台-系统设置');
             $this->set('name','系统管理/系统设置');
             if(empty($action)){
                $query = "select * from systems";
                $systems = $this->User->custom($query);
                $this->set('systems',$systems[0]);                
             }else{
                $name=$this->User->filter($_POST['siteName']);
                $indexLimit=$_POST['siteIndexLimit'];  
                $classLimit=$_POST['siteClassLimit'];  
                $yearLimit=$_POST['siteYearLimit'];  
                $monthLimit=$_POST['siteMonthLimit'];  
                $dayLimit=$_POST['siteDayLimit'];  
                $searchLimit=$_POST['siteSearchLimit'];    
                $copy=$this->User->filter($_POST['siteCopy']);
                $query = "UPDATE systems SET name='{$name}',index_view_items_limit='{$indexLimit}',class_view_items_limit='{$classLimit}',";
                $query.= "year_view_items_limit='{$yearLimit}',month_view_items_limit='{$monthLimit}',day_view_items_limit='{$dayLimit}', ";
                $query.= "search_view_items_limit='{$searchLimit}',copyright='{$copy}'";
                $ok = $this->User->save($query);
                $this->set('ok','system/setup');
             }

        }elseif($view == 'friend'){
            /*<系统管理/友链管理>功能*/
            $this->set('htmlTitle','千知后台-友链设置');
            $this->set('name','系统管理/友链设置');

        }elseif($view == 'nav'){
            /*<系统管理/导航管理>功能*/
            $this->set('htmlTitle','千知后台-导航管理');
            $this->set('name','系统管理/导航管理');
            
        }elseif($view == 'resetpass'){
            /*<系统管理/修改密码>功能（修改当前登录用户密码）*/
            $this->set('htmlTitle','千知后台-修改密码');
            $this->set('name','系统管理/修改密码');
            if(!empty($action) && $action=='update'){
                $passOne = $_POST['newPass'];
                $passTwo = $_POST['newPassVerify'];
                $username = trim($_COOKIE["username"]);
                if(md5($passOne)==md5($passTwo)){
                    $pass = md5($passOne);
                    $query = "update users set password='{$pass}' where username='{$username}'";
                    $ok = $this->User->save($query);
                    $this->set('message','修改成功');
                    $this->set('ok','system/resetpass');
                }else{
                    $this->set('ok','system/resetpass');
                    $this->set('message','两次输入密码不一致');
                }         
            }
        }else{
            $this->set('ok','index');
        }

    }
    /*<用户管理>方法*/
    function yhgl($view=null,$name=null,$id=null){
        $this->set('view',$view);
        $this->set('location','yhgl/'.$view);

        if(empty($view) ||$view == 'list'){
            /*<用户管理/用户列表>视图*/
            if(empty($id)){
                $pagenum = 1;
            }else{
                $pagenum = $id;
            }
            $query= "select * from users LIMIT 10";
            $users = $this->User->custom($query,$pagenum);
            $postNumber = $this->User->common('select count(id) as num from users;');
            $this->set('postNumber',$postNumber['num']);
            $this->set('users',$users);
            $this->set('page',$pagenum);
            $this->set('htmlTitle','千知后台-用户列表'); 
            $this->set('name','用户管理/用户列表');
        }elseif ($view == 'add') {
            /*<用户管理/添加用户>功能*/
            $this->set('name','千知后台/添加用户');
            $this->set('htmlTitle','千知后台-添加用户');
            if(!empty($_POST)){
                $name = trim($_POST['addname']);
                $username = trim($_POST['adduser']);
                $pass = md5($_POST['addpass']);
                if(!empty($_POST['switch'])){
                    $status = 0;
                }else{
                    $status = 1;
                }
                $query = "INSERT INTO  users(username,name,password,email,admin,registry_date,token,token_expire_time,status) ";
                $query .="VALUES('{$username}','{$name}','{$pass}','kong@121.com',0,now(),'token',now(),'{$status}')";
                $ok = $this->User->save($query);
                $this->set('ok','yhgl/list');                    
            }
        }
        elseif($view == 'modify'){
            /*<用户管理/修改用户>功能*/
            $this->set('htmlTitle','千知后台-修改用户');
            $this->set('name','用户管理/修改用户');
            if($name == 'id' && !empty($id)){
                if(empty($_POST)){
                    $query = "select * from users where id='{$id}'";
                    $user = $this->User->custom($query);
                    $this->set('user',$user[0]);

                }else{
                    if(!empty($_POST['switch'])){
                        $status = 0;
                    }else{
                        $status = 1;
                    }
                    $name = $_POST['modifyname'];
                    $username = $_POST['modifyuser'];
                    $qq = $_POST['modifyqq'];
                    $mail = $_POST['modifymail'];
                    $tel = $_POST['modifytel'];
                    $pass = md5($_POST['modifypass']);
                    $query = "update users set  name='{$name}',username='{$username}',email='{$mail}',password='{$pass}',status='{$status}' where id = {$id}";
                    $ok = $this->User->save($query);
                    $this->set('ok','yhgl/list');
                }
            }
        }elseif($view == 'del'){
            /*<用户管理/删除用户>功能*/
            if($name == 'id' && !empty($id)){
                $query = "delete from users  where id = {$id}";
                $ok = $this->User->delete($query);
                $this->set('ok','yhgl/list');
            }
        }elseif($view == 'disable'){
            /*<用户管理/封禁用户>功能*/
            if(!empty($_POST['id'])){
                $query = "update users set status=0 where id = {$_POST['id']}";
                $this->User->save($query);
            }
        }elseif($view == 'enable'){
            /*<用户管理/启用用户>功能*/
            if(!empty($_POST['id'])){
                $query = "update users set status=1 where id = {$_POST['id']}";
                $this->User->save($query);
            }           
        }else{
                    
        }
    }
    /*<数据库管理>方法*/
    function db($view=null){
        $this->set('view',$view);
        $this->set('location','db/'.$view);
        
        if($view == 'backup'){
            /*<数据库管理/备份数据库>功能*/
            $this->set('htmlTitle','千知后台-备份数据库');
            $dbname = DB_NAME;
            $query = "select * from information_schema.tables where table_schema='{$dbname}' limit 10";
            $tables = $this->User->custom($query,1);
            $this->set('tables',$tables);
            $this->set('name','数据库/备份数据库');
        }elseif($view == 'recovery'){
            /*<数据库管理/恢复数据库>功能*/
            $this->set('htmlTitle','千知后台-还原数据库');
            $this->set('name','数据库/还原数据库');
            $backupfiles = glob(ROOT.DS.'db'.DS.'*.sql');
            $this->set('backupfiles',$backupfiles);
            if(!empty($_POST)){
            	if($_POST['action']=='rec'){

            	}else{
            		$result = unlink(ROOT.DS.'db'.DS.$_POST['id']);
            		if($result){
            			$this->doNotRenderHeader = 1;
            			$this->set('reply','删除成功');
            		}
            	}
            }
        }elseif($view == 'download'){
            $this->doNotRenderHeader = 1;
            if(!empty($_POST['id'])){
                $filename = DB_NAME.date("-YmdHis").'.sql';
                $path = ROOT.DS.'db'.DS;
        		global $cache;
                //适用于云数据库的备份方法
                if($_POST['id'] != 'all'){
 					$sqldump = $this->User->dumpTable($_POST['id']);
                }else{
                	$dbname = DB_NAME;
                    $queryTableName = "select TABLE_NAME from information_schema.tables where table_schema='{$dbname}' limit 10";
                    $tables = $this->User->custom($queryTableName,1);
                    $sqldump='';
                    foreach ($tables as $table){
                    	$sqldump .= $this->User->dumpTable($table['Table']['TABLE_NAME']);
                    }
                }
                
        		$file = $cache->get($filename,$path);
        		if (!$file) {
        		    $cache->set($filename,$sqldump,$path);
        		}

                //适用于数据库所在主机有系统登陆权限的情形
                $filename = DB_NAME.date("-YmdHis").'.sql';
                $backupFile = ROOT.DS.'db'.DS.$filename;
                if($_POST['id'] != 'all'){
                    $command = 'mysqldump --opt -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' '.DB_NAME.' '.$_POST['id'].' > '.$backupFile;	  
                }else{
                    $command = 'mysqldump --opt -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' '.DB_NAME.' > '.$backupFile;
                }
                system($command);
                $this->set('reply',BASE_PATH.DS.'db/'.$filename);
            }             
        }else{
                    
        }
    }
    function download($filename){
        $this->doNotRenderHeader = 1;
        $this->set('filename',$filename);
    }
    /*<退出登录>方法*/
    function exit() {
        $_SESSION["loginSuccess"]=false;
        setcookie('username','',time()-1);
        setcookie('admin','',time()-1);
        setcookie('token','',time()-1);
        setcookie('PHPSESSID','',time()-1);
    }
    /*<写文章>方法*/
    function write($action = null,$name=null,$id = null) {
        $users = $this->User->trees("select * from categories as son left join categories as parent on son.parent_id=parent.id");
        $this->set('users',$users);
        $this->set('htmlTitle','千知后台-发布');
        $this->set('location','write');
        $this->set('name','写文章');
        if(empty($action)){
            $this->set('title','请输入标题...');
            $this->set('content','请输入内容');  
        }elseif($action=='add'){
            $result = '';
            if(!empty($_POST['title'])){
                $title =  $this->User->filter($_POST['title']);
            }else{
                $result = '标题不能为空,';
            }
            if(!empty($_POST['content'])){
                $content = $this->User->filter($_POST['content']);;
            }else{
                $result .= '内容不能为空';
            }       
            if(!empty($_POST['top'])){
                $flag = 2;
            }else{
                $flag = 0;
            }
            if(!empty($_POST['view'])){
                $view = 1;
            }else{
                $view = 0;
            }
            $classid = $_POST['classid'];
            if(!empty($result)){
                $resultArray = array();
                $resultArray = explode(',',$result);
                $content = $resultArray[0];
                array_shift($resultArray);
                if(isset($resultArray[0])){
                    $title = $content;
                    $content = $resultArray[0];
                    $this->set('title',$title);
                    $this->set('content',$content);
                }else{
                    $this->set('title',$_POST['title']);
                    $this->set('content',$content); 
                }
            }else{
                $date=date("Y-m-d");
                $indexId =$title.$date.'qianzhi';
                $query = "INSERT INTO articles(index_id,category_id,promulgator_id,title,author,date,content,flag,isview)";
                $query.= " VALUES(md5('{$indexId}'),'{$classid}',0,'{$title}','热爱',now(),'{$content}','{$flag}','{$view}')";
                $ok = $this->User->save($query);
                if($ok != 0){
                    $this->set('title',$_POST['title']);
                    $this->set('content',$content); 
                }else{
                    $this->set('ok','wzgl/list');
                }
            }

        }elseif ($action=='update') {
            if(!empty($_POST['top'])){
                $flag = 2;
            }else{
                $flag = 0;
            }
            if(!empty($_POST['view'])){
                $view = 1;
            }else{
                $view = 0;
            }
            $content = $this->User->filter($_POST['content']);
            $title = $this->User->filter($_POST['title']);
            if(!empty($id)){
                $query = "update articles set title='{$title}',content='{$content}',
                            category_id='{$_POST['classid']}',flag={$flag},isview={$view} where id={$id}";
                $ok = $this->User->save($query);
                if($ok != -1){
                    $this->set('ok','wzgl/list');
                }else{
                    $this->set('title','更新失败');
                }
            }
        }else{
            $this->set('ok','wzgl/list');
        }

    }
    function upload_pic() {
        $this->doNotRenderHeader = 1;
        //$php_path = dirname(__FILE__) . '/';
        //$php_url = dirname($_SERVER['PHP_SELF']) . '/';
        $php_path = dirname(dirname(dirname(__FILE__)));
        //文件保存目录路径
        $save_path = $php_path . '/public/img/';
        //文件保存目录URL
        $save_url = $BASE_PATH . '/img/';
        //定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        //最大文件大小
        $max_size = 1000000;
        
        //$save_path = realpath($save_path) . '/';
        
        //PHP上传失败
        if (!empty($_FILES['imgFile']['error'])) {
            switch($_FILES['imgFile']['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            $this->alert($error);
        }
        
        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $file_name = $_FILES['imgFile']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            //文件大小
            $file_size = $_FILES['imgFile']['size'];
            //检查文件名
            if (!$file_name) {
                $this->alert("请选择文件。");
            }
            //检查目录
            if (@is_dir($save_path) === false) {
                $this->alert("上传目录".$save_path."不存在。");
            }
            //检查目录写权限
            if (@is_writable($save_path) === false) {
                $this->alert("上传目录".$save_path."没有写权限。");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                $this->alert("上传失败。");
            }
            //检查文件大小
            if ($file_size > $max_size) {
                $this->alert("上传文件大小超过限制。");
            }
            //检查目录名
            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
            if (empty($ext_arr[$dir_name])) {
                $this->alert("目录名不正确。");
            }
            //获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            //检查扩展名
            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
                $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
            }
            //创建文件夹
            if ($dir_name !== '') {
                $save_path .= $dir_name . "/";
                $save_url .= $dir_name . "/";
                if (!file_exists($save_path)) {
                    mkdir($save_path);
                }
            }
            $ymd = date("Ymd");
            $save_path .= $ymd . "/";
            $save_url .= $ymd . "/";
            if (!file_exists($save_path)) {
                mkdir($save_path);
            }
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //移动文件
            $file_path = $save_path . $new_file_name;
            if (move_uploaded_file($tmp_name, $file_path) === false) {
                $this->alert("上传文件失败。");
            }
            @chmod($file_path, 0644);
            $file_url = $save_url . $new_file_name;
        
            header('Content-type: text/html; charset=UTF-8');
            $json = new Services_JSON();
            echo $json->encode(array('error' => 0, 'url' => $file_url));
            exit;
        }
    }
    function alert($msg) {
        $this->doNotRenderHeader = 1;
        header('Content-type: text/html; charset=UTF-8');
        $json = new Services_JSON();
        echo $json->encode(array('error' => 1, 'message' => $msg));
        exit;
    }
    
    function afterAction() {

    }
}
