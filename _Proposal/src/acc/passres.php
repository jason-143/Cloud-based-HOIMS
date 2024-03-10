<?php 
session_start();
include("./function.php");
$get_id = $_GET['id'];
$email = $_SESSION['valid-forgot-password'];
echo $email;
echo $get_id;
if (!isset($_SESSION['reset_id']) || $_SESSION['reset_id'] !== $get_id) {
    unset($_SESSION['reset_id']);
    header("Location: ../acc/logout.php");
}else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Update password</title>
    <script src="//en/query/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="../css/fpass.css">
    <script src="../js/signup.js"></script>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="main">
    <div class="image-rigth-side">
           <img width="100%" title="" src="../images/3293465.jpg" alt="">
        </div>
        <div class="reset">
            <div class="temp">
                <br><h1 id="wel" for="greet">Update Password</h1></br>
                <label id="signup" for="p1">You may now update you<br> password below</label></br></br>
            </div>
            <form action="" onsubmit="return verifyp();" method="post">
                <div style="position: relative;">
                    <input class="update-password" required maxlength="12" id="p1" type="password" oninput="this.value = this.value.toUpperCase()" name="update-password-input" placeholder="&#xf023; Password"  style="font-family:Arial, FontAwesome;">
                    <a href="#" onclick="sp(this)" class="update-toggle-password">
                        <i class="fa fa-eye" aria-hidden="true">
                        </i></a><br>
                </div>
                <div style="position: relative;">
                    <input class="update-password" required maxlength="12" onkeyup="verifyp()" id="p2" oninput="this.value = this.value.toUpperCase()" type="password" name="comfirmpassword" placeholder="&#xf023; Confirm password"  style="font-family:Arial, FontAwesome;">
                    <a href="#" onclick="sp2(this)" class="update-toggle-password">
                        <i class="fa fa-eye"  aria-hidden="true">
                        </i></a></br>
                </div>
                <span for="p2" id="warn"></span></br><br>
                <div style="position: relative;">
                <input id="submit-update-pass" type="submit" name="Update-password" value="Update">
                </div>
            </form>
            <div id="pass-reset" class="temp">
            </br></br></br><a id="link-log" href="../../index.php">Login</a>
                <a id="link-sigup" href="./s.php">Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php }?>