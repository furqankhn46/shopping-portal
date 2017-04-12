<?php
require_once '../core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
if(!has_permission('admin')){
    permission_error_redirect('index.php');
}
include  'include/head.php';
include 'include/navigation.php';
?>
users
<?php include'include/footer.php';?>
