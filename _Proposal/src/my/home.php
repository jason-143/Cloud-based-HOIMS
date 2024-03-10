<?php
session_start();
error_reporting(1);
include('../acc/function.php');
include('./query/query.php');
$pageTitle = "Home";
$userID = $_SESSION['valid'];
include("./header.php");
if (!isset($_SESSION['valid'])) {
    header("Location: ../acc/logout.php");
} else {
?>
<!-- <a href="https://www.freepik.com/free-vector/hand-drawn-physical-assessment-illustration_36120842.htm#from_view=detail_serie">Image by pikisuperstar</a> on Freepik -->
    <!-- Image by <a href="https://www.freepik.com/free-vector/flat-design-doctor-injecting-vaccine-patient_13109477.htm#query=blood%20test&position=34&from_view=search&track=ais&uuid=a438179b-bc95-4e77-9a5f-09c8a35e016e">Freepik</a> -->
    <div class="flex-body">
        <div class="body-content">
            <!-- Top Section Message greeting and manual upload of files -->
            <section class="top-section">
                <div class="main-content greet-message">
                    <label id="welcome" for="greet-massage">Welcome <?php echo $fname ?></label>
                    <p>Please upload your latest medical test records.</p>
                    <p>Thank you for your cooperation!</p>
                    <p><span id="date"></span></p>
                    <p><span id="time"></span></p>
                    <script>
                        var date = new Date();
                        var curr_date = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear();
                        document.getElementById("date").innerHTML = curr_date;
                        
                        function updateClock() {
                            var time = new Date();
                            var hours = time.getHours();
                            var minutes = time.getMinutes();
                            var seconds = time.getSeconds();

                            var formattedTime = hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                            document.getElementById('time').innerHTML = formattedTime;
                        }

                        // Update the clock every second
                        setInterval(updateClock, 1000);

                        // Initial call to set the clock immediately
                        updateClock();
                    </script>
                </div>
                <!-- Upload Medical Test Manually -->
                <!-- <div class="main-content add-content">
                    <a style="font-family:Arial, FontAwesome;" id="upload-misc-test-document" href="./other.php">&#xf067;&nbsp;&nbsp;Upload</a>
                </div> -->
            </section>
            <section class="bottom-section">
                <!--
                    Xray
                -->
                <div onclick="redirectTo('./xray.php')" class="main-content Xray content-container">
                    <div class="image-container-xray">
                    
                    </div>
                    <div class="status-container">
                    <br><label for="status">X-ray Test Result</label><br><br>
                    <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `xray` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                <p><strong style="color: rgb(103, 255, 103);">Uploaded</strong></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                                <p class="No-upload-status-sign" style="font-family:Arial, FontAwesome;">&#xf093; Upload Here</p>
                                <p style="color: rgb(255, 112, 112);margin-top:3px;font-size:14px">Not Uploaded</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- 
                    CBC
                 -->
                <div onclick="redirectTo('./formCBC.php')" class="main-content cbc content-container">
                    <div class="image-container-blood">
                       
                    </div>
                    <div class="status-container">
                    <br><label for="status">Cbc Test Result</label><br><br>
                    <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `cbc` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                <p><strong style="color: rgb(103, 255, 103);">Uploaded</strong></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                            <p class="No-upload-status-sign" style="font-family:Arial, FontAwesome;">&#xf093; Upload Here</p>
                            <p style="color: rgb(255, 112, 112);margin-top:3px;font-size:14px">Not Uploaded</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div onclick="redirectTo('./urinalysis.php')" class="main-content Urinalysis content-container">
                    <div class="image-container-urine">
                       
                    </div>
                    <div class="status-container">
                    <br><label for="">Urinalysis Test Result</label><br><br>
                    <?php
                        $id =  $_SESSION['valid'];
                        $we = "SELECT * FROM `urinalysis` WHERE `user_id` = '$id'";
                        $result_query = mysqli_query($con, $we);
                        if (mysqli_num_rows($result_query) > 0) {
                            while ($rows = mysqli_fetch_assoc($result_query)) {
                        ?>
                                <div class="upload-container upload-name">
                                   <p><strong style="color:rgb(103, 255, 103)">Uploaded</strong></p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="upload-container upload-name">
                            <p class="No-upload-status-sign" style="font-family:Arial, FontAwesome;">&#xf093; Upload Here</p>
                            <p style="color: rgb(255, 112, 112);margin-top:3px;font-size:14px">Not Uploaded</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
                //   function getRandomColor() {
                //     // Generate a random RGB color
                //     $red = mt_rand(150, 255);
                //     $green = mt_rand(150, 255);
                //     $blue = mt_rand(150, 255);
                
                //     // Convert RGB to HEX
                //     $hexColor = sprintf("#%02x%02x%02x", $red, $green, $blue);
                
                //     return $hexColor;
                // }
                    $id =  $_SESSION['valid'];
                    $we = "SELECT * FROM `misc_test` WHERE `user_id` = '$id'";
                    $result_query = mysqli_query($con, $we);
                    if (mysqli_num_rows($result_query) > 0) {
                        while ($rows = mysqli_fetch_assoc($result_query)) {
                    ?>
                <div onclick="redirectTo('./other.php')" class="main-content misc-docs content-container">
                    <div class="image-container-misc" style="background-color:<?php echo $rows['colordiv']?>;height: 150px;">

                    </div>
                    <div class="status-container">
                    <br><label for=""><?php echo $rows['medical_test_name'] ?> Test Result</label><br><br>
                    <div class="upload-container upload-name">
                                   <p><strong style="color: rgb(103, 255, 103);">Uploaded</strong></p>
                                </div>
                    </div>
                </div>
                <?php
                    }
                } else {}
                    ?>
            </section>
        </div>
    </div>
    <script src="../js/home.js"></script>
    <?php include("./footer.php"); ?>
<?php } ?>