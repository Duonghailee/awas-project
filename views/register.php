        <?php

        /* Perform register routine */
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $email = $_POST["email"];

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
        <input type="text" name="username" placeholder="username"/>
        <input type="password" name="password" placeholder="password"/>
        <input type="text" name="email" placeholder="email address"/>
        <button>create</button>
        <p class="message">Already registered? <a href="index.php?p=login">Sign In</a></p>
    </div>
    </div>