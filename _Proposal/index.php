<?php 
ini_set('session.cookie_lifetime', 14400); // Set cookie lifetime to 4hours
session_set_cookie_params(14400); // Set cookie parameters for consistency
session_start();

include("./src/acc/function.php");
error_reporting(E_ALL) ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="./src/css/login.css">
</head>

<body>
    <div class="main">
        <div id="greet" class="login">
           <img width="100%" src="./src/images/20824344_6343825.jpg" alt="">
        </div>
        <div id="user_" class="login">
            <form id="loginform1" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                <h1 id="title">Sign in</h1></br>
                <?php echo $warning; ?>
                <input required id="int" maxlength="10" type="text" name="Pname" placeholder="&#xf007;  name" style="font-family:Arial, FontAwesome;"></br>
                <div style="position: relative;">
                    <input required id="pass_show" maxlength="12" type="password" oninput="this.value = this.value.toUpperCase()" name="Ppass" placeholder="&#xf023;  password" style="font-family:Arial, FontAwesome;">
                    <a href="#" class="toggle-password" onclick="showpass2(this);">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </div>
                <a id="fp" href="./src/acc/fpass.php">forgot password</a></br>
                <input id="log" type="submit" value="Sign-in" name="Usignup" style="width:263px"></br><br>
            </form>
            <label style="Font-size:14px;">Don't have an account?</label>&nbsp;&nbsp;&nbsp;<a id="signuplink" href="./src/acc/s.php">Sign up</a><br><br><br><br><br>
        </div>
    </div>
</body>
<script>
    function showpass2(anchors) {
    var b = document.getElementById("pass_show");

    var icon = anchors.querySelector("i");

    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');

    if (b.type === "password") {
        b.type = "text";
    } else {
        b.type = "password";
    }
}
</script>
</html>
