    <?php

        // Include logger function
        include("././logger.php");

        /* Perform login routine */
        $username = $_POST["username"];
        $password = md5($_POST["password"]);

        if ($username && $password) {

            // Log attempted login
            $timestamp = date(DATE_RFC2822);
            logLoginAttempts($timestamp, $username, $password);

            // Perform login routine
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password';";
            $result = mysqli_multi_query($conn, $sql);
           
            if (!$result) {
                die(mysqli_error($conn));
            }

            $resultset = mysqli_store_result($conn);

            if (mysqli_num_rows($resultset) > 0) {
                /* Create login succesfull session token */
                $_SESSION['loggedIn'] = "user_logged_in";
                $_SESSION['username'] = $username;
				$_SESSION['userID'] = $resultset->fetch_row()[0];
                /* Redirect to index.php */
                header("Location: index.php");
                die();
            }
        }
    ?>

    <div class="login-page">
        <div class="form">
            <form class="login-form" action="index.php?p=login" method="post">
            <input type="text" name="username" placeholder="username"/>
            <input type="password" name="password" placeholder="password"/>
            <button>login</button>
            <p class="message">Not registered? <a href="index.php?p=register">Create an account</a></p>
        </form>
    </div>
    </div>