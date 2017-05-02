<?php
// Perform logging for attempted logins
function logLoginAttempts($timestamp, $user, $password) {

    $date = date("Ymd");

    // Define file name, one file per day
    $file = "./logs/" . $date . ".log";

    // Generate log message
    $msg = $timestamp . " - User " . $user . " attempted to login with password " . $password . " from IP: " . $_SERVER['REMOTE_ADDR'] . " with PHPSESSID: " . session_id() . "\n";

    // Write to logfile
    $logFile = fopen($file, "a");
    fwrite($logFile, $msg);
    fclose($logFile);
}
?>