<?php

class User extends BaseModel {
    function trees($query){
        global $inflect;
        $this->_result = mysqli_query($this->_dbHandle,$query);
        $result = array();
        $table = array();
        $field = array();
        $tempResults = array();
        if(substr_count(strtoupper($query),"SELECT")>0) {
            if (mysqli_num_rows($this->_result) > 0) {
                $numOfFields = mysqli_num_fields($this->_result);
                for ($i = 0; $i < $numOfFields; ++$i) {
                    mysqli_field_seek($this->_result,$i);
                    $fieldinfo=mysqli_fetch_field($this->_result);
                    array_push($table,$fieldinfo->table);
                    array_push($field,$fieldinfo->name);
                }
                    while ($row = mysqli_fetch_row($this->_result)) {
                        for ($i = 0;$i < $numOfFields; ++$i) {
                            $table[$i] = ucfirst($inflect->singularize($table[$i]));
                            $tempResults[$table[$i]][$field[$i]] = $row[$i];
                        }
                        array_push($result,$tempResults);
                    }
            }
            mysqli_free_result($this->_result);
        }
        $this->clear();
        return($result);
    }
    function verify($arr) {
        global $inflect;
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
    function custom($query,$page = null) {
        global $inflect;
        if(!empty($page)){
            $offset = ($page-1)*10;
            $query.=' OFFSET '.$offset;
            $result=mysqli_query($this->_dbHandle,$query);
            $this->_result = mysqli_query($this->_dbHandle,$query);
    
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
    
            if(substr_count(strtoupper($query),"SELECT")>0) {
                if (mysqli_num_rows($this->_result) > 0) {
                    $numOfFields = mysqli_num_fields($this->_result);
                    for ($i = 0; $i < $numOfFields; ++$i) {
                        mysqli_field_seek($this->_result,$i);
                        $fieldinfo=mysqli_fetch_field($this->_result);
                        array_push($table,$fieldinfo->table);
                        array_push($field,$fieldinfo->name);
                    }
                    while ($row = mysqli_fetch_row($this->_result)) {
                        for ($i = 0;$i < $numOfFields; ++$i) {
                            $table[$i] = ucfirst($inflect->singularize($table[$i]));
                            $tempResults[$table[$i]][$field[$i]] = $row[$i];
                        }
                        array_push($result,$tempResults);
                    }
                }
                mysqli_free_result($this->_result);
            }   
            $this->clear();
            return($result);  
        }else{
            $this->_result = mysqli_query($this->_dbHandle,$query);
    
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
    
            if(substr_count(strtoupper($query),"SELECT")>0) {
                if (mysqli_num_rows($this->_result) > 0) {
                    $numOfFields = mysqli_num_fields($this->_result);
                    for ($i = 0; $i < $numOfFields; ++$i) {
                        mysqli_field_seek($this->_result,$i);
                        $fieldinfo=mysqli_fetch_field($this->_result);
                        array_push($table,$fieldinfo->table);
                        array_push($field,$fieldinfo->name);
                    }
                        while ($row = mysqli_fetch_row($this->_result)) {
                            for ($i = 0;$i < $numOfFields; ++$i) {
                                $table[$i] = ucfirst($inflect->singularize($table[$i]));
                                $tempResults[$table[$i]][$field[$i]] = $row[$i];
                            }
                            array_push($result,$tempResults);
                        }
                }
                mysqli_free_result($this->_result);
            }   
            $this->clear();
            return($result);  
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
    function dumpTable($table) 
    {
      
      $tabledump = "DROP TABLE IF EXISTS {$table};\n";
      $createtable = mysqli_query($this->_dbHandle,"SHOW CREATE TABLE {$table}");
      $create = mysqli_fetch_array($createtable);
      $tabledump .= $create[1].";\n\n";

      $this->_result = mysqli_query($this->_dbHandle,"SELECT * FROM {$table}");

      $numOfFields = mysqli_num_fields($this->_result);

      while ($row = mysqli_fetch_row($this->_result)) 
      {
        $comma = "";
        $tabledump .= "INSERT INTO {$table} VALUES(";
        for($i = 0; $i < $numOfFields; $i++){
          $tabledump .= $comma."'".$this->filter($row[$i])."'";
          $comma = ",";
        }
        $tabledump .= ");\n";
      }
    
      $tabledump .= "\n";
      return $tabledump;
    }
}