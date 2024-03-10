<?php
session_start();
error_reporting(1);
include('../acc/function.php');
$pageTitle = "Notification";
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
                    <label id="my-account" for="top-form-title">Notification</label><br><br>
                </div>
                <div class="button-container">
                    <Label>You have no reminder</Label>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/form.js"></script>
<?php include("./footer.php"); }?>