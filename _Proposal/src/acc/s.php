<?php include("./function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//en/query/jquery-3.7.0.min.js"></script>
    <script src="../js/signup.js"></script>
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div class="main">
        <div id="greet" class="login">
            <img width="100%" src="../images/4957136_4957136.jpg" alt="Sign up">
        </div>
        <div id="user_" class="login">
            <form id="loginform" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" onsubmit="return verifyp();" method="post">
                <div id="account" class="inform">
                    <h2 id="title">Sign up</h2></br>
                    <label id="form-label-input" for="Name">Name</label></br>
                    <input required maxlength="20" id="Name" type="text" name="signupname" placeholder="Name"></br>
                    <label id="form-label-input" for="email">Email</label></br>
                    <input required id="email" type="email" name="signupmail" placeholder="&#xf0e0; @gmail.com" style="font-family:Arial, FontAwesome;"><br>
                    <label id="form-label-input" for="p1">Password</label></br>
                    <div style="position: relative;">
                        <input required maxlength="12" id="p1" type="password" oninput="this.value = this.value.toUpperCase()" name="signuppassword" placeholder="Password">
                        <a href="#" onclick="sp(this)" class="toggle-password">
                            <i class="fa fa-eye" aria-hidden="true">
                            </i></a><br>
                    </div>
                    <div style="position: relative;">
                        <input required maxlength="12" onkeyup="verifyp()" id="p2" oninput="this.value = this.value.toUpperCase()" type="password" name="comfirmpassword" placeholder="Confirm password">
                        <a href="#" onclick="sp2(this)" class="toggle-password">
                            <i class="fa fa-eye"  aria-hidden="true">
                            </i></a></br>
                    </div>
                    <span for="p2" id="warn"></span></br>
                    <input class="nav" id="subform" type="submit" name="save" style="width: 16.5pc;" value="Register"><br><br>
                    <label id="signup">Have an account?&nbsp;&nbsp;<a id="link" href="../../index.php">Log in</a></label>
                </div>
            </form>
        </div>
    </div>
</body>

</html>