<?php
    // $filename = 'en/.htaccess';
    // $permissions = fileperms($filename);
    // $permissionsString = decoct($permissions);

    $host = "localhost";$username = "root";$password = "";$dbname = "cs_design_project1";
    $con = mysqli_connect($host,$username,$password,$dbname);    
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // debugging
    ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    $warning="";

    //Get the current protocol (http or https)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    //Get the current domain and port (if any)
    $domain = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . $domain;
    //Get the directory path of the current script (excluding the filename)
    $directory = dirname($_SERVER['PHP_SELF']);
    //Construct the URL for the redirect
    $redirectUrllog = $protocol . $domain . $baseUrl . '/index.php';
    $redirectUrlsup = $protocol . $domain . $baseUrl . '/s.php';
    $redirectUrlver = $protocol . $domain . $baseUrl. '/ver.php';
    $redirectUrlAlog = $protocol . $domain . $baseUrl . '/index.php';
    $redirectUrlfpas = $protocol . $domain . $baseUrl . '/fpass.php';
    $redirectUrlAdb = $protocol . $domain . $baseUrl . '/Admin_dashboard.php';
    $redirectUrldb = $protocol . $domain . $baseUrl . '/User_dashboard.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception; 

    $randomNumber=$datetest="";
    //input
    $firstname=$lastname=$pword=$gender=$address=$bday=$cellno=$email=$occupation=$school=$status=$department=$employee_type="";

    $date = date("Y/m/d H:i:s");  


    /*
        >Email Unique:
            -Cheeck Email if exist else prompt user to reenter email
    */ 

    if (isset($_POST['save'])) { //submit form
        $uname = $_POST['signupname'];
        $_SESSION['sname'] = $uname;

        $email = $_POST['signupmail'];
        $_SESSION['semail'] = $email;

        $pword = $_POST['signuppassword'];
        $_SESSION['spassword'] = $pword;
        
        //debugging
        $rand1 = random_int(5,10);//bytes
        $rand2 = random_int(1,10);
        $rand3 = random_int(2,10); 
        $rand4 = random_int(4,10); 
        $rand5 = random_int(3,10); 

        $randomNumber = $rand1.$rand2.$rand3.$rand4.$rand5;
        $_SESSION['ConfirmationCode'] = $randomNumber;

        if (isset($_SESSION['ConfirmationCode'])) {
            $getCode = $_SESSION['ConfirmationCode'];
        } else {
            //  echo 'No random number found.';
        }

        require __DIR__.'/PHPMailer/src/PHPMailer.php';
        require __DIR__.'/PHPMailer/src/SMTP.php';
        require __DIR__.'/PHPMailer/src/Exception.php'; 

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
        $mail->SMTPAuth   = true;
        $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
        $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
        $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
        $mail->Port       = 465; 

        $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
        $mail->addAddress($email);// Add a recipient email address
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation Code';
        $mail->Body    = '<h1>Hello '."$uname".',</h1>
                            <p>Copy the code below</p>
                            <p><label style="background-color: #007bff; color: #fff;font-size:16px; text-decoration: none; padding: 14px 24px; border-radius: 8px;">
                            '."$getCode".'</label></p>
                            <br><br>
                            <p>if you did not request this email, you can safely ignore/delete it.</p>';
        //checks if email already exists in database
        $query = "SELECT email FROM signup WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0){
            echo "<script>
                    alert('Error: This email address is already in use.  ".$stmt->error."');
                    setTimeout(function() {
                        window.location.href = window.location.href;
                    }, 500); // 500 milliseconds (0.5 seconds) delay
            </script>";
        }else{
            if($mail->send()){
                echo "<script>alert('An OTP was sent to your email');</script>";
                header("Location: ./ver.php");
            }
        }
    }
    /*
        Verify Signup
    */
    if (isset($_POST['verify'])) {

        //$verifyCode = $_POST['codeVerify'];
        //$randomNumbers = $_SESSION['ConfirmationCode'];

        $name = $_SESSION['sname'];
        $pUser = $_SESSION['spassword'];
        $emails = $_SESSION['semail'];
        $userTYpe = 1;
        $hashed = password_hash($pUser,PASSWORD_DEFAULT);
        // if ($randomNumbers != $verifyCode) {
        //     echo "<script>alert('The OTP is incorrect');</script>";
        // }else {
            //echo "<script>alert('Verified!, you may now login to your account');</script>";
           $pre = $con->prepare("INSERT INTO `signup`(`name`,
                                                      `lastname`,
                                                      `password`,
                                                      `UserType`,
                                                      `sex`,
                                                      `address`,
                                                      `bday`,
                                                      `cellno`,
                                                      `email`,
                                                      `occupation`,
                                                      `school`,
                                                      `status`,
                                                      `Department`,
                                                      `employee_type`)
                                            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $pre->bind_param("sssissssssssss",$name,$lastname,$hashed,$userTYpe,$gender,
            $address,$bday,$cellno,$emails,$occupation,$school,$status,$department,$employee_type);
            
            $pre->execute();
            if ($pre->errno) {
                echo "Error: " . $pre->error;
            } else {
                if ($pre->affected_rows > 0) {
                    header("Location: ../../index.php");
                } else {
                    echo "No rows affected. Something may be wrong with the insert.";
                }
            }
            $pre->close();
            $con->close();
            exit();
       //}
        
    }
    /*
        Signin 
    */
    if (isset($_POST['Usignup'])) {
        
        $name = $_POST['Pname'];
        $password = $_POST['Ppass'];
    
        // Hash the password before checking it against the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT id, password, UserType FROM signup WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($fetchID, $fetchPasswords, $fetchUserType);
            $stmt->fetch();
    
            // Verify the hashed password
            if (password_verify($password, $fetchPasswords)) {
                
                $_SESSION['valid'] = $fetchID;
                $_SESSION['type'] = $fetchUserType;
                $_SESSION['name'] = $name;
                $warning = '<label id="sucess"><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;Login Success.</label></br><br>';
                
                // Redirect based on UserType
                if ($fetchUserType == 1) {
                    header("Location: ./src/my/home.php");
                } else {
                    header("Location: ./src/rev/dashboard.php");
                }
                exit();
            } else {
                $warning = '<label id="invaliderror"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Invalid login, please try again.</label></br><br>';
            }
        } else {
            // Username not found in the database
            $warning = '<label id="invaliderror"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Invalid Login, please try again</label></br><br>';
        }
    
        $stmt->close();
    }

    /*
        Forgot Password
    */ 

    if (isset($_POST['submit-forgot-password'])){

        //$_SESSION['valid-forgot-password'] = isset($_POST['valid-forgot-password']);

        $mail = $_POST['sendemail'];
        $stmt = $con->prepare("SELECT id, email, name FROM `signup` WHERE `email` = ?");
        $stmt->bind_param("s",$mail);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($userId,$email_matched,$userName);
            $stmt->fetch();
            $_SESSION['valid-forgot-password'] = $email_matched;
            if($mail == $email_matched){
                
                $token = bin2hex(random_bytes(32)); // Generate a random token
                $_SESSION['reset_id'] = $token;
                // $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiration time 

                // Store the token in the database
                // $stmt = $con->prepare("INSERT INTO `password_reset_tokens` (`user_id`, `token`, `expiration_time`) VALUES (?, ?, ?)");
                // $stmt -> bind_param("sss",$userId, $token, $expirationTime);
                // $stmt->execute();

                require __DIR__.'/PHPMailer/src/PHPMailer.php';
                require __DIR__.'/PHPMailer/src/SMTP.php';
                require __DIR__.'/PHPMailer/src/Exception.php';    
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
                $mail->SMTPAuth   = true;
                $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
                $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
                $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
                $mail->Port       = 465; 

                $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
                $mail->addAddress($email_matched);// Add a recipient email address
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Instructions';
                $mail->Body    = '<h1>Hello '."$userName".',</h1>
                                    <p>We recently received a request to reset the password for your account</p>
                                    <p>To reset your password, please click on the following link:</p><br>
                                    <a href="http://localhost/en1/_Proposal/src/acc/passres?id='."$token".'">Click to reset Password</a>
                                    <br><br>
                                    <p>this is a one-time use links.</p>
                                    <br><br>
                                    <p style="font-size: 12px; margin-top: 10px;">
                                    You receiving this email because you request to change your password, if you did not make the request
                                      you can safely ignore this message</p>';

                    if($mail->send()){
                        echo "<script>alert('A link was sent was to your gmail account!');
                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 100); // 3000 milliseconds (3 seconds) delay
                            </script>";
                        exit();
                    }
                } else {
                    // Handle query error
                    echo  "<script>
                            alert('The email address you entered is not associated with any account. Please make sure you've used the correct email or sign up for a new account.');
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 100); // 3000 milliseconds (3 seconds) delay
                            </script>";
                        exit();
                }
        }else{
            // Handle query error
            echo "<script>
            alert('The email address you entered is not associated with any account. Please make sure you have used the correct email or sign up for a new account.');
            setTimeout(function() {
                window.location.href = window.location.href;
            }, 500); // 500 milliseconds (0.5 seconds) delay
            </script>";
            exit();
            // echo "Error: " . mysqli_error($con);
            // exit();
        }
    }
    /*
        After A Successful Authentication user can update their account
    */ 
    if (isset($_POST['Update-password'])) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $email = $_SESSION['valid-forgot-password'];
        $password = $_POST['update-password-input'];
        $passHashed = password_hash($password,PASSWORD_DEFAULT);

            $update_stmt = "UPDATE signup SET password = ? WHERE email = ?";
            $update = $con->prepare($update_stmt);
            if (!$update) {
                die("Prepare failed: (" . $con->errno . ") " . $con->error);
            }
            $update->bind_param("ss",$passHashed,$email);
            if($update->execute()) {
                echo "<script>
                alert('Success: Your password was Updated Successfully, you may now login!');
                    setTimeout(function() {
                        window.location.href = '../../index.php';
                    }, 1000); // 3000 milliseconds (3 seconds) delay
                </script>";
            }else{
                echo "<script>
                alert('Something went wrong!');
                    setTimeout(function() {
                        window.location.href = window.location.href;
                    }, 2000); // 3000 milliseconds (3 seconds) delay
                </script>";
            }
        $update->close();
        $con->close();
        }
    }
    /*
        Updates table
    */
    if (isset($_POST['submit-update'])) {

        if($_SERVER['REQUEST_METHOD'] === "POST") {

            $fetchedID = $_SESSION['valid'];            
            
            $acc_fname = $_POST['acc-fname'];
            $acc_lname = $_POST['acc-lname'];
            $acc_email = $_POST['acc-email'];

            $cell_num = $_POST['acc-cellnumber'];
            $acc_address = $_POST['acc-address'];
            $acc_bday = $_POST['acc-bday'];
            $acc_gender = $_POST['acc-gender'];

            $acc_pass = $_POST['acc-password'];
            $acc_hashed = password_hash($acc_pass, PASSWORD_DEFAULT);


            $acc_occupation = $_POST['acc-occupation'];
            $acc_school = $_POST['acc-school'];
            $acc_status = $_POST['acc-status'];
            $acc_department = $_POST['acc-department'];
            $acc_type = $_POST['acc-type'];
            //$acc_em_number = $_POST['acc-em-number'];

            $sql = "UPDATE `signup` SET ";

            /*
                check if input is empty else insert to table
            */
            
            if (!empty($acc_fname)) {// first name
                $sql .= "`name` = '$acc_fname', ";
            }
            if (!empty($acc_lname)) {//last name
                $sql .= "`lastname` = '$acc_lname', ";
            }
            if (!empty($acc_email)) {//email
                $sql .= "`email` = '$acc_email', ";
            }
            if (!empty($cell_num)) {// number
                $sql .= "`cellno` = '$cell_num', ";
            }
            if (!empty($acc_address)) {//address
                $sql .= "`address` = '$acc_address', ";
            }
            if (!empty($acc_bday)) {//birthday
                $sql .= "`bday` = '$acc_bday', ";
            }
            if (!empty($acc_gender)) {// gender
                $sql .= "`sex` = '$acc_gender', ";
            }
            if (!empty($acc_pass)) {//
                $sql .= "`password` = '$acc_hashed', ";
            }
            
            /*  */
            if (!empty($acc_occupation)) {//accupation
                $sql .= "`occupation` = '$acc_occupation', ";
            }
            if (!empty($acc_school)) {//school
                $sql .= "`school` = '$acc_school', ";
            }
            if (!empty($acc_status)) {//status
                $sql .= "`status` = '$acc_status', ";
            }
            if (!empty($acc_department)) {//department
                $sql .= "`Department` = '$acc_department', ";
            }
            if (!empty($acc_type)) {//employee type
                $sql .= "`employee_type` = '$acc_type', ";
            }

            // Remove the trailing comma
            $sql = rtrim($sql, ', ');

            // Add the WHERE clause
            $sql .= "WHERE `id` = ?";

            // Prepare and execute the statement
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $fetchedID);

            // Check if the update was successful
            if ( $stmt->execute() && $stmt->affected_rows > 0) {
                echo "<script>alert('Updated Successfully');
                    setTimeout(function(){
                        window.location.href = window.location.href
                    }, 500);
                    </script>";
            } else {
                echo "<script>alert('Something went wrong');
                setTimeout(function(){
                    window.location.href = window.location.href
                }, 500);
                </script>";
            }
            $stmt->close();
            $con->close();
        }
    }
    /*
        Insert Document Xray
    */
    if (isset($_POST['submit-document'])) {
        // Assuming $_SESSION['valid'] contains the user ID
        $fetchedID = $_SESSION['valid'];
    
        // Sanitize and validate input data
        $clinic_name = $_POST['clinic'];
        $doctor = $_POST['doctor'];
        $DateOfPayment = $_POST['DateOfPayment'];
        $or = $_POST['ORnumber'];

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Validate file upload
                if (isset($_FILES['filename_Upload']) && $_FILES['filename_Upload']['error'] === UPLOAD_ERR_OK) {
                    $allowedFileTypes = ['pdf', 'doc', 'docx'];
                    $fileType = strtolower(pathinfo($_FILES['filename_Upload']['name'], PATHINFO_EXTENSION));
        
                    // Check if the file type is allowed
                    if (!in_array($fileType, $allowedFileTypes)) {
                        echo "<script>
                                    alert('Error: Invalid file type. Please upload only PDF, DOC, or DOCX files.');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 500 milliseconds (3 seconds) delay
                                </script>";
                        exit();
                        //header("location: ../my/xray.php");
                    }
        
                    // Create the user-specific directory if it doesn't exist
                    $uploads_dir = "document_upload/xray/user_" . $fetchedID . "/";
        
                    if (!is_dir($uploads_dir)) {
                        mkdir($uploads_dir, 0755, true);
                    }
        
                    // Get the file name
                    $fileName = basename($_FILES["filename_Upload"]["name"]);
        
                    // Set the target path for the file
                    $targetPath = $uploads_dir . $fileName;
        
                    // Check if the file already exists in the local folder
                    // if (file_exists($targetPath)) {
                    //     echo "<script>
                    //             alert('Error: You have already Uploaded a file.');
                    //             setTimeout(function() {
                    //                 window.location.href = window.location.href;
                    //             }, 500); // 500 milliseconds (3 seconds) delay
                    //         </script>";
                    //     exit();
                    // }
        
                    // Move the uploaded file to the target path
                    if (move_uploaded_file($_FILES["filename_Upload"]["tmp_name"], $targetPath)) {
                        // Check if the file already exists in the database
                        $sqlCheckExistence = "SELECT COUNT(*) FROM `xray` WHERE `user_id` = ?";
                        $stmtCheckExistence = $con->prepare($sqlCheckExistence);
                        $stmtCheckExistence->bind_param("s", $fetchedID);
                        $stmtCheckExistence->execute();
                        $stmtCheckExistence->bind_result($count);
                        $stmtCheckExistence->fetch();
                        $stmtCheckExistence->close();

                        if ($count > 0) {
                            echo "<script>
                                    alert('Error: You already have record.');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 500 milliseconds (3 seconds) delay
                                </script>";
                            exit();
                        }else {

                            //fetch email and name
                            $query_email_name = "SELECT name, email FROM signup WHERE id = ? ";
                            $query_E_N = $con->prepare($query_email_name);
                            $query_E_N ->bind_param("i",$fetchedID);
                            $query_E_N ->execute();
                            $query_E_N ->bind_result($sendName,$sendEmail);
                            $query_E_N ->fetch();
                            $query_E_N ->close();

                            // Insert file to  datanase if file is successfully uploaded to folder
                            $sql = "INSERT INTO `xray` (`user_id`, `doctor_name`, `clinic`, `DateofPayment`, `ORnumber`, `Document`) 
                                    VALUES (?, ?, ?, ?, ?, ?)";
            
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param("ssssss", $fetchedID, $doctor, $clinic_name, $DateOfPayment, $or, $fileName);
                            
                            /* sends email to user if document uplaod is success */
                            
                            require __DIR__.'/PHPMailer/src/PHPMailer.php';
                            require __DIR__.'/PHPMailer/src/SMTP.php';
                            require __DIR__.'/PHPMailer/src/Exception.php';    
                            $mail = new PHPMailer(true);
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
                            $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
                            $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
                            $mail->Port       = 465; 
            
                            $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
                            $mail->addAddress($sendEmail);// Add a recipient email address
                            $mail->isHTML(true);
                            $mail->Subject = 'Thank You for Uploading Your Document';
                            $mail->Body    = '<h2>Hello '."$sendName".',</h2>
                                                <p style="font-size:14px;">
                                                ACLC Collage of Tacloban would like to express there gratitude for uploading your document to our platform. Your contribution is invaluable and greatly appreciated.<br>
                                                Your document has been successfully uploaded and is now securely stored in our system.
                                                If you have any further documents to upload or need assistance with anything else, please do not hesitate to reach out to us.<br><br>

                                                Thank you once again for your contribution.
                                                </p>';

                            if ($stmt->execute() && $mail->send()) {
                                echo "<script>
                                        window.location.href = window.location.href;
                                    </script>";
                            } else {
                                echo "<script>
                                        alert('Error: Unable to save file information.');
                                        setTimeout(function() {
                                            window.location.href = window.location.href;
                                        }, 500); // 500 milliseconds (3 seconds) delay
                                    </script>";
                            }
            
                            $stmt->close();
                            $con->close();
                        }
                    }
                } else {
                    // Handle file upload error
                    echo "<script>
                            alert('Error: File upload error - " . $_FILES["filename_Upload"]["error"] . "');
                            window.location.href = window.location.href;
                        </script>";
                }
            }
    }
    /*
        CBC
    */
    if (isset($_POST['submit-document-cbc'])) {
        // Assuming $_SESSION['valid'] contains the user ID
        $fetchedID = $_SESSION['valid'];
    
        // Sanitize and validate input data
        $clinic_name = $_POST['clinic-cbc'];
        $doctor = $_POST['doctor-cbc'];
        $DateOfPayment = $_POST['DateOfPayment-cbc'];
        $or = $_POST['ORnumber-cbc'];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Validate file upload
            if (isset($_FILES['filename_Upload-cbc']) && $_FILES['filename_Upload-cbc']['error'] === UPLOAD_ERR_OK) {
                $allowedFileTypes = ['pdf', 'doc', 'docx'];
                $fileType = strtolower(pathinfo($_FILES['filename_Upload-cbc']['name'], PATHINFO_EXTENSION));
    
                // Check if the file type is allowed
                if (!in_array($fileType, $allowedFileTypes)) {
                    echo "<script>
                            alert('Error: Invalid file type. Please upload only PDF, DOC, or DOCX files.');
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 500); // 500 milliseconds (3 seconds) delay
                        </script>";
                    exit();
                }
    
                // Create the user-specific directory if it doesn't exist
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0755, true);
                }

                // Create the user-specific directory
                $uploads_dir = "document_upload/cbc/user_" . $fetchedID . "/";

                // Get the file name
                $fileName = basename($_FILES["filename_Upload-cbc"]["name"]);
                
                // Set the target path for the file
                $targetPath = $uploads_dir . $fileName;

                // Check if the file already exists in the local folder
                // if (file_exists($targetPath)) {
                //     echo "<script>
                //             alert('Error: You have already Uploaded a file.');
                //             setTimeout(function() {
                //                 window.location.href = window.location.href;
                //             }, 500); // 500 milliseconds (3 seconds) delay
                //         </script>";
                //     exit();
                // }
    
                // Move the uploaded file to the target path
                if (move_uploaded_file($_FILES["filename_Upload-cbc"]["tmp_name"], $targetPath)) {

                    // Check if the file already exists in the database
                    $sqlCheckExistence = "SELECT COUNT(*) FROM `cbc` WHERE `user_id` = ?";
                    $stmtCheckExistence = $con->prepare($sqlCheckExistence);
                    $stmtCheckExistence->bind_param("ss", $fetchedID);
                    $stmtCheckExistence->execute();
                    $stmtCheckExistence->bind_result($count);
                    $stmtCheckExistence->fetch();
                    $stmtCheckExistence->close();

                    if ($count > 0) {
                        echo "<script>
                                    alert('Error: You already have record.');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 500 milliseconds (3 seconds) delay
                                </script>";
                        exit();
            
                    } else {

                        //fetch email and name for sneding email
                        $query_email_name = "SELECT name, email FROM signup WHERE id = ? ";
                        $query_E_N = $con->prepare($query_email_name);
                        $query_E_N ->bind_param("i",$fetchedID);
                        $query_E_N ->execute();
                        $query_E_N ->bind_result($sendName,$sendEmail);
                        $query_E_N ->fetch();
                        $query_E_N ->close();

                        // Insert file to  datanase if file is successfully uploaded to folder
                        $sql = "INSERT INTO `cbc` (`user_id`, `doctor_name`, `clinic`, `DateofPayment`, `ORnumber`, `Document`) 
                                VALUES (?, ?, ?, ?, ?, ?)";
        
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("ssssss", $fetchedID, $doctor, $clinic_name, $DateOfPayment, $or, $fileName);
                        
                        /* sends email to user if document uplaod is success */
                        require __DIR__.'/PHPMailer/src/PHPMailer.php';
                        require __DIR__.'/PHPMailer/src/SMTP.php';
                        require __DIR__.'/PHPMailer/src/Exception.php';    
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
                        $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
                        $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
                        $mail->Port       = 465; 
        
                        $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
                        $mail->addAddress($sendEmail);// Add a recipient email address
                        $mail->isHTML(true);
                        $mail->Subject = 'Thank You for Uploading Your Document';
                        $mail->Body    = '<h2>Hello '."$sendName".',</h2>
                                            <p style="font-size:14px;">
                                            ACLC Collage of Tacloban would like to express there gratitude for uploading your document to our platform. Your contribution is invaluable and greatly appreciated.<br>
                                            Your document has been successfully uploaded and is now securely stored in our system.
                                            If you have any further documents to upload or need assistance with anything else, please do not hesitate to reach out to us.<br><br>

                                            Thank you once again for your contribution.
                                            </p>';

                        if ($stmt->execute() && $mail->send()) {
                            echo "<script>
                                        window.location.href = window.location.href;
                                </script>";
                        } else {
                            echo "<script>
                                    alert('Error: Unable to save file information.');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 500 milliseconds (3 seconds) delay
                                </script>";
                        }
        
                        $stmt->close();
                        $con->close();
                    }
                }
            } else {
                // Handle file upload error
                echo "<script>
                        alert('Error: File upload error - " . $_FILES["filename_Upload"]["error"] . "');
                        window.location.href = window.location.href;
                    </script>";
            }
        }
    }

    //unrinalysis
    if (isset($_POST['submit-document-urinalysis'])) {
        // Assuming $_SESSION['valid'] contains the user ID
        $fetchedID = $_SESSION['valid'];
    
        // Sanitize and validate input data
        $clinic_name = $_POST['clinic-urinalysis'];
        $doctor = $_POST['doctor-urinalysis'];
        $DateOfPayment = $_POST['DateOfPayment-urinalysis'];
        $or = $_POST['ORnumber-urinalysis'];


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Validate file upload
            if (isset($_FILES['filename_Upload-urinalysis']) && $_FILES['filename_Upload-urinalysis']['error'] === UPLOAD_ERR_OK) {
                $allowedFileTypes = ['pdf', 'doc', 'docx'];
                $fileType = strtolower(pathinfo($_FILES['filename_Upload-urinalysis']['name'], PATHINFO_EXTENSION));
    
                // Check if the file type is allowed
                if (!in_array($fileType, $allowedFileTypes)) {
                    echo "<script>
                            alert('Error: Invalid file type. Please upload only PDF, DOC, or DOCX files.');
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 500); // 500 milliseconds (3 seconds) delay
                        </script>";
                    exit();
                }
                // Create the user-specific directory
                $uploads_dir = "document_upload/urinalysis/user_" . $fetchedID . "/";

                // Get the file name
                $fileName = basename($_FILES["filename_Upload-urinalysis"]["name"]);

                // Set the target path for the file
                $targetPath = $uploads_dir . $fileName;
    
                // Create the user-specific directory if it doesn't exist
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0755, true);
                }
                
                //checks if document exist
                // if (file_exists($targetPath)) {
                //     echo "<script>
                //             alert('Error: You have already Uploaded a file.');
                //             setTimeout(function() {
                //                 window.location.href = window.location.href;
                //             }, 500); // 500 milliseconds (3 seconds) delay
                //         </script>";
                //     exit();
                // }

                // Move the uploaded file to the target path
                if (move_uploaded_file($_FILES["filename_Upload-urinalysis"]["tmp_name"], $targetPath)) {

                    // Check if the file already exists in the database
                    $sqlCheckExistence = "SELECT COUNT(*) FROM `urinalysis` WHERE `user_id` = ?";
                    $stmtCheckExistence = $con->prepare($sqlCheckExistence);
                    $stmtCheckExistence->bind_param("s", $fetchedID);
                    $stmtCheckExistence->execute();
                    $stmtCheckExistence->bind_result($count);
                    $stmtCheckExistence->fetch();
                    $stmtCheckExistence->close();

                    // Check if the file already exists in the local folder
                    if ($count > 0) {
                        echo "<script>
                                alert('Error: You already have record.');
                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 500); // 500 milliseconds (3 seconds) delay
                            </script>";
                        exit();

                    } else {

                        //fetch email and name for sneding email
                        $query_email_name = "SELECT name, email FROM signup WHERE id = ? ";
                        $query_E_N = $con->prepare($query_email_name);
                        $query_E_N ->bind_param("i",$fetchedID);
                        $query_E_N ->execute();
                        $query_E_N ->bind_result($sendName,$sendEmail);
                        $query_E_N ->fetch();
                        $query_E_N ->close();
       
                        // Insert file to  datanase if file is successfully uploaded to folder
                        $sql = "INSERT INTO `urinalysis` (`user_id`, `doctor_name`, `clinic`, `DateofPayment`, `ORnumber`, `Document`) 
                                VALUES (?, ?, ?, ?, ?, ?)";
        
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("ssssss", $fetchedID, $doctor, $clinic_name, $DateOfPayment, $or, $fileName);

                        /* sends email to user if document uplaod is success */
                        require __DIR__.'/PHPMailer/src/PHPMailer.php';
                        require __DIR__.'/PHPMailer/src/SMTP.php';
                        require __DIR__.'/PHPMailer/src/Exception.php';    
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
                        $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
                        $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
                        $mail->Port       = 465; 
        
                        $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
                        $mail->addAddress($sendEmail);// Add a recipient email address
                        $mail->isHTML(true);
                        $mail->Subject = 'Thank You for Uploading Your Document';
                        $mail->Body    = '<h2>Hello '."$sendName".',</h2>
                                            <p style="font-size:14px;">
                                            ACLC Collage of Tacloban would like to express there gratitude for uploading your document to our platform. Your contribution is invaluable and greatly appreciated.<br>
                                            Your document has been successfully uploaded and is now securely stored in our system.
                                            If you have any further documents to upload or need assistance with anything else, please do not hesitate to reach out to us.<br><br>
                                            Thank you once again for your contribution.
                                            </p>';

                        if ($stmt->execute() && $mail->send()) {
                            echo "<script>
                                        window.location.href = window.location.href;
                                </script>";
                        } else {
                            echo "<script>
                                    alert('Error: Unable to save file information.');
                                    setTimeout(function() {
                                    window.location.href = window.location.href;
                                    }, 500); // 500 milliseconds (3 seconds) delay
                                </script>";
                        }
        
                        $stmt->close();
                        $con->close();
                    }
                }
            } else {
                // Handle file upload error
                echo "<script>
                        alert('Error: File upload error - " . $_FILES["filename_Upload"]["error"] . "');
                        window.location.href = window.location.href;
                    </script>";
            }
        }
    }

    //miscDocuments
    if (isset($_POST['submit-document-misc'])) {
        // Assuming $_SESSION['valid'] contains the user ID
        $fetchedID = $_SESSION['valid'];
    
        // Sanitize and validate input data
        $TestName =  $_POST['testname-misc'];
        $clinic_name = $_POST['clinic-misc'];
        $doctor = $_POST['doctor-misc'];
        $DateOfPayment = $_POST['DateOfPayment-misc'];
        $or = $_POST['ORnumber-misc'];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Validate file upload
            if (isset($_FILES['filename_Upload-misc']) && $_FILES['filename_Upload-misc']['error'] === UPLOAD_ERR_OK) {
                $allowedFileTypes = ['pdf', 'doc', 'docx'];
                $fileType = strtolower(pathinfo($_FILES['filename_Upload-misc']['name'], PATHINFO_EXTENSION));
    
                // Check if the file type is allowed
                if (!in_array($fileType, $allowedFileTypes)) {
                    echo "<script>
                            alert('Error: Invalid file type. Please upload only PDF, DOC, or DOCX files.');
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 100); // 3000 milliseconds (3 seconds) delay
                        </script>";
                    exit();
                    //header("location: ../my/xray.php");
                }

                // Create the user-specific directory if it doesn't exist
                $uploads_dir = "document_upload/other/user_" . $fetchedID . "/";

                // Get the file name
                $fileName = basename($_FILES["filename_Upload-misc"]["name"]);

                // Set the target path for the file
                $targetPath = $uploads_dir . $fileName;
    
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0755, true);
                }

                // Move the uploaded file to the target path
                if (move_uploaded_file($_FILES["filename_Upload-misc"]["tmp_name"], $targetPath)) {

                    // Check if the file already exists in the database
                    $sqlCheckExistence = "SELECT COUNT(*) FROM `misc_test` WHERE `user_id` = ? AND `Document` = ?";
                    $stmtCheckExistence = $con->prepare($sqlCheckExistence);
                    $stmtCheckExistence->bind_param("ss", $fetchedID, $fileName);
                    $stmtCheckExistence->execute();
                    $stmtCheckExistence->bind_result($count);
                    $stmtCheckExistence->fetch();
                    $stmtCheckExistence->close();

                    // Check if the file already exists in the local folder and database
                    if ($count > 0) {
                        echo "<script>
                                alert('Error: You already have a similar record.');
                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 500); // 3000 milliseconds (3 seconds) delay
                            </script>";
                            
                        exit();

                    } else {

                        //fetch email and name for sneding email
                        $query_email_name = "SELECT name, email FROM signup WHERE id = ? ";
                        $query_E_N = $con->prepare($query_email_name);
                        $query_E_N ->bind_param("i",$fetchedID);
                        $query_E_N ->execute();
                        $query_E_N ->bind_result($sendName,$sendEmail);
                        $query_E_N ->fetch();
                        $query_E_N ->close();

                        // Generate a random RGB color
                        $red = mt_rand(150, 255);
                        $green = mt_rand(150, 255);
                        $blue = mt_rand(150, 255);
                    
                        // Convert RGB to HEX
                        $hexColor = sprintf("#%02x%02x%02x", $red, $green, $blue);

                        // Use prepared statement to prevent SQL injection
                        $sql = "INSERT INTO `misc_test` (`user_id`, `doctor_name`, `clinic`, `DateofPayment`, `ORnumber`, `medical_test_name` ,`Document`,`colordiv`) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("ssssssss", $fetchedID, $doctor, $clinic_name, $DateOfPayment, $or, $TestName ,$fileName, $hexColor);
                        
                        /* sends email to user if document uplaod is success */
                        require __DIR__.'/PHPMailer/src/PHPMailer.php';
                        require __DIR__.'/PHPMailer/src/SMTP.php';
                        require __DIR__.'/PHPMailer/src/Exception.php';    
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
                        $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
                        $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
                        $mail->Port       = 465; 
        
                        $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
                        $mail->addAddress($sendEmail);// Add a recipient email address
                        $mail->isHTML(true);
                        $mail->Subject = 'Thank You for Uploading Your Document';
                        $mail->Body    = '<h2>Hello '."$sendName".',</h2>
                                            <p style="font-size:14px;">
                                            ACLC Collage of Tacloban would like to express there gratitude for uploading your document to our platform. Your contribution is invaluable and greatly appreciated.<br>
                                            Your document has been successfully uploaded and is now securely stored in our system.
                                            If you have any further documents to upload or need assistance with anything else, please do not hesitate to reach out to us.<br><br>

                                            Thank you once again for your contribution.
                                            </p>';

                        if ($stmt->execute() && $mail->send()) {
                            echo "<script>
                                    alert('Thank you for uploading');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 3000 milliseconds (3 seconds) delay
                                </script>";
                        } else {
                            echo "<script>
                                    alert('Error: Unable to save file information.');
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 500); // 3000 milliseconds (3 seconds) delay
                                </script>";
                        }
        
                        $stmt->close();
                        $con->close();
                    }
                } 
            } else {
                // Handle file upload error
                echo "<script>
                        alert('Error: File upload error - " . $_FILES["filename_Upload"]["error"] . "');
                        window.location.href = window.location.href;
                    </script>";
            }
        }
    }

    /*
        sending email 
        xray
    */
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitForm'])) {

        // Access corresponding user name using the same index
        $userName = $_POST['userName'];

        // Process the form data as needed
        $message = $_POST['message-send-xray'];

        // Perform SQL query (adjust your SQL query as needed)
        $stmt = mysqli_query($con, "SELECT * FROM `signup` WHERE `name` = '$userName'");

        // Check if the query was successful
        if ($stmt) {
            // Fetch the result (you might need to adjust this based on your database structure)
            $user = mysqli_fetch_assoc($stmt);
            $email = $user['email'];
            // Use the $user data as needed
            // echo "User Name: " . $user['name'] . "<br>";
            // echo "Message: $email - $message<br>";

            require_once __DIR__.'/PHPMailer/src/PHPMailer.php';
            require_once __DIR__.'/PHPMailer/src/SMTP.php';
            require_once __DIR__.'/PHPMailer/src/Exception.php';    
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth   = true;
            $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
            $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
            $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
            $mail->Port       = 465; 

            $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
            $mail->addAddress($email);// Add a recipient email address
            $mail->isHTML(true);
            $mail->Subject = 'Attention required: Upload your Xray document now';
            $mail->Body    = '<h1>Hello, '."$userName".',</h1>
                                <p>'.$message.'</p>
                                <br><br>
                                <p style="font-size: 12px; margin-top: 10px;">
                                Please don\'t hesitate to upload your CBC document at your earliest convenience.</p>';
        if($mail->send()){
            echo "<script>alert('Message sent!');
                        setTimeout(function() {
                        window.location.href = window.location.href;
                        }, 100); // 100 milliseconds (3 seconds) delay
                </script>";
                exit();
            exit();
            }
        } else {
            // Handle query error
            echo "Error: " . mysqli_error($con);
        }
    }

    /*
        sending email 
        CBC
    */
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitForm-cbc'])) {

        // Access corresponding user name using the same index
        $userName = $_POST['userName-cbc'];

        // Process the form data as needed
        $message = $_POST['message-send-cbc'];

        // Perform SQL query (adjust your SQL query as needed)
        $stmt = mysqli_query($con, "SELECT * FROM `signup` WHERE `name` = '$userName'");

        // Check if the query was successful
        if ($stmt) {
            // Fetch the result (you might need to adjust this based on your database structure)
            $user = mysqli_fetch_assoc($stmt);
            $email = $user['email'];
            // Use the $user data as needed
            // echo "User Name: " . $user['name'] . "<br>";
            // echo "Message: $email - $message<br>";

            require_once __DIR__.'/PHPMailer/src/PHPMailer.php';
            require_once __DIR__.'/PHPMailer/src/SMTP.php';
            require_once __DIR__.'/PHPMailer/src/Exception.php';    
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth   = true;
            $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
            $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
            $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
            $mail->Port       = 465; 

            $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
            $mail->addAddress($email);// Add a recipient email address
            $mail->isHTML(true);
            $mail->Subject = 'Attention required: Upload your CBC document now';
            $mail->Body    = '<h1>Hello, '."$userName".',</h1>
                                <p>'.$message.'</p>
                                <br><br>
                                <p style="font-size: 12px; margin-top: 10px;">
                                Please don\'t hesitate to upload your CBC document at your earliest convenience.</p>';
        if($mail->send()){
            echo "<script>alert('Message sent!');
                    setTimeout(function() {
                        window.location.href = window.location.href;
                    }, 100); // 3000 milliseconds (3 seconds) delay
                </script>";
                exit();
            }
        } else {
            // Handle query error
            echo "Error: " . mysqli_error($con);
        }
    }

     /*
        sending email 
        Urinalysis
    */
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitForm-urinalysis'])) {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        
       // Access corresponding user name using the same index
        $userName = $_POST['userName-urinalysis'];

        // Process the form data as needed
        $message = $_POST['message-send-urinalysis'];

        // Perform SQL query (adjust your SQL query as needed)
        $stmt = mysqli_query($con, "SELECT * FROM `signup` WHERE `name` = '$userName'");

        // Check if the query was successful
        if ($stmt) {
            // Fetch the result (you might need to adjust this based on your database structure)
            $user = mysqli_fetch_assoc($stmt);
            $email = $user['email'];
            // Use the $user data as needed
            // echo "User Name: " . $user['name'] . "<br>";
            // echo "Message: $email - $message<br>";
            
            require_once __DIR__.'/PHPMailer/src/PHPMailer.php';
            require_once __DIR__.'/PHPMailer/src/SMTP.php';
            require_once __DIR__.'/PHPMailer/src/Exception.php';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth   = true;
            $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
            $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
            $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
            $mail->Port       = 465; 

            $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
            $mail->addAddress($email);// Add a recipient email address
            $mail->isHTML(true);
            $mail->Subject = 'Attention required: Upload your CBC document now';
            $mail->Body    = '<h1>Hello, '."$userName".',</h1>
                                <p>'.$message.'</p>
                                <br><br>
                                <p style="font-size: 12px; margin-top: 10px;">
                                Please don\'t hesitate to upload your CBC document at your earliest convenience.</p>';
                
                if($mail->send()){
                    echo "<script>alert('Message sent!');
                            setTimeout(function() {
                                window.location.href = window.location.href;
                            }, 100); // 3000 milliseconds (3 seconds) delay
                        </script>";
                        exit();
                }
        } else {
            // Handle query error
            echo "Error: " . mysqli_error($con);
        }
        // $con->close();
        // $stmt->close();
    }

     /*
        sending email 
        Message email 
    */
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitMessageMail'])) {

        // Access corresponding user name using the same index
        $emailfetch = $_POST['email-select-message'];

        // Process the form data as needed
        $message = $_POST['message-send-email'];

        // Perform SQL query (adjust your SQL query as needed)
        $stmt = mysqli_query($con, "SELECT * FROM `signup` WHERE `email` = '$emailfetch'");

        // Check if the query was successful
        if ($stmt) {
            // Fetch the result (you might need to adjust this based on your database structure)
            $user = mysqli_fetch_assoc($stmt);
            $email = $user['email'];

            // Use the $user data as needed
            // echo "User Name: " . $user['name'] . "<br>";
            // echo "Message: $email - $message<br>";

            require_once __DIR__.'/PHPMailer/src/PHPMailer.php';
            require_once __DIR__.'/PHPMailer/src/SMTP.php';
            require_once __DIR__.'/PHPMailer/src/Exception.php'; 

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth   = true;
            $mail->Username   = 'j3909292@gmail.com';   // Your SMTP username
            $mail->Password   = 'nkllbxuxsdxnbdwj';   // Your SMTP password
            $mail->SMTPSecure = 'ssl';             // Enable TLS encryption (ssl also possible)
            $mail->Port       = 465; 

            $mail->setFrom('j3909292@gmail.com'); // Set the sender's email address and name
            $mail->addAddress($email);// Add a recipient email address
            $mail->isHTML(true);
            $mail->Subject = 'Uploaded Document';
            $mail->Body    = '<h2>Hello there,</h2>
                                <p>'.$message.'</p>
                                <br><br><br><br>
                                <br><br><br><br>
                                <p style="font-size: 12px; margin-top: 10px; bottom:0;">
                                Please don\'t hesitate to upload your CBC document at your earliest convenience.</p>';

                if($mail->send()){
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                let app = document.getElementById('approvedContainer');
                                app.style.display = 'block';
                                setTimeout(function() {
                                    app.style.display = 'none';
                                }, 3000);
                                windows.location.href = window.location.href
                            });
                        </script>";
                }
        } else {
            // Handle query error
            echo "Error: " . mysqli_error($con);
        }
    }

?>