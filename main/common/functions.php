<?php

function htmEsc($text){
    if (is_string(gettype($text))){
        $tmp = htmlspecialchars($text, ENT_QUOTES|ENT_HTML5|ENT_SUBSTITUTE, 'UTF-8');
        return $tmp;
    } else {
        return "";
    }
}

function header_message($username){
    $TXT = ['ようこそ %s さん', '%s さん こんにちは', "ハロー %s さん"];
    return htmEsc(sprintf($TXT[random_int(0, count($TXT)-1)], $username));
}






?>