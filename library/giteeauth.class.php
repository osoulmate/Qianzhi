<?php
class GiteeAuth
{
    protected $config = array(
        'app_name'=>'qianzhi_blog',
        'response_type'=>'code',
        'client_id'=>'01ae878158a1e7307f518521b8f44dd7553d2aa65359a7c8af01c6bed94e2404',
        'client_secret'=>'0ed9f65ddd42de696db776a7b5ff159fe910df38128d3eda204aeb2387b6ae0c',
        'redirect_uri' =>'/auth/gitee/callback',
        'scope'=>'user_info',
    );

    public function get_authorize_url()
    {
        return "https://gitee.com/oauth/authorize?client_id="
                . $this->config['client_id'] 
                . '&redirect_uri=' 
                . 'http://'.$_SERVER["SERVER_NAME"].$this->config['redirect_uri']
                . '&response_type=code';
    }

    public function get_token($code){
        //session_start();
        $ch = curl_init();
        $data = array(
            'grant_type'=>'authorization_code',
            'code'=>$code,
            'client_id'=>$this->config['client_id'],
            'redirect_uri'=>'http://'.$_SERVER["SERVER_NAME"].$this->config['redirect_uri'],
            'client_secret'=>$this->config['client_secret'],
        );

        curl_setopt($ch, CURLOPT_URL,"https://gitee.com/oauth/token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $_SESSION['access_token'] = json_decode($server_output)->access_token;
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close ($ch);
        //$this->get_user($_SESSION['access_token']);
    }
    public function get_user($access_token){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://gitee.com/api/v5/user?access_token=".$access_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.$this->config['app_name'],'Accept: application/json'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $get_response = curl_exec($ch);
        $_SESSION['response'] = json_decode($get_response);
        curl_close($ch);
        $json_obj=json_decode($get_response);
        $json_str=json_encode($json_obj,JSON_PRETTY_PRINT);
        //echo "<pre>".$json_str."</pre>";
        //echo "<BR><BR>login_name:".$_SESSION['response']->login;
        //$this->_utils = new Utils();
        //echo $this->_utils->dump($_SESSION);
        //echo $this->_utils->dump($_SERVER);
    }
}