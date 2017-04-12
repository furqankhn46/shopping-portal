<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/shoppingPortal/core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
include 'include/head.php';
$email = ((isset($_POST['email'])) ? sanitize($_POST['email']) : '');
$email = trim($email);
$password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');
$password = trim($password);
$errors = array();
?>
<style>
    body {
        background-image: url("/shoppingPortal/images/headerlogo/background.png");;
        background-size: 100vw 100vh;
        background-attachment: fixed;
    }
</style>
<div id="login-form">
    <div>
        <?php
        if ($_POST) {
            //form validation
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $errors[] = 'You must provide email and password.';
            }

            // validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors[] = 'You must a valid email';
            }
            // password is more than 6 charachers
            if (strlen($password) < 6) {
                $errors[] = 'password must be at least 6 character.';
            } else {

            }


            //check if email exists in the database
            $query = $db->query("SELECT * FROM users WHERE email='$email'");
            $user = mysqli_fetch_assoc($query);
            $userCount = mysqli_num_rows($query);
            if ($userCount < 1) {
                $errors[] = 'That email doesn\'t exist in our database';
            }
            if (!password_verify($password, $user['password'])) {
                $errors[] = 'The password does not match out records. please try again.';
            }

//                p($password);
            //echeck for errors
            if (!empty($errors)) {
                echo display_errors($errors);
            } else {
                //log use in
                $user_id=$user['id'];
                login($user_id);
            }
        }
        ?>
    </div>
    <h2 class="text-center">Login</h2>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
    </form>
    <p class="text-right"><a href="/shoppingPortal/index.php" alt="home">Visit Site</a></p>
</div>
<?php include 'include/footer.php'; ?>