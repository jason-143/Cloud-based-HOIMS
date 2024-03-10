<?php 
ini_set('session.cookie_lifetime', 3600); // Set cookie lifetime to 1hours
session_set_cookie_params(3600); // Set cookie parameters for consistency
session_start();
include("./function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>forgot password</title>
    <script src="//en/query/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="../css/fpass.css">
    <script>

    </script>
</head>
<body>
    <div class="main">
        <div id="greet" class="login">
            <div class="temp">
                <h1 id="wel" for="greet">Forgot Password</h1></br>
                <label id="signup">Please enter your registered email</br>and we'll send you link</br>on how to reset you password&nbsp;&nbsp;</label></br>
            </div>
            <div class="temp">
                <form id="loginform" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                    </br><input id="email" required type="email" name="sendemail" placeholder="&#xf0e0; email" style="font-family:Arial, FontAwesome;"></br>
                    <input id="link" type="submit" name="submit-forgot-password" value="Submit">
                </form>
            </div>
            <div id="acclink" class="temp">
            </br></br></br><a id="link-log" href="../../index.php">Login</a>
                <a id="link-create" href="s.php">Sign up</a>
            </div>
        </div>
        <div class="login">
           <img width="100%" title="http://www.freepik.com" src="../images/3293465.jpg" alt="">
        </div>
    </div>
</body>
</html>