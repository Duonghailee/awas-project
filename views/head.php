<?php
    session_start();

    $userLogon = $_SESSION['loggedIn'];
    $username = $_SESSION['username'];

    if ($userLogon == "user_logged_in") {
        $loglink = "logout";
        $loglinklabel = "Logout (Logged in as $username)";
    } else {
        $loglink = "login";
        $loglinklabel = "Login";
    }
?>
<html>
    <head>
        <title>The awesome AWAS blog!</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
        <script type="text/javascript" src="script/login.js"></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
        <script type="text/javascript" src="script/restConnector.js"></script>
		
     </head>
<body>
    <div class="topnav" id="myTopnav">
        <a href="index.php?p=home">Home</a>
        <a href="index.php?p=posts">Posts</a>
        <a href="index.php?p=contact">Contact</a>
        <a href="index.php?p=<?php echo $loglink ?>"><?php echo $loglinklabel ?></a>
    </div>