<?php
session_start();
error_reporting(1);
include('../acc/function.php');
$pageTitle = "Upload";
include('./header.php');
   /*check if user is login, will then redirected to login if not.*/ 
   if (!isset($_SESSION['valid'])) {
    header("Location: ../acc/logout.php");
} else { 
?>
<div class="main-body-holder">
    <div class="main-body-content">
        <div class="form-content">
            <div class="upload-content-container">
                <div class="title">
                    <label id="my-account" for="top-form-title">Upload</label><br><br>
                    <p>&nbsp;&nbsp;&nbsp;Explore and view your uploaded documents</p><br><br>
                </div>
                <div class="upload-form-content">
                    <div class="upload xray-container">
                        <h3>X-ray Document</h3><br>
                        <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `xray` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                    <p><?php echo $rows['Document']; ?></p>                  
                                    <p><?php echo $rows['Upload_date'] ?></p>
                                    <p><?php echo $rows['approval_status'] ?></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                                <p>No Documents Uploaded</p>
                                <p>Pending</p><br>
                                <a class="upload-documet-from-upload" href="./xray.php">Upload</a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="upload xray-container">
                        <h3>Complete Blood Count Document</h3><br>
                        <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `cbc` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                    <p><?php echo $rows['Document'] ?></p>
                                    <p><?php echo $rows['Upload_date'] ?></p>
                                    <p><?php echo $rows['approval_status'] ?></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                                <p>No Documents Uploaded</p>
                                <p>Pending</p><br>
                                <a class="upload-documet-from-upload" href="./formCBC.php">Upload</a>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="upload xray-container">
                        <h3>Urinalysis Document</h3><br>
                        <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `urinalysis` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                    <p><?php echo $rows['Document'] ?></p>
                                    <p><?php echo $rows['Upload_date'] ?></p>
                                    <p><?php echo $rows['approval_status'] ?></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                                <p>No Documents Uploaded</p>
                                <p>Pending</p><br>
                                <a class="upload-documet-from-upload" href="./urinalysis.php">Upload</a>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="upload xray-container">
                        <h3>Other Document</h3><br>
                        <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `misc_test` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>      
                                    <div class="upload-container upload-name">
                                    <p><?php echo $rows['Document'] ?></p>
                                    <p><?php echo $rows['Upload_date'] ?></p>
                                    <p><?php echo $rows['approval_status'] ?></p>
                                    </div>
                            <?php
                            }
                        } else {
                            ?>
                                <div class="upload-container upload-name">
                                    <p>No Documents Uploaded</p>
                                    <p>Pending</p><br>
                                    <a class="upload-documet-from-upload" href="./other.php">Upload</a>
                                </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="../js/form.js"></script>
<?php include("./footer.php"); }?>