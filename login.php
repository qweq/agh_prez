<?php
require_once('include/init.php');

if (isset($_GET['logout'])) {
    $base->Logout();
    header('Location: ./index.php');
}

if (!empty($_POST['user'])) {
    $success = $base->Login($_POST['user']['u_username'], $_POST['user']['u_password']);
    if ($success) {
        header('Location: ./index.php');
    }
    else {
        $error_msg = array(
            'nouser' => 'Username not found',
            'wrongpwd' => 'Password does not match',
        );
    }
}
?>
<?= (!empty($base->GetLoginError()) ? '<h1 style="color:red">' . $error_msg[$base->GetLoginError()] . '</h1>' : ''); ?>
<style>
    .form-login-input-container {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        align-items: center;
    }
    .form-login-input-container input {
        width: 75%;
        padding: 6px;
    }
    .form-login-input-container label {
        width: auto;
    }
    #form-login-container {
        -webkit-box-shadow: 0px 0px 10px 5px rgba(188,188,188,1);
        -moz-box-shadow: 0px 0px 10px 5px rgba(188,188,188,1);
        box-shadow: 0px 0px 10px 5px rgba(188,188,188,1);
        background: white;
        padding: 20px;
    }

</style>
<div id="main-login-container" style="display: flex; height: 100%;">
    <div id="form-login-container" style="display: flex; width: 500px; height: auto; margin: auto;">
        <form id="form-login" action="" method="post" style="width: 100%; margin: 0">
            <div class="form-login-input-container">
                <label for="login-username">Username: </label><input id="login-username" name="user[u_username]">
            </div>
            <div class="form-login-input-container">
                <label for="login-password">Password: </label><input type="password" id="login-password" name="user[u_password]">
            </div>
            <div class="form-login-input-container">
                <input type="submit" value="Log in" style="margin: auto;">
            </div>
        </form>
    </div>
</div>
