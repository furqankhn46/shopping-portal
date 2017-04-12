<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/shoppingPortal/core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
include 'include/head.php';
include 'include/navigation.php';