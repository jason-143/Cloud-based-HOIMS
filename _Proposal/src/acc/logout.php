<?php
    session_start();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/'); // Delete cookie
    }
    session_destroy();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Location: http://localhost/en1/_Proposal/index.php");
?>