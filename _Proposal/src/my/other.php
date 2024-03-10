<?php
session_start();
error_reporting(1);
include('../acc/function.php');
//include('../acc/FileType.php');
$pageTitle = "Other";
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
                    <label id="my-account" for="top-form-title">Other Document</label><br><br>
                </div>
            </div> 
            <form id="document-form-file" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post" enctype="multipart/form-data">
                <br><label class="title-input">Medical Practitioner Information</label><br>
                <div class="user-information">
                    <div class="user user-username">
                        <label class="input-title-top-container" for="clinic">Clinic Name</label><br>
                        <input maxlength="20" required class="in-put" type="text" name="clinic-misc" placeholder="&#xf0f8; name" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user email-address">
                        <label class="input-title-top-container" for="doctor">Doctor</label><br>
                        <input maxlength="20" required class="in-put" type="text" name="doctor-misc" placeholder="&#xf0f0; name" style="font-family:Arial, FontAwesome;"><br>
                    </div>
                    <div class="user user-firstname">
                        <label class="input-title-top-container" for="DateOfPayment">Date of payment</label><br>
                        <input required class="in-put" type="Date" name="DateOfPayment-misc" placeholder="" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-lastname">
                        <label class="input-title-top-container" for="ORnumber">Official Receipt Number</label><br>
                        <input maxlength="50" required class="in-put" type="text" name="ORnumber-misc" oninput="validateNumber(this)" placeholder="" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-medical-test-name">
                        <label class="input-title-top-container" for="clinic">Medical Name</label><br>
                        <input maxlength="20" required class="in-put" type="text" name="testname-misc" placeholder="<?php $id = $_SESSION['valid']; echo $id; ?>" style="font-family:Arial, FontAwesome;">
                    </div>
                </div>
                <br><br><br><label class="title-input">Upload Document (.pdf .doc .docs)</label><br>
                <div id="drop-area" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                    <div><img src="../images/upload.png" width="50px" alt="upload"></div>
                    <div><strong>Choose a file</strong> or drag it here.</div>
                    <input type="file" id="file-input" name="filename_Upload-misc" multiple onchange="handleFiles(this.files)">
                    <ul id="file-list"></ul>
                </div>
                <div class="user-information">
                    <div class="submit-upload-document">
                        <input id="save-input-cbc" name="submit-document-misc" type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>

        <!-- loading animation -->
        <!-- <div id="loadingContainer" class="sending-animated-container">
            <div class="content-notify image-animated-container">
                <img width="40px" src="../images/eco.gif" alt="file uploading animation">
            </div>
            <div class="content-notify text-animated-container">
                <p>uploading...&nbsp;&nbsp;&nbsp;</p>
            </div>
        </div> -->
        <!-- end -->

    </div>
</div>
<script src="../js/filetype.js"></script>
<script src="../js/form.js"></script>
<?php include("./footer.php"); }?>