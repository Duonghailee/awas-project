<?php
    /* Include generic config file */
    include('config.php');

    $database = new PDO("mysql:host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);
    $sql = file_get_contents('cleandb.sql');
    $query = $database->exec($sql);

    /* Redirect to index.php */
    header("Location: index.php?dbrestore=done");
    die();
?>