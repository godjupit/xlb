<?php

// $host = '127.0.0.1';    
// $port = 3306;
// $dbname = 'xlb';
// $username = 'root';
// $password = 'CA5SyB4YTDtnt6d3';



$name = $_POST['name'];
$email = $_POST['email'];
$action = $_POST['action'];
header("Location: http://godjupit.com/register.html");
exit; // 确保 PHP 代码执行完毕后退出


?>