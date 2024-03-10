<?php
session_start();
error_reporting(1);
include('../acc/function.php');
include('./query_.php');
$pageTitle = "Home";
$userID = $_SESSION['valid'];
include("../my/header.php");
?>
<!-- <a href="https://www.freepik.com/free-vector/hand-drawn-physical-assessment-illustration_36120842.htm#from_view=detail_serie">Image by pikisuperstar</a> on Freepik -->
<!-- Image by <a href="https://www.freepik.com/free-vector/flat-design-doctor-injecting-vaccine-patient_13109477.htm#query=blood%20test&position=34&from_view=search&track=ais&uuid=a438179b-bc95-4e77-9a5f-09c8a35e016e">Freepik</a> -->
<?php
if (!isset($_SESSION['valid'])) {
    header("Location: ../acc/logout.php");
} else {        
?>
    <div class="main-body-holder">
        <div class="main-body-content">
            <div class="form-content">
                <div class="title">
                    <label id="my-account" for="top-form-title">Dashboard</label><br><br>
                </div>
                <div class="dashboard-upper-body-contanier overview">
                    <h3>Overview</h3><br><br>
                    <table class="dahsboard-table">
                        <thead>
                            <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                <th>Employee</th>
                                <th>Xray</th>
                                <th>Complete Blood Count</th>
                                <th>Urinalysis</th>
                                <th><a style="text-decoration: none; font-family:Arial, FontAwesome;" href="./d.php/#misc-document-upload" id="button-Other-doc">Other Document &#xf105;</a></th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-cell="Employee: "><?php echo $count ?></td>
                                <td data-cell="Xray: ">
                                    <?php 
                                   
                                        if ($rowCount_xray == 0) {
                                             echo 0;
                                        } else {
                                            echo $rowCount_xray;
                                        }
                                    ?>
                                </td>
                                <td data-cell="Cbc: ">
                                    <?php 
                                        if ($rowCount_cbc == 0) {
                                            echo 0;
                                        } else {
                                            echo $rowCount_cbc;
                                        }
                                    ?>
                                </td>
                                <td data-cell="Urinalysis: ">
                                    <?php 
                                        if ($rowCount_u == 0) {
                                             echo 0;
                                        } else {
                                            echo $rowCount_u;
                                        }
                                    ?>
                                </td>
                                <td data-cell="Misc.Docs: ">
                                    <?php 
                                        if ($rowCount_m == 0) {
                                             echo 0;
                                        } else {
                                            echo $rowCount_m;
                                        }
                                    ?>
                                </td>
                                <td data-cell="Total: "> 
                                   <?php
                                        echo $sum;
                                   
                                   ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="dashboard-upper-body-contanier progress-container">
                    <h3>Progress</h3><br><br>
                    <table id="myTable" class="dahsboard-table">
                        <thead>
                            <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                <th>Id</th>
                                <th>Employee name</th>
                                <th>X-ray</th>
                                <th>CBC</th>
                                <th>Urinalysis</th>
                                <th>Misc. Docs</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php    
                        $w = "SELECT `id` FROM `signup` WHERE `UserType` = 1";
                        $query = mysqli_query($con, $w);

                        $we = "SELECT signup.id, signup.name, xray.user_id
                            FROM signup
                            LEFT JOIN xray ON signup.id = xray.user_id
                            WHERE signup.UserType = 1";
             
             
                        $we1 = "SELECT signup.id, signup.name, cbc.user_id
                            FROM signup
                            LEFT JOIN cbc ON signup.id = cbc.user_id
                            WHERE signup.UserType = 1";
                
                        $we2 = "SELECT signup.id, signup.name, urinalysis.user_id
                            FROM signup
                            LEFT JOIN urinalysis ON signup.id = urinalysis.user_id
                            WHERE signup.UserType = 1";
             
                        $we3 = "SELECT signup.id, signup.name,
                            COUNT(DISTINCT misc_test.user_id) AS upload_count
                            FROM signup
                            LEFT JOIN misc_test ON signup.id = misc_test.user_id
                            WHERE signup.UserType = 1
                            GROUP BY signup.id, signup.name";

                        $score = 0;
                        $result_query = mysqli_query($con, $we);
                        $result_query1 = mysqli_query($con, $we1);
                        $result_query2 = mysqli_query($con, $we2);
                        $result_query3 = mysqli_query($con, $we3);
                            if (mysqli_num_rows($query) > 0 && mysqli_num_rows($result_query) > 0 && mysqli_num_rows($result_query1) > 0 && mysqli_num_rows($result_query2) > 0 && mysqli_num_rows($result_query3) > 0) {
                           
                                while (($r = mysqli_fetch_assoc($query)) && ($row = mysqli_fetch_assoc($result_query)) && ($row1 = mysqli_fetch_assoc($result_query1)) && ($row2 = mysqli_fetch_assoc($result_query2)) && ($row3 = mysqli_fetch_assoc($result_query3)) ) {
                                
                               ?>
                                    <tr style="border-bottom: 1px dashed rgb(186, 186, 186);">
                                        <td class="prog-column-width" data-cell="ID:">
                                            <?php echo $row['id'] ?>
                                        </td>
                                        <td class="prog-column-width" data-cell="Name:">
                                            <?php echo $row['name'] ?>
                                        </td>
                                        <td class="prog-column-width" data-cell="X-ray:">
                                            <?php echo ($row['user_id'] !== null) ? '<label class="status-color" id="green">&nbsp;&nbsp;&nbsp;Uploaded&nbsp;&nbsp;&nbsp;</label>' : '<label class="status-color" id="red">Not uploaded</label>';
                                                    $score += ($row['user_id'] !== null) ? 1 : 0; ?>
                                        </td>
                                        <td class="prog-column-width" data-cell="Cbc: ">
                                            <?php echo ($row1['user_id'] !== null) ? '<label class="status-color" id="green">&nbsp;&nbsp;&nbsp;Uploaded&nbsp;&nbsp;&nbsp;</label>' : '<label class="status-color" id="red">Not uploaded</label>';
                                                    $score += ($row1['user_id'] !== null) ? 1 : 0;?>
                                        </td>
                                        <td class="prog-column-width" data-cell="Urinalysis: ">
                                            <?php echo ($row2['user_id'] !== null) ? '<label class="status-color" id="green">&nbsp;&nbsp;&nbsp;Uploaded&nbsp;&nbsp;&nbsp;</label>' : '<label class="status-color" id="red">Not uploaded</label>';
                                                    $score += ($row2['user_id'] !== null) ? 1 : 0; ?>
                                        </td>
                                        <td class="prog-column-width" data-cell="Misc.Docs: ">
                                            <?php 
                                                      if ($row3['upload_count'] > 0) {
                                                            echo'<label class="status-color" id="green">&nbsp;&nbsp;&nbsp;Uploaded&nbsp;&nbsp;&nbsp;</label>';
                                                            $score += 1; 
                                                        } else{
                                                            $score = 0;
                                                            echo '<label class="status-color" id="red">Not uploaded</label>';
                                                        }
                                                //$score += ($row3['user_id'] !== null) ? 1 : 0;?>
                                            
                                        </td>
                                        <td class="prog-column-width" data-cell="Status: ">
                                            <?php 
                                                if ( $score >= 4) {
                                                    //if user has upload for all table
                                                        ?>
                                                                <label class="status-color" id="green">&nbsp;Completed&nbsp;</label>
                                                        <?php
                                                            
                                                } else if ( $score > 0) {
                                                     //if user has 1 - 3 upload 
                                                        ?>
                                                                <label class="status-color" id="orange">On progress</label>
                                                        <?php
                                                }else if ( $score == -1) {
                                                    //if user has no upload
                                                       ?>
                                                                <label class="status-color" id="blue">Pending</label>
                                                       <?php
                                                }else {
                                                    //if user has no upload
                                                        ?>
                                                                <label class="status-color" id="red">Pending</label>
                                                        <?php
                                                }
                                        ?></td>
                                    </tr>
                                    <?php
                                
                               }
                            }
                               ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/dashboard.js"></script>
    <?php include("../my/footer.php"); ?>
<?php } ?>

<!-- 

        3 categories
        -DONE
        -PENDING
        -ON PROGRESS

 -->