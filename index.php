<?php       
    include('/views/head.html');

    /* Show all errors */ 
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    /* Include generic config file */
    include('config.php');

    $conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    } else {
        echo("Success: A proper connection to MySQL was made! The " . $DB_NAME . " database is great." . PHP_EOL);
        echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;
    }

    /* Include content page after MySQL connection has been established */
    include('/views/content.php');

    /* Close Connection */
    mysqli_close($conn);
    include('/views/footer.html');
?>
