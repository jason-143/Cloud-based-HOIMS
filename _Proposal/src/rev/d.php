<?php
error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../acc/function.php');
include('./query_.php');
$pageTitle = "Document";
// $userID = $_SESSION['valid'];
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
                <div class="title">
                    <label id="my-account" for="top-form-title">Document</label><br><br>
                </div>
                <!-- Xray table -->
                <div class="xray no-upload">
                        <h3>X-ray Document</h3><br>
                        <?php
                        $stmt = "SELECT *
                            FROM signup
                            LEFT JOIN xray ON signup.id = xray.user_id
                            WHERE signup.UserType = 1";
                            
                        $xquery = mysqli_query($con, $stmt);
                        $allUploaded = true;
                        $missingDocumentCount = 0;

                        ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                    <th>Name</th>
                                    <th>Document</th>
                                    <th>Upload Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($xrayrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrayrows['user_id'] !== null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post" enctype="multipart/form-data">
                                                <td data-cell="Name: "><?php echo $xrayrows['name']; ?>
                                                    <input type="hidden" value="<?php echo $xrayrows['name'];?>" name="name-deletion-container">
                                                </td>
                                                <td data-cell="Document: "><?php echo $xrayrows['Document']; ?></td>
                                                <td data-cell="Upload date: "><?php echo $xrayrows['Upload_date']; ?></td>
                                                <td data-cell="Expiry date: "><?php echo $xrayrows['expiry_date']; ?></td>
                                                <td data-cell="Status: "><?php echo $xrayrows['approval_status']; ?></td>
                                                <td data-cell="Action"><br>
                                                    <?php
                                                        $filePath = "../my/document_upload/xray/user_" . $xrayrows['user_id'] . "/" . $xrayrows['Document'];
                                                        if (file_exists($filePath)) {
                                                            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                                                            header('Content-Disposition: attachment; filename="' . $fileName . '"');
                                                            header('Content-Length: ' . filesize($filePath));
                                                            ?>
                                                            <!-- download button -->
                                                            <a class="download-document-link-button" style="font-family:Arial, FontAwesome;" download href="../my/document/xray/user_<?php echo $xrayrows['user_id']; ?>/<?php echo $xrayrows['Document']; ?>">&#xf019;&nbsp;&nbsp;Download&nbsp;</a>
                                                            <!-- delete button -->
                                                            <br><br><input class="delete-document-link-button" onclick="return confirmDelete();" style="font-family:Arial, FontAwesome;" type="submit" name="delete-user-document-xray" value="&#xf1f8;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                                                            <!-- hidden input - passing data -->
                                                            <input type="hidden" name="doc-name-container-xray" value="<?php echo $xrayrows['Document']?>">
                                                            <input type="hidden" value="<?php echo $xrayrows['user_id'];?>" name="id-deletion-xray">
                                                    <?php
                                                        } else {
                                                            echo "File not found";
                                                        }
                                                    ?>
                                                </td>
                                                <td  data-cell="Approval: "><br>
                                                    <input  class="approved-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Approved-xray" value="&#xf164;&nbsp;&nbsp;Approved&nbsp;&nbsp;"><br><br>
                                                    <input class="diclined-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Declined-xray" value="&#xf165;&nbsp;&nbsp;Declined&nbsp;&nbsp;&nbsp;&nbsp;">
                                                </td>
                                            </form>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table> <?php
                                    if ($allUploaded) {
                                    ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo " No " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>

                        <?php
                                    }
                        ?>
                </div>
                <!-- end of xray table -->
                <!-- CBC table -->
                <div class="cbc no-upload">
                    <h3>Complete Blood Count Document</h3><br>
                    <?php
                        $stmt = "SELECT *
                            FROM signup
                            LEFT JOIN cbc ON signup.id = cbc.user_id
                            WHERE signup.UserType = 1";
                        $xquery = mysqli_query($con, $stmt);

                        $allUploaded = true;
                        $missingDocumentCount = 0;

                        ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186)">
                                    <th>Name</th>
                                    <th>Document</th>
                                    <th>Upload Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($xrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrows['user_id'] !== null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post" enctype="multipart/form-data">
                                                <td data-cell="Name: "><?php echo $xrows['name']; ?></td>
                                                <td data-cell="Document: "><?php echo $xrows['Document']; ?></td>
                                                <td data-cell="Upload date: "><?php echo $xrows['Upload_date']; ?></td>
                                                <td data-cell="Expiry date: "><?php echo $xrows['expiry_date']; ?></td>
                                                <td data-cell="Status: "><?php  ?><?php echo $xrows['approval_status']; ?></td>
                                                <td data-cell="Action: "><br>
                                                <?php
                                                        $filePath = "../my/document_upload/cbc/user_" . $xrows['user_id'] . "/" . $xrows['Document'];
                                                        if (file_exists($filePath)) {
                                                            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                                                            header('Content-Disposition: attachment; filename="' . $fileName . '"');
                                                            header('Content-Length: ' . filesize($filePath));
                                                    ?>      
                                                            <!-- download button -->
                                                            <a class="download-document-link-button" style="font-family:Arial, FontAwesome;" download href="../my/document/cbc/user_<?php echo $xrows['user_id']; ?>/<?php echo $xrows['Document']; ?>">&#xf019;&nbsp;Download&nbsp;&nbsp;</a>
                                                            <!-- delete button -->
                                                            <br><br><input class="delete-document-link-button" onclick="return confirmDelete();" style="font-family:Arial, FontAwesome;" type="submit" name="delete-user-document-cbc" value="&#xf1f8;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                                                        <!-- hidden input - passing data -->
                                                        <input type="hidden" name="doc-name-container-cbc" value="<?php echo $xrows['Document']?>">
                                                        <input type="hidden" value="<?php echo $xrows['user_id'];?>" name="id-deletion-cbc">
                                                        <script>
                                                                    function confirmDelete() {
                                                                        let userResponseMisc = confirm("Confirm: Do you want to delete the record?");
                                                                        if (userResponseMisc) {
                                                                            return true; // Allow form submission
                                                                        } else {
                                                                            window.location.reload();
                                                                            return false; // Prevent form submission
                                                                        }
                                                                    }
                                                            </script>
                                                   
                                                   <?php
                                                        } else {
                                                            echo "File not found";
                                                        }
                                                    ?>
                                                </td>
                                                <td  data-cell="Aproval: "><br>
                                                    <input  class="approved-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Approved-cbc" value="&#xf164;&nbsp;&nbsp;Approved&nbsp;&nbsp;"><br><br>
                                                    <input class="diclined-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Declined-cbc" value="&#xf165;&nbsp;&nbsp;Declined&nbsp;&nbsp;&nbsp;&nbsp;">
                                                </td>
                                            </form>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table> <?php
                                    if ($allUploaded) {
                                    ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo " No " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>

                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    }
                        ?>
                </div>
                <!-- end of cbc table -->
                <!-- Urinalysis table -->
                <div class="Urinalysis no-upload">
                    <h3>Urinalysis Document</h3><br>
                    <?php
                        $stmt = "SELECT *
                        FROM signup
                        LEFT JOIN urinalysis ON signup.id = urinalysis.user_id
                        WHERE signup.UserType = 1";
                        $xquery = mysqli_query($con, $stmt);

                        $allUploaded = true;
                        $missingDocumentCount = 0;

                        ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186)">
                                    <th>Name</th>
                                    <th>Document</th>
                                    <th>Upload Date</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($xrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrows['user_id'] !== null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post" enctype="multipart/form-data">
                                                <td data-cell="Name: "><?php echo $xrows['name']; ?></td>
                                                <td data-cell="Document: "><?php echo $xrows['Document']; ?></td>
                                                <td data-cell="Upload date: "><?php echo $xrows['Upload_date']?></td>
                                                <td data-cell="Expiry date: "><?php echo $xrows['expiry_date']?></td>
                                                <td data-cell="Status: "><?php  ?><?php echo $xrows['approval_status']?></td>
                                                <td data-cell="Action: "><br>
                                                <?php
                                                        $filePath = "../my/document_upload/urinalysis/user_" . $xrows['user_id'] . "/" . $xrows['Document']." ";
                                                        //echo "Debug: File Path - " . $filePath . "<br>";
                                                        
                                                        if (file_exists($filePath)) {
                                                                // Set appropriate headers for file download
                                                            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                                                            header('Content-Disposition: attachment; filename="' . $fileName . '"');
                                                            header('Content-Length: ' . filesize($filePath));
                                                    ?>
                                                            <a class="download-document-link-button" style="font-family:Arial, FontAwesome;" download href="../my/document/urinalysis/user_<?php echo $xrows['user_id']; ?>/<?php echo $xrows['Document']; ?>">&#xf019;&nbsp;Download&nbsp;&nbsp;</a>
                                                            <br><br><input class="delete-document-link-button" onclick="return confirmDelete();" style="font-family:Arial, FontAwesome;" type="submit" name="delete-user-document-urinalysis" value="&#xf1f8;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                                                            <!-- hidden input - passing data -->
                                                            <input type="hidden" name="doc-name-container-u" value="<?php echo $xrows['Document']?>">
                                                            <input type="hidden" value="<?php echo $xrows['user_id'];?>" name="id-deletion-u"> 

                                                            <script>
                                                                    function confirmDelete() {
                                                                        let userResponseMisc = confirm("Confirm: Do you want to delete the record?");
                                                                        if (userResponseMisc) {
                                                                            return true; // Allow form submission
                                                                        } else {
                                                                            window.location.reload();
                                                                            return false; // Prevent form submission
                                                                        }
                                                                    }
                                                            </script>
                                                    <?php
                                                        } else {
                                                            echo "File not found";
                                                        }
                                                    ?>
                                                </td>
                                                <td  data-cell="Approval: "><br>
                                                    <!-- Approval Column -->
                                                    <input  class="approved-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Approved-u" value="&#xf164;&nbsp;&nbsp;Approved&nbsp;&nbsp;"><br><br>
                                                    <input class="diclined-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Declined-u" value="&#xf165;&nbsp;&nbsp;Declined&nbsp;&nbsp;&nbsp;&nbsp;">
                                                  
                                                </td>
                                            </form>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table> <?php
                                    if ($allUploaded) {
                                    ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo " No " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    }
                        ?>
                </div>
                <!-- /end of urinalysis table -->
                <!-- misc document table -->
                <!-- if misc table not empty it will display -->
                    <?php
                    $sel = "SELECT * FROM `misc_test`";   
                    $tquery = mysqli_query($con, $sel); 

                        if ($tquery) {

                            $stmt = "SELECT *
                                    FROM signup
                                    LEFT JOIN misc_test ON signup.id = misc_test.user_id
                                    WHERE signup.UserType = 1";
                                    $mquery = mysqli_query($con, $stmt);
                                    $allUploaded = true;
                                    $missingDocumentCount = 0;
                            ?>
                            <div id="misc-document-upload" class="Urinalysis no-upload">
                                <h3>Other Document</h3><br>
                                <table style="width: 100%;">
                                <thead>
                                    <tr style="border-bottom: 1px dashed rgb(186, 186, 186)">
                                        <th>Name</th>
                                        <th>Document</th>
                                        <th>Medical name</th>
                                        <th>Upload Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    while ($xrows = mysqli_fetch_assoc($mquery)) {
                                        if ($xrows['user_id'] !== null) {
                                            $allUploaded = false;
                                            $missingDocumentCount++;
                                    ?>
                                            <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                                <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'query_.php'); ?>" method="post" enctype="multipart/form-data">
                                                    <td data-cell="Name: "><?php echo $xrows['name']; ?>
                                                        
                                                    </td>
                                                    <td data-cell="Document: "><?php echo $xrows['Document']; ?>
                                                            <input type="hidden" name="doc-name-container" value="<?php echo $xrows['Document']?>">
                                                    </td>
                                                    <td data-cell="Medical name: "><?php echo $xrows['medical_test_name']; ?></td>
                                                    <td data-cell="Upload date: "><?php echo $xrows['Upload_date']; ?></td>
                                                    <td data-cell="Expiry date: "><?php echo $xrows['expiry_date']; ?></td>
                                                    <td data-cell="Status: "><?php  ?><?php echo $xrows['approval_status']; ?></td>
                                                    <td data-cell="Action: ">
                                                    <?php
                                                            $filePath = "../my/document_upload/other/user_" . $xrows['user_id'] . "/" . $xrows['Document'];
                                                            if (file_exists($filePath)) {
                                                                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                                                                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                                                                header('Content-Length: ' . filesize($filePath));
                                                        ?>
                                                                <a class="download-document-link-button" style="font-family:Arial, FontAwesome;" download href="../my/document/other/user_<?php echo $xrows['user_id']; ?>/<?php echo $xrows['Document']; ?>">&#xf019;&nbsp;Download&nbsp;&nbsp;</a>
                                                                <br><br><input class="delete-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" onclick="return confirmDelete();" name="delete-user-document" value="&#xf1f8;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
                                                                <input type="hidden" value="<?php echo $xrows['user_id'];?>" name="id-deletion-misc">
                                                                <!-- <input type="hidden" id="negative-delete" name="confirmationMisc" value="no"> -->
                                                                <script>
                                                                    function confirmDelete() {
                                                                        let userResponseMisc = confirm("Confirm: Do you want to delete the record?");
                                                                        if (userResponseMisc) {
                                                                            return true; // Allow form submission
                                                                        } else {
                                                                            window.location.reload();
                                                                            return false; // Prevent form submission
                                                                        }
                                                                    }
                                                                </script>

                                                            <?php
                                                            } else {
                                                                echo "File not found";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td  data-cell="Approval: ">
                                                        <!-- Approval Column -->
                                                        <input  class="approved-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Approved-misc" value="&#xf164;&nbsp;&nbsp;Approved&nbsp;&nbsp;"><br><br>
                                                        <input class="diclined-document-link-button" style="font-family:Arial, FontAwesome;" type="submit" name="Approval-Declined-misc" value="&#xf165;&nbsp;&nbsp;Declined&nbsp;&nbsp;&nbsp;&nbsp;">
                                                    
                                                    </td>
                                                </form>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table> <?php
                                        if ($allUploaded) {
                                        ?>
                                <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo " No " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                            <?php
                                        } else {
                                            // Display the "missing documents" count only once
                            ?>
                                <p style="font-size: 13px;color:rgb(47, 158, 255);"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                            <?php
                                        }
                            ?>
                            </div>
                    <?php
                        } else {
                            
                        }
                    ?>
                    <!-- end of misc table -->
                    
                    <!-- Approved -->
                    <div style="display: none;" id="approvedContainer" class="approval-container">
                        <div class="content-notify image-animated-container">
                            <img width="40px" src="../images/verified.gif" alt="file uploading animation">
                        </div>
                        <div class="content-notify text-animated-container">
                            <p>Verified&nbsp;&nbsp;&nbsp;</p>
                        </div>
                    </div>
                    <!-- Disapproved -->
                    <div style="display: none;" id="DisapprovedContainer" class="approval-container">
                        <div class="content-notify image-animated-container">
                            <img width="40px" src="../images/letter-x.gif" alt="file uploading animation">
                        </div>
                        <div class="content-notify text-animated-container">
                            <p>Declined&nbsp;&nbsp;&nbsp;</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/reminder.js"></script>
<?php include("./footer.php"); ?>
<?php } ?>