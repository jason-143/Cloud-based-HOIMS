<?php
error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../acc/function.php');
include('./query_.php');
$pageTitle = "Reminder";
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
                    <label id="my-account" for="top-form-title">Reminder</label><br><br>
                </div>
                <div class="remider-form-content">
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
                                    <th>Signup date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($xrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrows['user_id'] === null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                                                <td><?php echo $xrows['name']; ?></td>
                                                <td><?php echo $xrows['Signup_date']; ?></td>
                                                <td>
                                                    <div  class="form-area-content" id="xray-message-content-<?php echo $xrows['user_id']; ?>">
                                                        <textarea class="text-area-message" required maxlength="200" style="max-width: 400px; max-height: 200px;" name="message-send-xray" placeholder="Message here.." cols="50" rows="4"></textarea><br>
                                                        <input class="send-email-message" type="submit" name="submitForm" value="send">
                                                        <input type="hidden" name="userName" value="<?php echo $xrows['name']; ?>">
                                                    </div>
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
                            <p style="font-size: 12px; color:rgb(47, 158, 255);"><?php echo " all " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px; color: red"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " not yet uploaded their documents"; ?></p><br>
                        <?php
                                    }
                        ?>
                    </div>
                </div>
                <!-- 
                    CBC
                 -->
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
                                    <th>Signup date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($xrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrows['user_id'] === null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                                                <td><?php echo $xrows['name']; ?></td>
                                                <td><?php echo $xrows['Signup_date']; ?></td>
                                                <td>
                                                    
                                                    <div  class="form-area-content" id="xray-message-content-<?php echo $xrows['user_id']; ?>">
                                                        <textarea class="text-area-message" required maxlength="200" style="max-width: 400px; max-height: 200px;" name="message-send-cbc" placeholder="Message here.." cols="50" rows="4"></textarea><br>
                                                        <input class="send-email-message" type="submit" name="submitForm-cbc" value="send">
                                                        <input type="hidden" name="userName-cbc" value="<?php echo $xrows['name']; ?>">
                                                    </div>
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
                            <p style="font-size: 12px; color:rgb(47, 158, 255);"><?php echo " all " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px; color: red"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " not yet uploaded their documents"; ?></p><br>
                        <?php
                                    }
                        ?>
                </div>
                <!-- 
                    Urinalysis 
                 -->
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
                                    <th>Signup date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($xrows = mysqli_fetch_assoc($xquery)) {
                                    if ($xrows['user_id'] === null) {
                                        $allUploaded = false;
                                        $missingDocumentCount++;
                                ?>
                                        <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                            <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                                                <td><?php echo $xrows['name']; ?></td>
                                                <td><?php echo $xrows['Signup_date']; ?></td>
                                                <td>
                                                    <div  class="form-area-content" id="xray-message-content-<?php echo $xrows['user_id']; ?>">
                                                        <textarea class="text-area-message" required maxlength="200" style="max-width: 400px; max-height: 200px;" name="message-send-urinalysis" placeholder="Message here.." cols="50" rows="4"></textarea><br>
                                                        <input class="send-email-message" type="submit" name="submitForm-urinalysis" value="send">
                                                        <input type="hidden" name="userName-urinalysis" value="<?php echo $xrows['name']; ?>">
                                                    </div>
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
                            <p style="font-size: 12px; color: color:rgb(47, 158, 255);"><?php echo " all " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " uploaded their documents"; ?></p><br>
                        <?php
                                    } else {
                                        // Display the "missing documents" count only once
                        ?>
                            <p style="font-size: 13px; color: red"><?php echo $missingDocumentCount . " " . ($missingDocumentCount == 1 ? "employee has" : "employees have") . " not yet uploaded their documents"; ?></p><br>
                        <?php
                                    }
                        ?>
                </div>
                <!-- <div class="Urinalysis no-upload">
                            Optional
                    </div> -->
            </div>
        </div>
    </div>
</div>
<script src="../js/reminder.js"></script>
<?php include("./footer.php"); }?>