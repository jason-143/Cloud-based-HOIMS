<?php
session_start();
error_reporting(1);
include('../acc/function.php');
include('./query_.php');
$pageTitle = "admin account";
$id = $_SESSION['valid'];
include('../my/header.php');
$userID = $_SESSION['valid'];
    /*check if user is login, will then redirected to login if not.*/ 
    if (!isset($_SESSION['valid'])) {
        header("Location: ../acc/logout.php");
    } else {        
?>
<div class="main-body-holder">
    <div class="main-body-content">
        <div class="form-content">
            <div class="top-form-content">
                <div class="title">
                    <label id="my-account" for="top-form-title">Admin account</label><br><br>
                </div>
                <div class="button-container">
                    <button onclick="editAdminaccount()" id="edit-button-id" class="edit-button">Edit Account</button><br>
                    <!-- <button onclick="" id="edit-button-id" class="edit-button">Delete Account</button><br> -->
                </div>
            </div>
            <div style="display: none;" id="validate-admin-idenity" class="top-form-content">
                <form action="" method="post">
                    <br><label class="title-input">Verify password</label><br>
                    <div class="user user-password">
                        <input class="in-put" oninput="this.value = this.value.toUpperCase()" id="password-hide-admin" type="password" name="admin-password" placeholder="&#xf023;&nbsp; " style="font-family:Arial, FontAwesome;">
                    </div>
                    <div style="display: flex;flex-wrap:wrap;" class="user">
                        <div class="button-action" style="padding:10px">
                            <input class="edit-button" type="submit" name="validate-pass" value="confirm">
                            <input class="edit-button" type="button" onclick="cancelupdateAdmin()" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
           <?php
                if (isset($_POST['validate-pass'])) {
                    
                    $id = 1;
                    $verify = $_POST['admin-password'];

                    $stm = "SELECT `password` FROM `signup` WHERE `id` = ?";
                    $pre = $con->prepare($stm);
                    $pre->bind_param("i",$id);
                    $pre->execute();
                    $pre->store_result();
                   
                    if ($pre->execute()) {
                        $pre->bind_result($fetchpass);
                        $pre->fetch();
                        if (password_verify($verify, $fetchpass)) {
            ?>
                            <div id="input-admin-account" class="top-form-content">
                                <form id="main-form" action="" method="post">
                                    <br><label class="title-input">Admin Account</label><br>
                                        <div class="user user-firstname">
                                            <label class="input-title-top-container" for="input-firstname-hide">NAME</label><br>
                                            <input oninput="this.value = this.value.toUpperCase()" class="in-put" id="name-hide-admin" type="text" name="admin-username" placeholder="&#xf007;&nbsp; <?php echo $fname; ?>" style="font-family:Arial, FontAwesome;">
                                        </div>
                                        <div class="user user-password">
                                            <label class="input-title-top-container" for="password">PASSWORD</label><br>
                                            <input oninput="this.value = this.value.toUpperCase()" class="in-put" id="password-hide-admin" type="password" name="admin-password" placeholder="&#xf023;&nbsp; " style="font-family:Arial, FontAwesome;">
                                        </div>
                                        <div class="button-action" style="padding:10px">
                                            <input class="save-edit edit-button" name="submit-update-admin" id="validate-input-password" type="submit" value="Update Profile">
                                        </div>
                                        <div style="display: flex;flex-wrap:wrap;" class="user">
                                            <div class="button-action" style="padding:10px">
                                                <input class="edit-button" type="submit" name="submit-update-admin" value="confirm">
                                                <button class="edit-button" type="button" onclick="reload()">Cancel</button>
                                            </div>
                                        </div>
                                </form>
                                <script>document.getElementById("edit-button-id").style.display ="none" 
                                            function reload() {
                                                setTimeout(function() {
                                                    window.location.href = window.location.href;
                                                }, 500); // 500 milliseconds delay
                                            }</script>
                            </div>
            <?php
                        } else {
                            echo "<script>
                                alert('Error: Invalid Password');
                                setTimeout(function() {
                                    window.location.href = window.location.href;
                                }, 500); // 500 milliseconds delay
                            </script>";
                        exit();
                        }
                    }
                }
           ?>
            <!--
                 Form adding Employee manually
            -->
            <div class="top-form-content">
                <div class="form title">
                    <label id="my-account" for="top-form-title">Add Employee</label><br><br>
                </div>
                <div class="form button-container">
                    <button onclick="addEmployee()" id="add-emplyee" class="edit-button">Add</button><br>
                    <button type="button" style="display: none; position:relative;" onclick="cancelAdd()" class="save-edit edit-button" id="cancel-add-employee">Cancel</button>
                </div>
                <div style="display: none;" id="add-employee-form-container" class="form">
                    <form id="main-form" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                        <br><label class="title-input">USER INFORMATION</label><br>
                        <div class="user-information">
                            <div class="user user-firstname">
                                <label class="input-title-top-container" for="input-firstname-hide">FIRST NAME</label><br>
                                <input required class="in-put" id="input-firstname-hide" type="text" name="add-fname" placeholder="&#xf007;&nbsp;first name" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user user-lastname">
                                <label class="input-title-top-container" for="input-lastname-hide">LAST NAME</label><br>
                                <input required class="in-put" id="input-lastname-hide" type="text" name="add-lname" placeholder="&#xf007;&nbsp;last name" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user mobile-number">
                                <label class="input-title-top-container" for="input-mobile-hide">MOBILE NUMBER</label><br>
                                <input maxlength="11" required class="in-put" id="input-mobile-hide" oninput="validateNumber(this)" type="text" name="add-cellnumber" placeholder="+63 &nbsp; " style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user email-address">
                                <label class="input-title-top-container" for="input-email-hide">EMAIL</label><br>
                                <input required class="in-put" id="input-email-hide" type="email" name="add-email" placeholder="&#xf0e0;&nbsp; @gmail.com" style="font-family:Arial, FontAwesome;"><br>
                            </div>
                            <div class="user address-username">
                                <label class="input-title-top-container" for="input-address-hide">ADDRESS</label><br>
                                <input required class="in-put" id="input-address-hide" type="text" name="add-address" placeholder="&#xf041;&nbsp; address" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user b-day">
                                <label class="input-title-top-container" for="input-bday-hide">BIRTHDAY</label><br>
                                <input required class="in-put" id="input-bday-hide" type="Date" name="add-bday" placeholder="&#xf0e0;&nbsp; birthday" style="font-family:Arial, FontAwesome;"><br>
                            </div>
                            <div class="user user-un">
                                <label class="input-title-top-container" for="input-un-hide">Gender</label><br>
                                <select required name="add-gender" class="in-put" id="input-un-hide">
                                    <option value="">Please select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="user user-password">
                                <label class="input-title-top-container" for="input-password-hide">PASSWORD</label><br>
                                <input required class="in-put" id="input-password-hide" type="password" name="add-password" placeholder="&#xf023;&nbsp; password" style="font-family:Arial, FontAwesome;">
                            </div>
                        </div>
                        <br><br><br><label class="title-input">EMPLOYEE INFORMATION</label><br>
                        <div class="user-information">
                            <div class="user user-address">
                                <label class="input-title-top-container" for="input-occupation-hide">OCCUPATION</label><br>
                                <input required class="in-put" id="input-occupation-hide" type="text" name="add-occupation" placeholder="&#xf2bb;&nbsp;occupation" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user user-city">
                                <label class="input-title-top-container" for="input-school-hide">SCHOOL</label><br>
                                <input required class="in-put" id="input-school-hide" type="text" name="add-school" placeholder="&#xf19c;&nbsp;school" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user user-country">
                                <label class="input-title-top-container" for="input-status-hide">STATUS</label><br>
                                <select required name="add-status" class="in-put" id="input-status-hide">
                                    <option value="">Marital Status</option>
                                    <option value="Single">SINGLE</option>
                                    <option value="Married">MARRIED</option>
                                    <option value="Divorced">DIVORCED</option>
                                </select>
                            </div>
                            <div class="user user-postal-code">
                                <label class="input-title-top-container" for="input-department-hide">DEPARTMENT</label><br>
                                <input required class="in-put" id="input-department-hide" type="text" name="add-department" placeholder="&#xf022;&nbsp; department" style="font-family:Arial, FontAwesome;">
                            </div>
                            <div class="user user-postal-code">
                                <label class="input-title-top-container" for="input-type-hide">EMPLOYEE TYPE</label><br>
                                <input required class="in-put" id="input-type-hide" type="text" name="add-type" placeholder="&#xf022;&nbsp;employee type" style="font-family:Arial, FontAwesome;">
                            </div>
                        </div>
                        <div class="submit">
                            <input name="submit-add-employee" id="submit-add-employee" type="submit" value="Save"><br><br><br><br><br><br>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/acc.js"></script>
<?php include("./footer.php"); }?>