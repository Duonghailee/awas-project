<?php

    /* Get comment parameters */
    $message = $_POST["message"];
    $username = $_POST["username"];
    $postid = $_POST["postid"];

    include('config.php');
    $conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    }

    $sql = "SELECT id from users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die(mysqli_error($conn));
    }
    while ($row = mysqli_fetch_assoc($result)) {

        $userid = $row['id'];
        $sql = "INSERT INTO comments (author, date, message, post) VALUES ('$userid', now(), '$message', '$postid')";
        
        $result2 = mysqli_query($conn, $sql);

        if(!$result2) {
            die(mysqli_error($conn));
        } else {
             header("Location: index.php?p=posts&show=$postid");
        }
    }
?>