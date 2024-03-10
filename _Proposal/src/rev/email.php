<?php
error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../acc/function.php');
include('./query_.php');
$pageTitle = "Message";
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
                    <label id="my-account" for="top-form-title">Massage</label><br><br>
                </div>
                <div class="remider-form-content">
                    <div class="xray no-upload">
                        <h3>Send Message</h3><br>
                        <?php
                        $stmt = "SELECT *
                        FROM signup
                        WHERE signup.UserType = 1";
                        $xquery = mysqli_query($con, $stmt);

                        ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                    <!-- <th>Name</th> -->
                                    <th>Send to:</th>
                                    <th>Message here:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                    <form action="<?php echo rtrim($_SERVER['PHP_SELF'], 'function.php'); ?>" method="post">
                                        <!-- <td><?php //echo $xrows['name']; ?></td> -->
                                        <td data-cell="Send to:">
                                            <select required name="email-select-message" id="message-email">
                                                <option value="">Select Email</option>
                                                <?php
                                                    while ($xrows = mysqli_fetch_assoc($xquery)) {
                                                ?>
                                                <option value="<?php echo $xrows['email'] ?>"><?php echo $xrows['email'] ?></option>
                                                <?php
                                                        }
                                                    ?>
                                            </select>
                                        </td>
                                        <td data-cell="Message here:">
                                            <div  class="form-area-content" id="xray-message-content-<?php echo $xrows['user_id']; ?>">
                                                <textarea class="text-area-message" required maxlength="200" style="max-width: 400px; max-height: 200px;" name="message-send-email" placeholder="Message here.." cols="50" rows="8"></textarea><br>
                                                <input style="font-family:Arial, FontAwesome;" class="send-email-message" type="submit" name="submitMessageMail" value="&#xf1d8; send email">
                                                <input type="hidden" name="userName" value="<?php echo $xrows['name']; ?>">
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Message sent feedback -->
    <div style="display: none;" id="approvedContainer" class="approval-container">
        <div class="content-notify image-animated-container">
            <img width="40px" src="../images/sent-mail.gif" alt="file uploading animation">
        </div>
        <div class="content-notify text-animated-container">
            <p>Message sent!&nbsp;&nbsp;&nbsp;</p>
        </div>
    </div>
</div>
<script src="../js/reminder.js"></script>
<?php include("./footer.php"); }?>