<?php
/* check and prompt if users enter correctly data in fields */
/* Perform register routine */
$username = $password = $email = "";
$nameErr = $passErr = $emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $nameErr = "Please enter name";
    } else {
        $username =test_input($_POST["username"]);
    }
    if (empty($_POST["password"])){
        $passErr = "Please enter password";
    } else {
        $password = test_input(md5($_POST["password"]));
    }
    if (empty($_POST["email"])){
        $emailErr = "Please enter email";
    } else {
        $email = test_input($_POST["email"]);
    }
    
}

// adding extra testing for input form to avoid XSS
function test_input($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
    
}

if ($username && $password && $email) {
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die(mysqli_error($conn));
    }
    
    header("Location: index.php?p=login");
    die();
}
?>
  <div class="login-page">
    <div class="form">
      <form class="register-form" action="index.php?p=register" method="post">
        <input type="text" name="username" placeholder="username">
        <?php echo $nameErr; ?>
          <input type="password" name="password" placeholder="password">
          <?php echo $passErr; ?>
            <input type="text" name="email" placeholder="email address">
            <?php echo $emailErr; ?>
              <button>create</button>
              <p class="message">Already registered? <a href="index.php?p=login">Sign In</a></p>
    </div>
  </div>