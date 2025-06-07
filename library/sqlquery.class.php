<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;
    protected $_query;
    protected $_table;

    protected $_describe = array();

    protected $_orderBy;
    protected $_order;
    protected $_extraConditions;
    protected $_hO;
    protected $_hM;
    protected $_hMABTM;
    protected $_page;
    protected $_flag;
    protected $_limit;

    /** Connects to database **/
    
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysqli_connect($address, $account, $pwd);
        if ($this->_dbHandle) {
            if (mysqli_select_db($this->_dbHandle,$name)) {
            	$this->_dbHandle->query('set names utf8');
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }
 
    /** Disconnects from database **/

    function disconnect() {
        if (@mysqli_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }

    /** Select Query **/

    function where($field, $value) {
        $this->_extraConditions .= '`'.$this->_model.'`.`'.$field.'` = \''.mysqli_real_escape_string($this->_dbHandle,$value).'\' AND ';
    }

    function like($field, $value) {
        $this->_extraConditions .= '`'.$this->_model.'`.`'.$field.'` LIKE \'%'.mysqli_real_escape_string($this->_dbHandle,$value).'%\' AND ';
    }

    function showHasOne() {
        $this->_hO = 1;
    }

    function showHasMany() {
        $this->_hM = 1;
    }

    function showHMABTM() {
        $this->_hMABTM = 1;
    }

    function setLimit($limit) {
        $this->_limit = $limit;
    }

    function setPage($page) {
        $this->_page = $page;
    }
    function setFlag($flag) {
        $this->_flag = $flag;
    }
    function orderBy($orderBy, $order = 'ASC') {
        $this->_orderBy = $orderBy;
        $this->_order = $order;
    }

    function search() {

        global $inflect;

        $from = '`'.$this->_table.'` as `'.$this->_model.'` ';
        $conditions = '\'1\'=\'1\' AND ';
        $conditionsChild = '';
        $fromChild = '';

        if ($this->_hO == 1 && isset($this->hasOne)) {
            
            foreach ($this->hasOne as $alias => $model) {
                $table = strtolower($inflect->pluralize($model));
                $singularAlias = strtolower($alias);
                $from .= 'LEFT JOIN `'.$table.'` as `'.$alias.'` ';
                $from .= 'ON `'.$this->_model.'`.`'.$singularAlias.'_id` = `'.$alias.'`.`id`  ';
            }
        }
    

        if ($this->_extraConditions) {
            $conditions .= $this->_extraConditions;
        }

        $conditions = substr($conditions,0,-4);
        
        if (isset($this->_orderBy)) {
            $conditions .= ' ORDER BY `'.$this->_model.'`.`'.$this->_orderBy.'` '.$this->_order;
        }
        
        $this->_query = 'SELECT * FROM '.$from.' WHERE '.$conditions;
        #echo '<!--'.$this->_query.'-->';
        $this->_result = mysqli_query($this->_dbHandle,$this->_query);
        $result = array();
        $table = array();
        $field = array();
        $tempResults = array();
        $numOfFields = mysqli_num_fields($this->_result);
        for ($i = 0; $i < $numOfFields; ++$i) {
            mysqli_field_seek($this->_result,$i);
            $fieldinfo=mysqli_fetch_field($this->_result);
            array_push($table,$fieldinfo->table);
            array_push($field,$fieldinfo->name);
        }
        if (mysqli_num_rows($this->_result) > 0 ) {
            while ($row = mysqli_fetch_row($this->_result)) {
                for ($i = 0;$i < $numOfFields; ++$i) {
                    $tempResults[$table[$i]][$field[$i]] = $row[$i];
                }
                if ($this->_hM == 1 && isset($this->hasMany)) {
                    foreach ($this->hasMany as $aliasChild => $modelChild) {
                        $queryChild = '';
                        $conditionsChild = '';
                        $fromChild = '';
                        $tableChild = strtolower($inflect->pluralize($modelChild));
                        $pluralAliasChild = strtolower($inflect->pluralize($aliasChild));
                        $singularAliasChild = strtolower($aliasChild);
                        $fromChild .= '`'.$tableChild.'` as `'.$aliasChild.'`';
                        $id = null;
                        if ($this->name==$tempResults[$this->_model]['name']) {
                            $sql = 'select id from categories where name = \''.$this->name.'\'';
                            $resultId = mysqli_query($this->_dbHandle,$sql);
                            $rowsId=mysqli_fetch_assoc($resultId);
                            $id = $rowsId['id'];
                        }
                        $conditionsChild .= '`'.$aliasChild.'`.`'.strtolower($this->_model).'_id` = \''.$id.'\'';
                        if(isset($this->_flag)) {
                            $conditionsChild .= ' AND  '.$this->_flag.'';
                        }
                        if (isset($this->_page)) {
                            $offset = ($this->_page-1)*$this->_limit;
                            $conditionsChild .= ' ORDER BY date DESC LIMIT '.$this->_limit.' OFFSET '.$offset;
                        }
                        //$this->queryChild =  'SELECT '.$aliasChild.'.id,'.$aliasChild.'.title,'.$aliasChild.'.category_id FROM '.$fromChild.' WHERE '.$conditionsChild;
                        $this->queryChild =  'SELECT * FROM '.$fromChild.' WHERE '.$conditionsChild; 
                        #echo '<!--'.$queryChild.'-->';
                        $resultChild = mysqli_query($this->_dbHandle,$this->queryChild);
                
                        $tableChild = array();
                        $fieldChild = array();
                        $tempResultsChild = array();
                        $resultsChild = array();
                        
                        if (mysqli_num_rows($resultChild) > 0) {
                            $numOfFieldsChild = mysqli_num_fields($resultChild);
                            for ($j = 0; $j < $numOfFieldsChild; ++$j) {
                                mysqli_field_seek($resultChild,$j);
                                $fieldinfo=mysqli_fetch_field($resultChild);
                                array_push($tableChild,$fieldinfo->table);
                                array_push($fieldChild,$fieldinfo->name);
                            }

                            while ($rowChild = mysqli_fetch_row($resultChild)) {
                                for ($j = 0;$j < $numOfFieldsChild; ++$j) {
                                    $tempResultsChild[$tableChild[$j]][$fieldChild[$j]] = $rowChild[$j];
                                }
                                array_push($resultsChild,$tempResultsChild);
                            }
                        }
                        
                        $tempResults[$aliasChild] = $resultsChild;
                        
                        mysqli_free_result($resultChild);
                    }
                }
                array_push($result,$tempResults);
            }

            if (mysqli_num_rows($this->_result) == 1 && $this->id != null) {
                mysqli_free_result($this->_result);
                $this->clear();
                return($result[0]);
            } else {
                mysqli_free_result($this->_result);
                $this->clear();
                return($result);
            }
        } else {
            mysqli_free_result($this->_result);
            $this->clear();
            return $result;
        }

    }

    /** Custom SQL Query **/

    function custom($query) {

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

    /** Describes a Table **/

    protected function _describe() {
        global $cache;

        $this->_describe = $cache->get('describe'.$this->_table);

        if (!$this->_describe) {
            $this->_describe = array();
            $query = 'DESCRIBE '.$this->_table;
            $this->_result = mysqli_query($this->_dbHandle,$query);
            while ($row = mysqli_fetch_row($this->_result)) {
                 array_push($this->_describe,$row[0]);
            }

            mysqli_free_result($this->_result);
            $cache->set('describe'.$this->_table,$this->_describe);
        }

        foreach ($this->_describe as $field) {
            $this->$field = null;
        }
    }

    /** Delete an Object **/

    function delete() {
        if ($this->id) {
            $query = 'DELETE FROM '.$this->_table.' WHERE `id`=\''.mysqli_real_escape_string($this->_dbHandle,$this->id).'\'';      
            $this->_result = mysqli_query($this->_dbHandle,$query);
            $this->clear();
            if ($this->_result == 0) {
                /** Error Generation **/
                return -1;
           }
        } else {
            /** Error Generation **/
            return -1;
        }
        
    }

    /** Saves an Object i.e. Updates/Inserts Query **/

    function save($query = null) {
        $this->_result = mysqli_query($this->_dbHandle,$query);
        $this->clear();
        if ($this->_result == 0) {
            /** Error Generation **/
            return -1;
        }
    }
 
    /** Clear All Variables **/

    function clear() {
        foreach($this->_describe as $field) {
            $this->$field = null;
        }

        $this->_orderby = null;
        $this->_extraConditions = null;
        $this->_hO = null;
        $this->_hM = null;
        $this->_hMABTM = null;
        $this->_page = null;
        $this->_flag = null;
        $this->_order = null;
    }

    /** Pagination Count **/

    function totalPages($categoryName) {
        if ($this->queryChild && $this->_limit) {
            $sql = 'select id from categories where name = \''.$categoryName.'\'';
            $resultId = mysqli_query($this->_dbHandle,$sql);
            $rowsId=mysqli_fetch_assoc($resultId);
            $id = $rowsId['id'];
            $pattern = '/SELECT (.*?) FROM (.*) WHERE (.*) LIMIT(.*)/i';
            $replacement = 'SELECT COUNT(*) FROM $2 WHERE category_id=\''.$id.'\' and flag<>-1 ';
            $countQuery = preg_replace($pattern, $replacement, $this->queryChild);
            $this->_result = mysqli_query($this->_dbHandle,$countQuery);
            $count = mysqli_fetch_row($this->_result);
            $totalPages = ceil($count[0]/$this->_limit);
            return $totalPages;
        } else {
            /* Error Generation Code Here */
            return -1;
        }
    }

    /** Get error string **/
    function filter($query) {
        return mysqli_real_escape_string($this->_dbHandle,$query);
    }
    function getError() {
        return mysqli_error($this->_dbHandle);
    }
}

