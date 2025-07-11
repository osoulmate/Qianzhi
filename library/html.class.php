<?php

class HTML {
    function link($text,$path,$prompt = null,$confirmMessage = "Are you sure?",$extra = null) {
        //$path = str_replace(' ','-',$path);
        //$path = str_replace('#','井',$path);
        if ($prompt) {
            $data = '<a href="javascript:void(0);" onclick="javascript:jumpTo(\''.BASE_PATH.'/'.$path.'\',\''.$confirmMessage.'\')">'.$text.'</a>';
        } else {
            $data = '<a '.$extra.' href="'.BASE_PATH.'/'.$path.'">'.$text.'</a>';  
        }
        return $data;
    }
    function url($path,$prompt = null,$confirmMessage = "Are you sure?") {
        $path = str_replace(' ','-',$path);
        if ($prompt) {
            $data = '<a href="javascript:void(0);" onclick="javascript:jumpTo(\''.BASE_PATH.'/'.$path.'\',\''.$confirmMessage.'\')">'.$text.'</a>';
        } else {
            $data = '"'.BASE_PATH.'/'.$path.'"';  
        }
        return $data;
    }
    function includeJs($fileName) {
        $data = '<script src="'.BASE_PATH.'/js/'.$fileName.'.js"></script>';
        return $data;
    }
    function includeJsEx($fileName) {
        $data = '<script src="'.BASE_PATH.'/'.$fileName.'.js"></script>';
        return $data;
    }

    function includeCss($fileName) {
        $data = '<link rel="stylesheet" href="'.BASE_PATH.'/css/'.$fileName.'.css">';
        return $data;
    }
    function includeCssEx($fileName) {
        $data = '<link rel="stylesheet" href="'.BASE_PATH.'/'.$fileName.'.css">';
        return $data;
    }
    function includeImg($fileName,$extra = null) {
        $data = '<img '.$extra.'src="'.BASE_PATH.'/img/'.$fileName.'">';
        return $data;
    }
    function includeImgEx($fileName,$extra = null) {
        $data = '<img '.$extra.'src="'.BASE_PATH.'/'.$fileName.'">';
        return $data;
    }
    function includeFacicon($fileName,$extra = null) {
        $data = '<link '.$extra.' href="'.BASE_PATH.'/'.$fileName.'">';
        return $data;
    }
    /** 
     * 截取中文字符串 
     * @param $string 字符串 
     * @param $start 起始位 
     * @param $length 长度 
     * @param $charset  编码 
     * @param $dot 附加字串 
     */ 
    function msubstr($string, $start, $length,$dot='',$charset = 'UTF-8') { 
        $string = str_replace(array('&', '"', '<', '>',' '), array('&', '"', '<', '>',' '), $string); 
        if(strlen($string) <= $length) {return $string;} 
        if(strtolower($charset) == 'utf-8') { 
            $n = $tn = $noc = 0; 
            while($n < strlen($string)){ 
                $t = ord($string[$n]); 
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)){ 
                    $tn = 1; $n++; 
                }elseif(194 <= $t && $t <= 223) { 
                  $tn = 2; $n += 2; 
                }elseif(224 <= $t && $t <= 239) { 
                  $tn = 3; $n += 3; 
                }elseif(240 <= $t && $t <= 247) { 
                  $tn = 4; $n += 4; 
                }elseif(248 <= $t && $t <= 251) { 
                  $tn = 5; $n += 5; 
                }elseif($t == 252 || $t == 253) { 
                  $tn = 6; $n += 6; 
                }else { 
                   $n++; 
                } 
                $noc++; 
                if($noc >= $length) {break;} 
            } 
            if($noc > $length) { $n -= $tn; } 
            $strcut = substr($string, 0, $n); 
        }else { 
            for($i = 0; $i < $length; $i++) {$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];} 
        }     
        return $strcut.$dot; 
    } 
 
    /*取得字符串的长度，包括中英文*/ 
    function mstrlen($str,$charset = 'UTF-8'){ 
        if(function_exists('mb_substr')) { 
            $length=mb_strlen($str,$charset); 
        }elseif (function_exists('iconv_substr')) { 
            $length=iconv_strlen($str,$charset); 
        }else {
            preg_match_all("/[x01-x7f]|[xc2-xdf][x80-xbf]|xe0[xa0-xbf][x80-xbf]|[xe1-xef][x80-xbf][x80-xbf]|xf0[x90-xbf][x80-xbf][x80-xbf]|[xf1-xf7][x80-xbf][x80-xbf][x80-xbf]/", $text, $ar);   
            $length=count($ar[0]); 
        } 
        return $length; 
    }
    function subHtml($html,$length) { 
        $result = ''; 
        $tagStack = array(); 
        $len = 0; 
        
        $contents = preg_split("~(<[^>]+?>)~si",$html, -1,PREG_SPLIT_NO_EMPTY| PREG_SPLIT_DELIM_CAPTURE); 
        foreach($contents as $tag) 
        { 
            if (trim($tag)=="")  continue; 
            if(preg_match("~<([a-z0-9]+)[^/>]*?/>~si",$tag)){ 
            $result .= $tag; 
        }else if(preg_match("~</([a-z0-9]+)[^/>]*?>~si",$tag,$match)){ 
            if($tagStack[count($tagStack)-1] == $match[1]){ 
                array_pop($tagStack); 
                $result .= $tag; 
            } 
        }else if(preg_match("~<([a-z0-9]+)[^/>]*?>~si",$tag,$match)){ 
            array_push($tagStack,$match[1]); 
            $result .= $tag; 
        }else if(preg_match("~<!--.*?-->~si",$tag)){ 
            $result .= $tag; 
        }else{ 
            if($len + $this->mstrlen($tag) < $length){ 
                $result .= $tag; 
                $len += $this->mstrlen($tag);  
        }else { 
            $str = $this->msubstr($tag,0,$length-$len+1); 
            $result .= $str; 
            break; 
        } 
        
        } 
        } 
        while(!empty($tagStack)){ 
            $result .= '</'.array_pop($tagStack).'>'; 
        } 
        return  $result; 
    }
}

