<?php 
    //hides error-waarning
	// error_reporting(1);
	include('../acc/function.php');
    
    error_reporting(1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //$id = $_SESSION['valid'];

    /*
        fetch user data
        Table Overview
    */ 
    // empty column
    $query = mysqli_query($con, "SELECT COUNT(*) AS count FROM `signup` WHERE `UserType` = 1 AND `Document_upload` = 0");


    if ($query) {
        $row = mysqli_fetch_assoc($query);
        $count = $row['count'];
    } else {
        echo "Query failed: " . mysqli_error($con);
    }
    $query->close();



    /*

        dashboard - Overview

    */
    $tablexray = 'xray';
    $tablecbc = 'cbc';
    $tableurinalysis = 'urinalysis';
    $sum = 0;
    /*
        counts data for xray table
    */ 
    $count_xray = $con->query("SELECT COUNT(*) AS count FROM `xray`");
    $Row_xray = $count_xray->fetch_assoc();
    $rowCount_xray = $Row_xray['count'];
    $count_xray->close();
    /*
        counts data for cbc table
    */ 
    $count_cbc = $con->query("SELECT COUNT(*) AS count_cbc FROM `cbc`");
    $Row_cbc = $count_cbc->fetch_assoc();
    $rowCount_cbc = $Row_cbc['count_cbc'];
    $count_cbc->close();
    /*
        counts data for unirnalysis table
    */ 
    $count_u = $con->query("SELECT COUNT(*) AS count FROM `urinalysis`");
    $Row_u = $count_u->fetch_assoc();
    $rowCount_u = $Row_u['count'];
    $count_u->close();

    /*
        counts data from misc documents table
    */ 
    $count_m = $con->query("SELECT COUNT(*) AS count FROM `misc_test`");
    $Row_m = $count_m->fetch_assoc();
    $rowCount_m = $Row_m['count'];
    $count_m->close();

    $sum = $rowCount_xray + $rowCount_cbc + $rowCount_u + $rowCount_m;

    $w1 = "SELECT signup.id, signup.name, xray.user_id
            FROM signup
            LEFT JOIN xray ON signup.id = xray.user_id
            WHERE signup.UserType = 1";


    $w2 = "SELECT signup.id, signup.name, cbc.user_id
            FROM signup
            LEFT JOIN cbc ON signup.id = cbc.user_id
            WHERE signup.UserType = 1";

    $w3 = "SELECT signup.id, signup.name, urinalysis.user_id
            FROM signup
            LEFT JOIN urinalysis ON signup.id = urinalysis.user_id
            WHERE signup.UserType = 1";

    $w4 = "SELECT signup.id, signup.name, misc_test.user_id
            FROM signup
            LEFT JOIN misc_test ON signup.id = misc_test.user_id
            WHERE signup.UserType = 1";

    $query1 = mysqli_query($con, $w1);
    $query2 = mysqli_query($con, $w2);
    $query3 = mysqli_query($con, $w3);
    $query4 = mysqli_query($con, $w4);

    // Complete 
    if (mysqli_num_rows($query1) > 0 && mysqli_num_rows($query2) > 0 && mysqli_num_rows($query3) > 0 && mysqli_num_rows($query4) > 0) {
        // while (($row = mysqli_fetch_assoc($result_query)) && ($row1 = mysqli_fetch_assoc($result_query1)) && ($row2 = mysqli_fetch_assoc($result_query2)) && ($row3 = mysqli_fetch_assoc($result_query3)) ) {

        // }
    }else if(mysqli_num_rows($query1) > 0 && mysqli_num_rows($query2) > 0 && mysqli_num_rows($query3) > 0 && mysqli_num_rows($query4) > 0) {
        # code...
    }


    /*  
        >admin account page -adm.php-------------------
        >adding employee and upadting admin account
        
        submit add employee
    */ 
    if (isset($_POST['submit-add-employee'])) {

        $acc_fname = $_POST['add-fname'];
        $acc_lname = $_POST['add-lname'];
        $acc_pass = $_POST['add-password'];
        $acc_hashed = password_hash($acc_pass, PASSWORD_DEFAULT);
        $usertype = 1;
        $acc_gender = $_POST['add-gender'];
        $acc_address = $_POST['add-address'];
        $acc_bday = $_POST['add-bday'];
        $cell_num = $_POST['add-cellnumber'];
        $acc_email = $_POST['add-email'];
        $acc_occupation = $_POST['add-occupation'];
        $acc_school = $_POST['add-school'];
        $acc_status = $_POST['add-status'];
        $acc_department = $_POST['add-department'];
        $acc_type = $_POST['add-type'];
    
        $sql = "INSERT INTO `signup` (`name`, `lastname`,`password`, `UserType`, `sex`, `address`, `bday`, `cellno`, `email`, `occupation`, `school`, `status`, `Department`, `employee_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare and execute the statement
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssssssssss", $acc_fname, $acc_lname, $acc_hashed, $usertype, $acc_gender, $acc_address, $acc_bday, $cell_num,$acc_email, $acc_occupation, $acc_school, $acc_status, $acc_department, $acc_type);
    
        // Check if the insert was successful
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo "<script>alert('Inserted Successfully');</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
        //Close the database connection
        $stmt->close();
        $con->close();
    }
    if (isset($_POST['submit-update-admin'])) {
        
        $adminId = 1;     

        $adminname = $_POST['admin-username'];
        $adminpass = $_POST['admin-password'];
        $admin_hashed = password_hash($adminpass, PASSWORD_DEFAULT);


        $sql = "UPDATE `signup` SET ";

        /*
            check if input is empty else insert to table
        */
        
        if (!empty($adminname)) {// first name
            $sql .= "`name` = '$adminname', ";
        }
        if (!empty($adminpass)) {//last name
            $sql .= "`password` = '$admin_hashed', ";
        }

        $sql = rtrim($sql, ', ');

        // Add the WHERE clause
        $sql .= "WHERE `id` = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $adminId);
        
        if ( $stmt->execute() && $stmt->affected_rows > 0) {
            echo "<script>alert('Updated Successfully');</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
        //Close the database connection
        $stmt->close();
        $con->close();
    }

    /*
    
        Table Column Action - Delete
        document page - d.php

    */ 

    /*
        cleans up record xray table
    */
    if(isset($_POST['delete-user-document-xray'])){

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST['id-deletion-xray'];
            $doc = $_POST['doc-name-container-xray'];

            $uploads_dir = "../my/document_upload/xray/user_" . $id . "/" . $doc;    

            $sqlDelete = "DELETE FROM `xray` WHERE `user_id` = ? AND `Document` = ?";
            $stmnt = $con->prepare($sqlDelete);
            $stmnt->bind_param("is",$id,$doc);
            $result = $stmnt->execute();

            /* 
                both remove the records from database and local folder
                ../my/document_upload/....
            */
            if ($result && file_exists($uploads_dir)) {
                unlink($uploads_dir);
                echo "<script>
                        alert('Record ".$doc." was successfully removed!');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 5000)// refresh page after 0.5 milliseconds
                    </script>";
            }else {
                echo "<script>
                        alert('Error: there was an error deleting the uploaded files');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 5000)// refresh page after 0.5 milliseconds
                    </script>";
            }
            //Close the database connection
            $stmnt->close();
            $con->close();
        }
    }
     /*
        cleans up record cbc table
    */
    if(isset($_POST['delete-user-document-cbc'])){

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST['id-deletion-cbc'];
            $doc = $_POST['doc-name-container-cbc'];

            $uploads_dir = "../my/document_upload/cbc/user_" . $id . "/" . $doc;    

            $sqlDelete = "DELETE FROM `cbc` WHERE `user_id` = ? AND `Document` = ?";
            $stmnt = $con->prepare($sqlDelete);
            $stmnt->bind_param("is",$id,$doc);
            $result = $stmnt->execute();

            if ($result && file_exists($uploads_dir)) {
                unlink($uploads_dir);
                echo "<script>
                        alert('Record ".$doc." was successfully removed!');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 500)// refresh page after 0.5 milliseconds
                    </script>";
            }else {
                echo "<script>
                        alert('Error: there was an error deleting the uploaded files');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 500)// refresh page after 0.5 milliseconds
                    </script>";
            }
            //Close the database connection
            $stmnt->close();
            $con->close();
        }
    }
     /*
        cleans up record urinalysis table
    */
    if(isset($_POST['delete-user-document-urinalysis'])){
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST['id-deletion-u'];
            $doc = $_POST['doc-name-container-u'];

            $uploads_dir = "../my/document_upload/urinalysis/user_" . $id . "/" . $doc;    

            $sqlDelete = "DELETE FROM `urinalysis` WHERE `user_id` = ? AND `Document` = ?";
            $stmnt = $con->prepare($sqlDelete);
            $stmnt->bind_param("is",$id,$doc);
            $result = $stmnt->execute();

            if ($result && file_exists($uploads_dir)) {
                unlink($uploads_dir);
                echo "<script>
                        alert('Record ".$doc." was successfully removed!');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 500)// refresh page after 0.5 milliseconds
                    </script>";
            }else {
                echo "<script>
                        alert('Error: there was an error deleting the uploaded files');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 500)// refresh page after 0.5 milliseconds
                    </script>";
            }
            //Close the database connection
            $stmnt->close();
            $con->close();
        }
    }
    /*
        cleans up record misc_tes table
        //$expiryDateThreshold = date('Y-m-d', strtotime('+1 week', strtotime(date('Y-12-31'))));
    */
    if(isset($_POST['delete-user-document'])){
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST['id-deletion-misc'];
            $doc = $_POST['doc-name-container'];

            $uploads_dir = "../my/document_upload/other/user_" . $id . "/" . $doc;    

            $sqlDelete = "DELETE FROM `misc_test` WHERE `user_id` = ? AND `Document` = ?";
            $stmnt = $con->prepare($sqlDelete);
            $stmnt->bind_param("is",$id,$doc);
            $result = $stmnt->execute();

            if ($result && file_exists($uploads_dir)) {
                unlink($uploads_dir);

                echo "<script>
                        alert('Record ".$doc." was successfully removed!');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 5000)// refresh page after 0.5 milliseconds
                    </script>";
            }else {
                echo "<script>
                        alert('Error: there was an error deleting the uploaded files');
                        setTimeout(function(){
                            window.location.href = window.location.href;
                    }, 5000)// refresh page after 0.5 milliseconds
                    </script>";
            }

            //Close the database connection
            $stmnt->close();
            $con->close();
        }
    }
      /*
    
        Table Column Action
        ends here
        
    */ 

    /*
        Table Column Approval
        Document page - d.php

        Two if statement per table: 
            >Updates the table "approve" "decline" separately 

    */ 
          /*
            Xray table
            -Approve-
    */
    if (isset($_POST['Approval-Approved-xray'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id-deletion-xray'];
            $status = "<p style='color:rgb(103, 255, 103);'>Approved</p>";
            $stmt = "UPDATE `xray` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('approvedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
       /*
            xray table
            -Decline-
    */
    if (isset($_POST['Approval-Declined-xray'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $id = $_POST['id-deletion-xray'];
            $status = "<p style='color:Red;'>Declined</p>";
            $stmt = "UPDATE `xray` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('DisapprovedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
      /*
            CBC table
            -Approve-
    */
    if (isset($_POST['Approval-Approved-cbc'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id-deletion-cbc'];
            $status = "<p style='color:rgb(103, 255, 103);'>Approved</p>";
            $stmt = "UPDATE `cbc` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('approvedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
       /*
            CBC table
            -Decline-
    */
    if (isset($_POST['Approval-Declined-cbc'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $id = $_POST['id-deletion-cbc'];
            $status = "<p style='color:Red;'>Declined</p>";
            $stmt = "UPDATE `cbc` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('DisapprovedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
    /*
            Urinalysis table
            -Approve-
    */
    if (isset($_POST['Approval-Approved-u'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id-deletion-u'];
            $status = "<p style='color:rgb(103, 255, 103);'>Approved</p>";
            $stmt = "UPDATE `urinalysis` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('approvedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
       /*
            Urinalysis table
            -Decline-
    */
    if (isset($_POST['Approval-Declined-u'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $id = $_POST['id-deletion-u'];
            $status = "<p style='color:Red;'>Declined</p>";
            $stmt = "UPDATE `urinalysis` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('DisapprovedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
     /*
            Misc Document table
            -Approve-
    */
    if (isset($_POST['Approval-Approved-misc'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id-deletion-misc'];
            $status = "<p style='color:rgb(103, 255, 103);'>Approved</p>";
            $stmt = "UPDATE `misc_test` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('approvedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
       /*
            Misc Document table
            -Decline-
    */
    if (isset($_POST['Approval-Declined-misc'])) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $id = $_POST['id-deletion-misc'];
            $status = "<p style='color:Red;'>Declined</p>";
            $stmt = "UPDATE `misc_test` SET `approval_status` = ? WHERE `user_id` = ? ";
            $stmt = $con->prepare($stmt);
            $stmt->bind_param("si",$status,$id);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let app = document.getElementById('DisapprovedContainer');
                            app.style.display = 'block';
                            setTimeout(function() {
                                app.style.display = 'none';
                                // Now you can proceed with the actual form submission if needed
                            }, 2000);
                        });
                    </script>";
            }
            $stmt->close();
            $con->close();
        }
    } 
?>
