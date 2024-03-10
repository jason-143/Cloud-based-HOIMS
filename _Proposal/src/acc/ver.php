<?php include("./function.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <a href="https://www.freepik.com/free-vector/two-factor-authentication-concept-illustration_13246824.htm#query=verify%20account&position=3&from_view=keyword&track=ais">Image by storyset</a> on Freepik -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//en/query/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="../css/fpass.css">
</head>
<body>
    <div class="main">
        <div id="greet" class="login">
            <div class="temp">
                <h1 id="wel" for="greet">Verify Your Account?</h1></br>
                <label id="signup">Kindly enter your OTP code that was sent to your email</label></br>
            </div>
            <div class="temp">
                <form id="loginform" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                    </br><input id="email" required maxlength="10" type="tel" name="codeVerify" placeholder="&#xf084; OTP Code" style="font-family:Arial, FontAwesome;"></br>
                    <input id="link" type="submit" name="verify" value="Verify">
                </form>
            </div>
        </div>
        <div class="login">
           <img width="100%" title="Verify acount" src="../images/verify.jpg" alt="">
        </div>
    </div>
</body>
</html>