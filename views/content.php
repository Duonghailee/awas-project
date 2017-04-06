    <div id="container">
        <div class="content-main">
            <h1>Lorem Ipsum</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non rutrum justo. Curabitur dignissim, nisl vitae dictum volutpat, dolor dui accumsan sem, bibendum tincidunt leo arcu non dolor. Vivamus ut iaculis nulla. Nullam et fermentum ligula. Duis at sapien cursus, pulvinar lacus a, bibendum lacus. Cras fermentum condimentum quam, ac vulputate lorem rhoncus quis. Maecenas molestie hendrerit ex eget dignissim.</p>
            <p>Curabitur ac quam scelerisque, bibendum felis a, ullamcorper arcu. Aenean sem nulla, aliquet id feugiat eget, vulputate in elit. Donec ultrices magna justo, blandit convallis ex euismod et. Proin iaculis nibh a elit vehicula consequat. Nam volutpat nec massa quis lobortis. Duis eu pulvinar ante. Vestibulum sed massa mi. Donec condimentum arcu interdum pretium molestie. Vestibulum sit amet odio egestas, porttitor dui et, congue neque. Etiam hendrerit lacinia massa id placerat.</p>
        </div>
        <div class="content-side">
            <h1>Database restore</h1>
            <p>If you want to restore the initial database, you can use the button below to do so. This will also create the database if it doesn't exists.</p>
            <p>Make sure you have MariaDB or MySQL installed and you have configured credentials and database hostname to config.php.</p>            
            <div class="db-refresh">
                <?php 
                $status = $_GET["dbrestore"];
                if ($status == "done") {
                    $text = "Database restored!";
                }
                ?>
                <form action="refreshdb.php">
                    <button>Restore database</button>
                </form>
                <p><div class="notiftext">
                <?php echo $text; ?></p></div>
            </div>
        </div>
    </div>
