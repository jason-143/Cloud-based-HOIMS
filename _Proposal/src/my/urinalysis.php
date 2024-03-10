<?php
session_start();
error_reporting(1);
include('../acc/function.php');
//include('../acc/FileType.php');
$pageTitle = "Urinalysis";
$fetchedID = $_SESSION['valid'];
include('./header.php');
   /*check if user is login, will then redirected to login if not.*/ 
   if (!isset($_SESSION['valid'])) {
    header("Location: ../acc/logout.php");
} else { 
?>
<div class="main-body-holder">
    <div class="main-body-content">
        <?php 
              $sqlCheckExistence = "SELECT COUNT(*) FROM `urinalysis` WHERE `user_id` = ?";
              $stmtCheckExistence = $con->prepare($sqlCheckExistence);
              $stmtCheckExistence->bind_param("s", $fetchedID);
              $stmtCheckExistence->execute();
              $stmtCheckExistence->bind_result($count);
              $stmtCheckExistence->fetch();
              $stmtCheckExistence->close();

              // Check if the file already exists in the local folder
              if ($count > 0) {
                  ?>
                  
                  <div class="form-content">
            <div class="top-form-content">
                <div class="title">
                    <label id="my-account" for="top-form-title">Urinalysis</label><br><br>
                    <p>Done Uploading <span style="font-family:Arial, FontAwesome; color:greenyellow">&#xf00c;</span></p>
                </div>
                <div class="button-container done-image-container">
                    <div class="done-upload-urinalysis">

                    </div>
                </div>
            </div>
        </div> 
                  <?php
              }else{
        ?>
        <div class="form-content">
            <div class="top-form-content">
                <div class="title">
                    <label id="my-account" for="top-form-title">Urinalysis</label><br><br>
                </div>
                <div class="button-container">
                    <!-- <button onclick="editaccount()" id="edit-button-id" class="edit-button">Edit Account</button><br> -->
                    <!-- <button onclick="" id="edit-button-id" class="edit-button">Delete Account</button><br> -->
                    <!-- <button onclick="cancelupdate()" class="save-edit edit-button" id="Cancel-button">Cancel</button> -->
                </div>
            </div>
            <form id="document-form-file" action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" onsubmit="return showLoading();" method="post" enctype="multipart/form-data">
                <br><label class="title-input">Medical Practitioner Information</label><br>
                <div class="user-information">
                    <div class="user user-username">
                        <label class="input-title-top-container" for="clinic">Clinic Name</label><br>
                        <input maxlength="20" required class="in-put" type="text" name="clinic-urinalysis" placeholder="&#xf0f8; name" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user email-address">
                        <label class="input-title-top-container" for="doctor">Doctor</label><br>
                        <input maxlength="20" required class="in-put" type="text" name="doctor-urinalysis" placeholder="&#xf0f0; name" style="font-family:Arial, FontAwesome;"><br>
                    </div>
                    <div class="user user-firstname">
                        <label class="input-title-top-container" for="DateOfPayment">Date of payment</label><br>
                        <input required class="in-put" type="Date" name="DateOfPayment-urinalysis" placeholder="payment" style="font-family:Arial, FontAwesome;">
                    </div>
                    <div class="user user-lastname">
                        <label class="input-title-top-container" for="ORnumber">Official Receipt Number</label><br>
                        <input maxlength="50" required class="in-put" type="text" name="ORnumber-urinalysis" oninput="validateNumber(this)" placeholder="receipt" style="font-family:Arial, FontAwesome;">
                    </div>
                </div>
                <br><br><br><label class="title-input">Upload Document (.pdf .doc .docs)</label><br>
                <div id="drop-area" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                    <div><img src="../images/upload.png" width="50px" alt="upload"></div>
                    <div><strong>Choose a file</strong> or drag it here.</div>
                    <input type="file" id="file-input" name="filename_Upload-urinalysis" multiple onchange="handleFiles(this.files)">
                    <ul id="file-list"></ul>
                </div>
                <div class="user-information">
                    <div class="submit-upload-document">
                        <input id="save-input-urinalysis" name="submit-document-urinalysis" type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
        <?php }?>

        <!-- loading animation -->
        <div id="loadingContainer" class="sending-animated-container">
            <div class="content-notify image-animated-container">
                <img width="40px" src="../images/eco.gif" alt="file uploading animation">
            </div>
            <div class="content-notify text-animated-container">
                <p>uploading...&nbsp;&nbsp;&nbsp;</p>
            </div>
        </div>
        <!-- end -->

    </div>
</div>
<script src="../js/filetype.js"></script>
<script src="../js/form.js"></script>
<?php include("./footer.php"); }?>