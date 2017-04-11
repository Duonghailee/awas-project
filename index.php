<?php 
    /* Show all errors */ 
    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 0);

    include('views/head.php');

    /* Include generic config file */
    include('config.php');

    $conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    }

    /* Include correct page after MySQL connection has been established */
    $page = $_GET["p"];
    if ($page == "home" || $page == null) {
         include('views/content.php');
    } elseif ($page == "posts" || preg_match("/posts\&show\=\d/", $page)) {
        include('views/posts.php');
    } elseif ($page == "contact") {
         include('views/contact.php');
    } elseif ($page == "login" || $page == "Login") {
         include('views/login.php');
    } elseif ($page == "register") {
        include('views/register.php');
    } elseif ($page == "logout") {

        /* Destroy session and redirect to index.php */
        session_destroy();
        header("Location: index.php");
        die();

    } else {
        include('views/404.html');
    }

    /* Close Connection */
    mysqli_close($conn);
    include('views/footer.html');
?>
