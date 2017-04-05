<?php
    session_start();

    $userLogon = $_SESSION['loggedIn'];
    echo $userLogon;

    if ($userLogon == "user_logged_in") {
        $loglink = "Logout";
    } else {
        $loglink = "Login";
    }
?>
<html>
    <head>
        <title>The awesome AWAS blog!</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
        <script type="text/javascript" src="script/login.js"></script>
     </head>
<body>
    <div class="topnav" id="myTopnav">
        <a href="index.php?p=home">Home</a>
        <a href="index.php?p=posts">Posts</a>
        <a href="index.php?p=contact">Contact</a>
        <a href="index.php?p=<?php echo $loglink ?>"><?php echo $loglink ?></a>
    </div>