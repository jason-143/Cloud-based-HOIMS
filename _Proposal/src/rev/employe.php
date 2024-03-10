<?php

error_reporting(1);
include('../acc/function.php');
//include('./query_.php');
$pageTitle = "Employe";
include('../my/header.php');
    /*check if user is login, will then redirected to login if not.*/ 
    if (!isset($_SESSION['valid'])) {
        header("Location: ../acc/logout.php");
    } else {        
?>
<div class="main-body-holder">
    <div class="main-body-content">
        <div class="form-content">
            <div class="reminder-content-container">
                <!-- 
                    title head
                    final draft deadline 28 
                 -->
                <div class="title">
                    <label id="my-account" for="top-form-title">Employee Registry</label><br><br>
                </div>
                <div class="employee-form-content">
                    <div class="member-list">
                        <h3>Employee list</h3><br>
                        <table class="dahsboard-table">
                            <thead>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>School</th>
                                    <th>Department</th>
                                    <th>Registration</th> <!--7-->
                                </tr>
                            </thead>
                            <tbody>
                            <?php            
                                //$id =  $_SESSION['valid'];
                                $we = "SELECT * FROM `signup` WHERE `UserType` = 1";
                                $result_query = mysqli_query($con, $we);
                                if (mysqli_num_rows($result_query) > 0) {
                                    while ($rows = mysqli_fetch_assoc($result_query)) {
                            ?>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                    <td data-cell="Id: "><?php echo $rows['id']?></td>
                                    <td data-cell="Name: "><?php echo $rows['name']?></td>
                                    <td data-cell="Email: "><?php echo $rows['email']?></td>
                                    <td data-cell="School: "><?php echo $rows['school']?></td>
                                    <td data-cell="Department: "><?php echo $rows['Department']?></td>
                                    <td data-cell="Registration: "><?php echo $rows['Signup_date']?></td>
                                </tr>
                            <?php
                                  }
                                }
                            ?>                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/reminder.js"></script>
    <?php include("./footer.php"); 
    }
?>