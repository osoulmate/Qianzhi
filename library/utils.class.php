<?php
//公共工具类

class Utils
{
    /*
    用于在网页中格式化显示Array对象
     */
    function dump($vars, $label = '', $return = TRUE) {
        if (ini_get('html_errors')) {
            $content = "<pre>\n";
            if ($label != '') {
                $content .= "<strong>{$label} :</strong>\n";
            }
            $content .= htmlspecialchars(print_r($vars, true));
            $content .= "\n</pre>\n";
        } else {
            $content = $label . " :\n" . print_r($vars, true);
        }
        if ($return) { return $content; }
        echo $content;
        return null;
    }
}