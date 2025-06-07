<?php

class Category extends BaseModel {
	var $hasMany = array('Article' => 'Article');
	var $hasOne = array('Parent' => 'Category');
    function single($query = null){
        $this->_result = mysqli_query($this->_dbHandle,$query);
        if(substr_count(strtoupper($query),"SELECT")>0) {
            if (mysqli_num_rows($this->_result) > 0) {
                $numOfFields = mysqli_num_fields($this->_result);                
                if($numOfFields == 1){
                    $result = mysqli_fetch_assoc($this->_result);
                    return $result;
                }
            }
        }        
    }
    function custom($query = null) {
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
}
