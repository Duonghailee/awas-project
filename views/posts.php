    <?php
        if(!$_GET["show"]) {
            $sql = "SELECT subject, message, date, users.username, topics.name, postid from posts INNER JOIN users ON posts.author = users.id INNER JOIN topics ON posts.topic = topics.id";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die(mysqli_error($conn));
            }
        } else {
            $postID = $_GET["show"];

            /* Get commented message */
            $sql = "SELECT subject, message, date, users.username, topics.name, postid from posts INNER JOIN users ON posts.author = users.id INNER JOIN topics ON posts.topic = topics.id WHERE postid = $postID";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die(mysqli_error($conn));
            }

            /* Get comments */
            $sql = "SELECT author, message, date, users.username, comments.id, post FROM comments INNER JOIN users ON comments.author = users.id WHERE comments.post = $postID";

            $result2 = mysqli_query($conn, $sql);

            if (!$result2) {
                die(mysqli_error($conn));
            }
        }
        
    ?>
    <div id="container">
        <div class="content-main">
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h1>" . $row["subject"] . "</h1>";
                    echo "<h3>Posted on " . $row["date"] . " by " . $row["username"] . "</h3>";
                    echo base64_decode($row["message"]);
                    /* Not looking for comments */
                    if (!$_GET["show"]) { 
                        echo "<a href='index.php?p=posts&show=" . $row["postid"] . "'/>Comments</a>"; 
                    } else {
                        /* Starting statement for comments field */
                        echo "<div class='comments'><h3><b>Comments</b></h3>";
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo "<div class='singlecomment'>";
                            echo "<h3>Posted on " . $row2["date"] . " by <b>" . $row2["username"] . "</b></h3><p>";
                            echo $row2["message"];
                            echo "</p></div>";
                        }
                        /* Clsoing statement for comments field */
                        echo "</div>";

                        /* Posting a new comment */
                        echo "<div class='newcomment'><h3><b>New comment</b></h3>";
                        if (!$_SESSION['loggedIn'] && !$_SESSION['username']) {
                            echo "ERROR: Please login in order to comment!";
                        } else {
                            $username = $_SESSION["username"];
                            echo "<p>Comment will be posted as:<b> " . $username . "</b></p>";
                            ?>
                                <form class="login-form" action="comment.php" method="post">
                                    <textarea rows="4" cols="50" name="message"></textarea><br />
                                    <input type="hidden" name="username" value="<?php echo $_SESSION["username"];?>" />
                                    <input type="hidden" name="postid" value="<?php echo $_GET["show"];?>" />
                                    <button>Comment</button>
                                 </form>
                            <?php
                        }
                        echo "</div>";
                    }
                }           
            ?>
        </div>
        <div class="content-side">
        </div>
    </div>
