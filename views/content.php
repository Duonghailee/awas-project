<div id="container">
  <div class="content-main">
    <h1>Applied Web Application Security (AWAS) project</h1>
    <p>This is a web application created in a 3 member project group for the Spring 2017 implementation of the DECAMP AWAS course. The target for the project was to create a web application which has at least 3 vulnerabilities in it. This web application
      is a poorly written blog with multiple vulnerabilities in it, some of the vulnerabilities are easy to find and some will require creative thinking to properly exploit.</p>
    <p><b>Project Members:</b>
      <br /> - Thorsten Magas
      <br /> - Hai Ly Duong
      <br /> - Joonas Forsberg </p>
    <p>To start with the hacking, you will need to edit the <b>config.php</b> file contained in the root directory of the project to match your environment. If you are using XAMPP version 5.60.30 the default settings should be good enough. You will need
      to fill up database ip address, username and password in order to establish database connectivity. You can refresh or create the database used within this project by pressing the "RESTORE DATABASE" button located on the right-hand side.</p>
    <p>For the vulnerabilities, we are using the classification by OWASP (check <a href="https://www.owasp.org/index.php/Top_10_2013-Top_10">OWASP top 10 2013</a> list).</p>
    <p>The web application contains (at least) the following vulnerabilities: </br>
      - A1-Injection </br>
      - A3-Cross Site Scripting (XSS) </br>
      - A6-Sensitive Data Exposure </br>
      - A7-Missing Function Level Access Control </br>
      - A10-Unvalidated Redirects and Forwards </br>
    </p>
    <div class="content-vulnerability">
      <h3><b>A1-Injection</b></h3>
      <p>The developers of the application aren't familiar with the concept of SQL injection and as a result most of the database queries are vulnerable to SQL injection. With SQL injection, it is possible to gain access to sensitive information or cause
        damage to the content of the database.
        <p>
          <p>Target is to:
            <br /> - Gain access to admin console by inserting admin account to database.</br>
            - Truncate the users table
            <p>
              <p>
                <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hint1') .style.display=='none') {document.getElementById('hint1') .style.display=''}else{document.getElementById('hint1') .style.display='none'}">First hint</button>
                <div id="hint1" style="display:none">
                  <p>SQL queries are used in login, registeration, commenting and contact forms. All of these are vulnerable to basic form of SQL Injection (' OR 1=1#). Admin accounts have the value of type field set to 2.</p>
                </div>
              </p>
              <p>
                <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hint2') .style.display=='none') {document.getElementById('hint2') .style.display=''}else{document.getElementById('hint2') .style.display='none'}">Second hint</button>
                <div id="hint2" style="display:none">
                  <p>SQL Query used in login form is "SELECT * FROM users WHERE username = '$username' AND password = '$password';" where $username and $password parameters are taken directly from POST request. It's also using mysqli_multi_query function
                    to perform the SQL query. Tables and columns are named without using too much imagination, so guessing them should be quite easy.</p>
                </div>
              </p>
              <p>
                <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('solution') .style.display=='none') {document.getElementById('solution') .style.display=''}else{document.getElementById('solution') .style.display='none'}">Display solution</button>
                <div id="solution" style="display:none">
                  <p>Admin account can be created to database if this is used as a password during login process:</br>
                    something'; INSERT INTO users (username, password, type) VALUES ('hacker', 'goodpassword', 2)#</br>
                    <br /> Similarly users table can be dropped by using this as a password during the login process:
                    <br /> something'; TRUNCATE TABLE users#</p>
                </div>
              </p>
    </div>
    <div class="content-vulnerability">
      <h3><b>A7-Missing Function Level Access Control</b></h3>
      <p>A new developer joined the team. As new member he wasn`t familiar with the architecture used to provide the blog to the users. With a lot of new idead and an enthusiastic manner he jumped in and started coding. He provided a new way to manage the
        blogs. The other developers have never worked with this technology and aren`t able to understand what is goin on and how it works, but it does (somehow). What they all don`t know is that the new code left the blog with a flaw in access control.
        <p>
          <p>Target is to:
            <br /> - Determine how blog entries are added to the database</br>
            - Try to post a blog without being logged in.</br>
            - Can you post a blog entry with another username
            <p>
              <p>
                <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintB1') .style.display=='none') {document.getElementById('hintB1') .style.display=''}else{document.getElementById('hintB1') .style.display='none'}">First hint</button>
                <div id="hintB1" style="display:none">
                  <p>How are the inputs of the formular send to the server? Via URL, POST?</p>
                </div>
              </p>
              <p>
                <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintB2') .style.display=='none') {document.getElementById('hintB2') .style.display=''}else{document.getElementById('hintB2') .style.display='none'}">Second hint</button>
                <div id="hintB2" style="display:none">
                  <p>How many inputs are visible to you? How many inputs does a blog consist of? Where do they come from? Inspect the form for new Blog entries in more detail.</p>
                </div>
              </p>
            </p>
            <p>
              <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintB3') .style.display=='none') {document.getElementById('hintB3') .style.display=''}else{document.getElementById('hintB3') .style.display='none'}">Third hint</button>
              <div id="hintB3" style="display:none">
                <p>As you might have noticed, the URL is not generating a 4XX. This tells you that there is some kind of URL mapping taking place. This is a hint that the webapp might use a REST API. Try to figure out how resources can be accessed by a REST
                  API.</p>
              </div>
            </p>

            <p>
              <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('solutionB') .style.display=='none') {document.getElementById('solutionB') .style.display=''}else{document.getElementById('solutionB') .style.display='none'}">Display solution</button>
              <div id="solutionB" style="display:none">
                <p>
                  The webapp is using a REST API to enter new Blog entries. The input mask is only visible when logged in. But the REST API can be accessed directly by using POST with the matching Method allowing to place a new Blog entry. The Method to be used is PUT.
                  The fields to be filled are subject and message. Which can be obtained by looking into the source code of the create form. Now a PUT request has to be forged by using a tool like Burp Suite Repeater or Postman. The Request won´t be checked
                  for a valid Session and will accept the input placed by the request.
                </p>
              </div>
            </p>
    </div>
    <div class="content-vulnerability">
      <h3><b>A3-Cross Site Scripting (XSS)</b></h3>
      <p>The new developer who joined the team also is aware of XSS. As he implemented the new stuff to the blog he also emplaced some countermeasures for XSS. He added some features to the workflow that is used to enter a new Blog entry.
        <p>Target is to:
          <br /> - Determine what feature is used / How is it done?</br>
          - Find a way to evade this feature</br>
          - Try to place a malicous code sample into a new Blog, i.e. a link
          <p>
            <p>
              <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintC1') .style.display=='none') {document.getElementById('hintC1') .style.display=''}else{document.getElementById('hintC1') .style.display='none'}">First hint</button>
              <div id="hintC1" style="display:none">
                <p>Which characters or parts of the input are missing when you enter "some" characters?</p>
              </div>
            </p>
            <p>
              <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintC2') .style.display=='none') {document.getElementById('hintC2') .style.display=''}else{document.getElementById('hintC2') .style.display='none'}">Second hint</button>
              <div id="hintC2" style="display:none">
                <p>Remember Lab 10. Its about the same idea to place the code into a Webapp that allows users to place content into fields that will be stored into a database. Now you need to figure out how to overcome the obstacle placed by the developer.
                  What kind of satinization/filtering is used? Burp Suite Decoder might help.</p>
              </div>
            </p>
          </p>
          <p>
            <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hintC3') .style.display=='none') {document.getElementById('hintC3') .style.display=''}else{document.getElementById('hintC3') .style.display='none'}">Third hint</button>
            <div id="hintC3" style="display:none">
              <p>The developer uses character based filtering and replaces the opening and closing tags with empty strings. Therefore you are not able to enter "&lt;" and "&gt;" tags. Try to use the Burp Suite to prepare the code you want to hide from the
                filtering.</p>
            </div>
          </p>

          <p>
            <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('solutionC') .style.display=='none') {document.getElementById('solutionC') .style.display=''}else{document.getElementById('solutionC') .style.display='none'}">Display solution</button>
            <div id="solutionC" style="display:none">
              <p>
                <p>To get past the filtering, you have to use the Decoder module or other tool to encode in a manner that it won`t match with the replace pattern used. </br>
                  In this case two steps are used. First is to replace the opening and closing tags of the link '
                  < ' and '>' with ther HTML code &amp;lt; and &amp;gt;</p>
                <p>In example: <span style="color:red">&amp;lt;</span>a href='http://heise.de'<span style="color:red">&amp;gt;</span>Heise<span style="color:red">&amp;lt;</span>/a<span style="color:red">&amp;gt;</span></p>
                <p>This line will be then URL Encoded to ensure it wont get in trouble with all the special chars in it.</br>
                  It will look something like this afterwards:
                  <p>%26%6c%74%3b%61%20%68%72%65%66%3d%27%68%74%74%70%3a%2f%2f%68%65%69%73%65%2e%64%65%27%26%67%74%3b%48%65%69%73%65%26%6c%74%3b%2f%61%26%67%74%3b</p>
                  <p>By posting this line into a blog a link to heise will be visible to the users. The Link could now do more than just link to heise.</p>
                </p>
            </div>
            </p>

    </div>
    <div class="content-vulnerability">
      <h3><b>A10- Unvalidated Redirects and Forwards </b></h3>
      <p>The developer want to build a vulnerabilities based on simple idea of chapter 11, using path travelsar </p>
      <p>Target is to:
        <br /> - Gain access to database where all created account are created, including also admin account.</br>
        - actual directory of storing index.php</p>
      <p>
        <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('hint_A10') .style.display=='none') {document.getElementById('hint_A10') .style.display=''}else{document.getElementById('hint_A10') .style.display='none'}">Hint</button>
        <div id="hint_A10" style="display:none">
          <p>Inspecting source file, which one you notice might be vulnerable thing to research.</p>
        </div>
      </p>
      <p>
        <button title="Click to show/hide content" type="button" onclick="if(document.getElementById('solution_A10') .style.display=='none') {document.getElementById('solution_A10') .style.display=''}else{document.getElementById('solution_A10') .style.display='none'}">Display solution</button>
        <div id="solution_A10" style="display:none">
          <p>Try using ?file=../ or any encode characters together to discover secret directory</p>
        </div>
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
$text = "";
if ($status == "done") {
    $text = "Database restored!";
}
?>
        <form action="refreshdb.php">
          <button>Restore database</button>
        </form>
        <p>
          <div class="notiftext">
            <?php echo $text; ?>
        </p>
        </div>
    </div>
  </div>
</div>