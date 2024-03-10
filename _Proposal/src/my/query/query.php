<?php 
    // session_start();
	error_reporting(1);
	include('/acc/function.php');
    
    $id = $_SESSION['valid']; 

    $stmt = mysqli_query($con, "SELECT * FROM `signup` Where `id` = '$id'");
    $fetchData = mysqli_fetch_assoc($stmt);
    
    // $fpassword = $fetchData['password'];
    $fname = $fetchData['name'];
    $flastname = $fetchData['lastname'];
    $fgender = $fetchData['sex'];
    $fadd = $fetchData['address'];
    $fbday = $fetchData['bday'];
    $fnum = $fetchData['cellno'];
    $femail = $fetchData['email'];
    $Ocupation = $fetchData['occupation'];
    $school = $fetchData['school'];
    $status = $fetchData['status'];
    $Dept = $fetchData['Department'];
    $etype = $fetchData['employee_type'];

?>