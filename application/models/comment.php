<?php

class Comment extends BaseModel {
    function verify($arr) {
        if(count($arr)==2 && !empty($arr['user']) && !empty($arr['pass'])){
        	$user = mysqli_real_escape_string($this->_dbHandle,$arr['user']);
            $query="select id,username,name,admin,status from users where (username=? or email=?) and password=?";
        	$stmt=$this->_dbHandle->prepare($query);
        	$stmt->bind_param('sss',$arr['user'],$arr['user'],$arr['pass']);
        	$stmt->execute();
        	$stmt->bind_result($id,$username,$name,$admin,$status);
        	$stmt->fetch();
        	$result = array('userid'=>$id,'username'=>$username,'name'=>$name,'admin'=>$admin,'status'=>$status);
        	$stmt->close();
        	return $result;
        }else{
            return null;
        }
    }
    function common($query){
        $this->_result = mysqli_query($this->_dbHandle,$query);
        $result = mysqli_fetch_assoc($this->_result);
        mysqli_free_result($this->_result);
        return ($result);   
    }
    function delete($query=null){
        $this->_result = mysqli_query($this->_dbHandle,$query);
        return mysqli_affected_rows($this->_dbHandle);
    }
}
