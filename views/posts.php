    <?php
        $sql = "SELECT subject, message, date, users.username, topics.name, postid from posts INNER JOIN users ON posts.author = users.id INNER JOIN topics ON posts.topic = topics.id";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die(mysqli_error($conn));
        }
        
    ?>
    <div id="container">
        <div class="content-main">
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h1>" . $row["subject"] . "</h1>";
                    echo "<h3>Posted on " . $row["date"] . " by " . $row["username"] . "</h3>";
                    echo base64_decode($row["message"]);
                    echo "<a href='index.php?p=posts?pid=" . $row["postid"] . "'/>Comments</a>";
                }
            ?>
        </div>
        <div class="content-side">
        </div>
    </div>
