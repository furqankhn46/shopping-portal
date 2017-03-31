<?php
$db=mysqli_connect('localhost','root','a','osp');
if(mysqli_connect_errno()){
    echo 'Database connection failed with following error:'.mysqli_connect_errno();
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once BASEURL.'/helpers/helpers.php';
