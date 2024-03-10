<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    // error_reporting(1);
    include("../acc/function.php");
    include('query/query.php');
    session_start();
    $type =  $_SESSION['type'];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/upload.css">
    <link rel="stylesheet" href="../css/reminder.css">
    <link rel="stylesheet" href="../css/filetype.css">
    <link rel="stylesheet" href="../css/employee.css">
    <!-- <script src="../js/account.js"></script> -->
    <!-- <script src="../js/reminder.js"></script> -->
    <!-- <script src="../js/form.js"></script>-->
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Cloud-based Health Office Management Information System with X-ray and email Notification</title>
</head>

<body>
    <!-- desktop nav -->
    <aside class="desktop-view-width">
        <!-- <h1>Welcome</h1> -->
        <nav>
            <div class="top header-content">
                <?php
                if ($type == 0) {
                ?>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/dashboard.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">&#xf085;&nbsp;&nbsp;Dashboard&nbsp;</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/employe.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'employe.php') ? 'active' : ''; ?>">&#xf0c0;&nbsp;&nbsp;Employees&nbsp;<?php //echo $type; ?></a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/reminder.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'reminder.php') ? 'active' : ''; ?>">&#xf0f3;&nbsp;&nbsp;Reminders&nbsp;&nbsp;</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/d.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'd.php') ? 'active' : ''; ?>">&#xf093;&nbsp;&nbsp;Document&nbsp;&nbsp;&nbsp;</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/email.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'email.php') ? 'active' : ''; ?>">&#xf1d8;&nbsp;&nbsp;Message&nbsp;&nbsp;&nbsp;</a><br><br>
                <?php
                } else {
                ?>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../my/home.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'home.php') !== false) ? 'active' : ''; ?>">&#xf015;&nbsp;&nbsp;Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../my/upload.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'upload.php') !== false) ? 'active' : ''; ?>">&#xf0ee;&nbsp;&nbsp;Record&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br><br>
                    <!-- <a style="font-family:Arial, FontAwesome;" id="navi" href="../my/notification.php" class="<?php //echo (strpos($_SERVER['PHP_SELF'], 'notification.php') !== false) ? 'active' : ''; ?>">&#xf0f3;&nbsp;&nbsp;Notification</a><br><br> -->
                    <a style="font-family:Arial, FontAwesome;" id="navi" href="../my/other.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'other.php') !== false) ? 'active' : ''; ?>">&#xf067;&nbsp;&nbsp;Upload&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <?php
                }
                ?>
                 </div>

        <div class="bottom header-content">
            <?php
            if ($type == 0) {
            ?>
                <a style="font-family:Arial, FontAwesome;" id="navi" href="../rev/adm.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'adm.php') !== false) ? 'active' : ''; ?>">&#xf2bd;&nbsp;&nbsp;Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br><br>
                <a style="font-family:Arial, FontAwesome;" id="navi" href="../acc/logout.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'logout.php') !== false) ? 'active' : ''; ?>">&#xf08b;&nbsp;&nbsp;Log out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <?php
            } else { ?>
                <a style="font-family:Arial, FontAwesome;" id="navi" href="../my/account.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'account.php') !== false) ? 'active' : ''; ?>">&#xf2bd;&nbsp;&nbsp;Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br><br>
                <a style="font-family:Arial, FontAwesome;" id="navi" href="../acc/logout.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'logout.php') !== false) ? 'active' : ''; ?>">&#xf08b;&nbsp;&nbsp;Log out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <?php }
            ?>
        </div>
        <!-- Add more links as needed -->
        </nav>
    
    </aside>

    <!-- mobile nav -->
    <aside class="mobile-width-view">
        <button type="button" onclick="shownav()" id="menu-bar">
            <img width="40px" src="../images/menu-bar.png" alt="menu">
        </button>
            <div id="nav-menu-mobile-view" class="drop-down-mobile-nav-view">
                <?php
                if ($type == 0) {
                ?>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/dashboard.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/employe.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'employe.php') ? 'active' : ''; ?>">Employees</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/reminder.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'reminder.php') ? 'active' : ''; ?>">Reminders</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/d.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'd.php') ? 'active' : ''; ?>">Document</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/email.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'email.php') ? 'active' : ''; ?>">&nbsp;&nbsp;Message&nbsp;&nbsp;&nbsp;</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../rev/adm.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'adm.php') !== false) ? 'active' : ''; ?>">Admin</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../acc/logout.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'logout.php') !== false) ? 'active' : ''; ?>">Log out</a>
                <?php
                } else {
                ?>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../my/home.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'home.php') !== false) ? 'active' : ''; ?>">Home</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../my/upload.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'upload.php') !== false) ? 'active' : ''; ?>">Record</a><br><br>
                    <!-- <a style="font-family:Arial, FontAwesome;" class="navi-mobile" href="../my/notification.php" class="<?php //echo (strpos($_SERVER['PHP_SELF'], 'notification.php') !== false) ? 'active' : ''; ?>">Notification</a><br><br> -->
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../my/other.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'other.php') !== false) ? 'active' : ''; ?>">Upload</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../my/account.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'account.php') !== false) ? 'active' : ''; ?>">Account</a><br><br>
                    <a style="font-family:Arial, FontAwesome;" id="navi-mobile" href="../acc/logout.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'logout.php') !== false) ? 'active' : ''; ?>">Log out</a>
                <?php
                }
                ?>
            </div>
            <script>
                function shownav() {
                    let nav = document.getElementById('nav-menu-mobile-view');
                    nav.classList.toggle('show');
                    nav.classList.toggle('hide');
                }
            </script>
    </aside>
    <script src="../js/home.js"></script>