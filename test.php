<?php

    ##### 隨機密碼可能包含的字符
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($str), 0, 30);
 

echo $password ;

?>