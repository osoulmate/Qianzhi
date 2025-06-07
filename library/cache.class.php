<?php
class Cache {

    function get($fileName,$path=null) {
        if(empty($path)){
            $fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
        }else{
            $fileName = $path.$fileName;
        }      
        if (file_exists($fileName)) {
            $handle = fopen($fileName, 'rb');
            $variable = fread($handle, filesize($fileName));
            fclose($handle);
            return unserialize($variable);
        } else {
            return null;
        }
    }
    
    function set($fileName,$variable,$path=null) {
        if(empty($path)){
            $fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
            $handle = fopen($fileName, 'a');
            fwrite($handle, serialize($variable));
        }else{
            $fileName = $path.$fileName;
            $handle = fopen($fileName, 'a');
            fwrite($handle, $variable);
        }   

        fclose($handle);
    }

}
