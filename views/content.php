    <div id="container">
        <div class="content-main">
            <h1>Applied Web Application Security (AWAS) project</h1>
            <p>This is a web application created in a 3 member project group for the Spring 2017 implementation of the DECAMP AWAS course. The target for the project was to create a web application which has at least 3 vulnerabilities in it. This web application is a poorly written blog with multiple vulnerabilities in it, some of the vulnerabilities are easy to find and some will require creative thinking to properly exploit.</p>
            <p><b>Project Members:</b> <br />
            - Thorsten Magas <br />
            - Hai Ly Duong <br />
            - Joonas Forsberg </p>
            <p>To start with the hacking, you will need to edit the <b>config.php</b> file contained in the root directory of the project to match your environment. If you are using XAMPP version 5.60.30 the default settings should be good enough. You will need to fill up database ip address, username and password in order to establish database connectivity. You can refresh or create the database used within this project by pressing the "RESTORE DATABASE" button located on the right-hand side.</p>
            <p>For the vulnerabilities, we are using the classification by OWASP (check <a href="https://www.owasp.org/index.php/Top_10_2013-Top_10">OWASP top 10 2013</a> list).</p>
            <p>The web application contains (at least) the following vulnerabilities: </br>
            - A1-Injection </br>
            - A3-Cross Site Scripting (XSS) </br>
            - A6-Sensitive Data Exposure </br>
            - A7-Missing Function Level Access Control </br></p>
            <div class="content-vulnerability">
                <h3><b>A1-Injection</b></h3>
                <p>The developers of the application aren't familiar with the concept of SQL injection and as a result most of the database queries are vulnerable to SQL injection. With SQL injection, it is possible to gain access to sensitive information or cause damage to the content of the database.<p>
                <p>Target is to: <br />
                - Gain access to admin console by inserting admin account to database.</br >
                - Truncate the users table<p>
                <p><button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hint1') .style.display=='none') {document.getElementById('hint1') .style.display=''}else{document.getElementById('hint1') .style.display='none'}">First hint</button>
                <div id="hint1" style="display:none"><p>SQL queries are used in login, registeration, commenting and contact forms. All of these are vulnerable to basic form of SQL Injection (' OR 1=1#). Admin accounts have the value of type field set to 2.</p></div>
                </p>
                <p><button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hint2') .style.display=='none') {document.getElementById('hint2') .style.display=''}else{document.getElementById('hint2') .style.display='none'}">Second hint</button>
                <div id="hint2" style="display:none"><p>SQL Query used in login form is "SELECT * FROM users WHERE username = '$username' AND password = '$password';" where $username and $password parameters are taken directly from POST request. It's also using mysqli_multi_query function to perform the SQL query. Tables and columns are named without using too much imagination, so guessing them should be quite easy.</p></div>
                </p>
                <p><button title="Click to show/hide content" type="button" onclick="if(document.getElementById('solution') .style.display=='none') {document.getElementById('solution') .style.display=''}else{document.getElementById('solution') .style.display='none'}">Display solution</button>
                <div id="solution" style="display:none"><p>Admin account can be created to database if this is used as a password during login process:</br>
                something'; INSERT INTO users (username, password, type) VALUES ('hacker', 'goodpassword', 2)#</br>
                <br />
                Similarly users table can be dropped by using this as a password during the login process:<br />
                something'; TRUNCATE TABLE users#</p></div>
                </p>
            </div>
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
