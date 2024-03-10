<?php
session_start();
error_reporting(1);
include('../acc/function.php');
include('./query/query.php');
$pageTitle = "Account";
$id = $_SESSION['valid'];
include('./header.php');
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
                    <label id="my-account" for="top-form-title">My account</label><br><br>
                </div>
                <div class="button-container">
                    <button onclick="editaccount()" id="edit-button-id" class="edit-button">Edit Account</button><br>
                    <!-- <button onclick="" id="edit-button-id" class="edit-button">Delete Account</button><br> -->
                    <button style="display: none;" onclick="cancelupdate()" class="save-edit edit-button" id="Cancel-button">Cancel</button>
                </div>
            </div>
            <form id="main-form" action="" method="post">
                <br><label class="title-input">USER INFORMATION</label><br>
                <div class="user-information">
                    <div class="user user-firstname">
                        <label class="input-title-top-container" for="input-firstname-hide">FIRST NAME</label><br>
                        <input class="in-put" id="input-firstname-hide" type="text" name="acc-fname" placeholder="&#xf007;&nbsp; <?php echo $fname; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-lastname">
                        <label class="input-title-top-container" for="input-lastname-hide">LAST NAME</label><br>
                        <input class="in-put" id="input-lastname-hide" type="text" name="acc-lname" placeholder="&#xf007;&nbsp; <?php echo $flastname; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user mobile-number">
                        <label class="input-title-top-container" for="input-mobile-hide">MOBILE NUMBER</label><br>
                        <input class="in-put" id="input-mobile-hide" type="text" name="acc-cellnumber" placeholder="+63 &nbsp; <?php echo $fnum; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user email-address">
                        <label class="input-title-top-container" for="input-email-hide">EMAIL</label><br>
                        <input class="in-put" id="input-email-hide" type="email" name="acc-email" placeholder="&#xf0e0;&nbsp; <?php echo $femail; ?>" style="font-family:Arial, FontAwesome;"><br>
                    </div>
                    <div class="user address-username">
                        <label class="input-title-top-container" for="input-address-hide">ADDRESS</label><br>
                        <input class="in-put" id="input-address-hide" type="text" name="acc-address" placeholder="&#xf041;&nbsp; <?php echo $fadd ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user b-day">
                        <label class="input-title-top-container" for="input-bday-hide">BIRTHDAY</label><br>
                        <input class="in-put" id="input-bday-hide" type="Date" name="acc-bday" value="<?php echo $fbday ?>" style="font-family:Arial, FontAwesome;"><br>
                    </div>
                    <div class="user user-un">
                        <label class="input-title-top-container" for="gender">Gender</label><br>
                        <select name="acc-gender" class="in-put" id="input-un-hide">
                            <option value=""><?php if ($fgender == "") {
                                                    echo "Please select your gender";
                                                } else {
                                                    echo $fgender;
                                                } ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="user user-password">
                        <label class="input-title-top-container" for="password">PASSWORD</label><br>
                        <input class="in-put" id="input-password-hide" type="password" name="acc-password" placeholder="&#xf023;&nbsp; " style="font-family:Arial, FontAwesome;">
                    </div>
                </div>
                <br><br><br><label class="title-input">EMPLOYEE INFORMATION</label><br>
                <div class="user-information">
                    <div class="user user-address">
                        <label class="input-title-top-container" for="input-occupation-hide">OCCUPATION</label><br>
                        <input class="in-put" id="input-occupation-hide" type="text" name="acc-occupation" placeholder="&#xf2bb;&nbsp; <?php echo $Ocupation; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-city">
                        <label class="input-title-top-container" for="input-school-hide">SCHOOL</label><br>
                        <input class="in-put" id="input-school-hide" type="text" name="acc-school" placeholder="&#xf19c;&nbsp; <?php echo $school; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-country">
                        <label class="input-title-top-container" for="input-status-hide">STATUS</label><br>
                        <select name="acc-status" class="in-put" id="input-status-hide">
                            <option value=""><?php if ($status == "") {
                                                    echo "Marital Status";
                                                } else {
                                                    echo $status;
                                                } ?></option>
                            <option value="Single">SINGLE</option>
                            <option value="Married">MARRIED</option>
                            <option value="Divorced">DIVORCED</option>
                        </select>
                    </div>
                    <div class="user user-postal-code">
                        <label class="input-title-top-container" for="input-department-hide">DEPARTMENT</label><br>
                        <input class="in-put" id="input-department-hide" type="text" name="acc-department" placeholder="&#xf022;&nbsp; <?php echo $Dept; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-postal-code">
                        <label class="input-title-top-container" for="input-type-hide">EMPLOYEE TYPE</label><br>
                        <input class="in-put" id="input-type-hide" type="text" name="acc-type" placeholder="&#xf022;&nbsp; <?php echo $etype; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                </div>
                <div class="user-information">
                    <div class="user">
                        <input style="display: none;" class="save-edit edit-button" name="submit-update" id="save-input" type="submit" value="Update Profile"><br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/account.js"></script>
<script src="../js/accountDisable.js"></script>
<?php include("./footer.php"); }?>