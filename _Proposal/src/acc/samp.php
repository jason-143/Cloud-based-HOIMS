<?php
session_start();
    
   $localhost = "localhost";
   $username = "root";
   $password = "";
   $dbname = "samplesearch";
   
    $link = mysqli_connect($localhost,$username,$password,$dbname);  
    
   if (isset($_POST['submit'])) {
    $use = $_POST['user'];
    $_SESSION['usern'] = $use;

    $pass = $_POST['pass'];
    $_SESSION['passn'] = $pass;
    
    $phashed = password_hash($pass,PASSWORD_DEFAULT);
    $_SESSION['hashedpassn'] = $phashed;

        //mysqli_query($link,"INSERT INTO `login` (`username`, `password`) values('$username','$phashed')");
        if (password_verify($pass, $phashed)) {
            echo "Password matches";
        }else {
            echo "Password does not match";
        }
    echo $phashed;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <input type="text" name="user" placeholder="password unhashed"></br>
            <input type="password" name="pass" placeholder="password hashed"></br>
            <input type="submit" value="login" name="submit"></br>
    </form>
   username: <?php $name = $_SESSION['usern'];  echo $name;?></br>
   password:  <?php $pword = $_SESSION['passn'];  echo $pword;?></br>
   password HASH: <?php $phashed = $_SESSION['hashedpassn'];  echo $phashed?> <br><br>
   <br>
   <br>
   <br>
   <br>
   <?php 

        $rand1 = random_int(5,10); // Generate 4 random bytes
        $rand2 = random_int(1,10); // Generate 4 random bytes
        $rand3 = random_int(2,10); // Generate 4 random bytes
        $rand4 = random_int(4,10); // Generate 4 random bytes
        $rand5 = random_int(3,10); // Generate 4 random bytes
        $randomNumber = $rand1.$rand2.$rand3.$rand4.$rand5;
        //$randomNumber = hexdec(bin2hex($randomBytes)) % 100 + 1; // Convert bytes to an integer between 1 and 100
        echo $randomNumber;
        ?>
</body>
</html>