    <?php
		
		if(isset($_GET["show"])) {
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
		elseif(!isset($_GET["new"])) {
			$sql = "SELECT subject, message, date, users.username, topics.name, postid from posts INNER JOIN users ON posts.author = users.id INNER JOIN topics ON posts.topic = topics.id";
			$result = mysqli_query($conn, $sql);

			if (!$result) {
				die(mysqli_error($conn));
			}
		}
    ?>
    <div id="container">
        <div class="content-main">
            <?php
				if (isset($_GET['new'])){
					create_new();
				} else {
					while ($row = mysqli_fetch_assoc($result)) {
						if (isset($result2)) {
							print_blog_entry($row,$result2);							
						} else {
							print_blog_entry($row);							
							
						}
					}
				}
                           
            ?>
        </div>
        <div class="content-side">
			<?php if (!$_SESSION['loggedIn'] && !$_SESSION['username']) { ?>
						Want to place a post?</br>
						<a href="index.php?p=login">
							<input type="button" value="Login here"/>
						</a>
			<?php } else { ?>
						<a href="index.php?p=posts&new">
							<input type="button" value="Create new Post"/>
						</a>
			<?php } ?>			
			<div id="info"></div>
		</div>
		
    </div>

<?php function create_new() {?>
		<h1>Title: </h1>
		<input type = "text" id="subject" placeholder="Your Title" size = '120'>
		<h1>Topic:</h1>
		<textarea rows ="25" cols = "122" id="message" placeholder="What do you want to tell the world??"></textarea><br><br>
		<div id='author' style="display:none"><?php  echo $_SESSION['userID'];?></div>
		<button id='new_blog'>Blog IT!</button>
<?php }
// expects the results for the blogs. The results will be read out and placed into the html frame for blogentries.
// parameters one and two are the resultdata to be used to print an existing blog.
// if  the last param is set to true, an empty blog frame has to be shown to accept a new Blog as input to be stored into the db.
function print_blog_entry($row,$result2 = null) { ?>
	<h1> <?php echo $row['subject'] ?></h1>
	
	<h3>Posted on <?php echo $row["date"] ?> by <?php echo $row["username"] ?> </h3>
	
	<?php echo base64_decode($row["message"]); ?>
	
	
	<!-- Not looking for comments -->
	<?php if (!isset($_GET["show"])) { ?> 
	
		<a href='index.php?p=posts&show=<?php echo $row["postid"] ?>'/>Comments</a> 
	<?php } else {
		/* Starting statement for comments field */  ?>
		<div class='comments'><h3><b>Comments</b></h3>
		<?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
				<div class='singlecomment'>
				<h3>Posted on <?php echo $row2["date"] ?> by <b> <?php echo $row2["username"] ?> </b></h3><p>
				<?php echo $row2["message"]; ?>
				</p></div>
		<?php } ?>
		<!-- Closing statement for comments field --> 
		</div>
		
		<!-- Posting a new comment -->
		<div class='newcomment'><h3><b>New comment</b></h3>
		<?php 
		if (!$_SESSION['loggedIn'] && !$_SESSION['username']) { ?>
			ERROR: Please login in order to comment!
		<?php } else { 
			$username = $_SESSION["username"]; ?>
			<p>Comment will be posted as:<b> <?php echo $username ?></b></p>
				<form class="login-form" action="comment.php" method="post">
					<textarea rows="4" cols="50" name="message"></textarea><br />
					<input type="hidden" name="username" value="<?php echo $_SESSION["username"];?>" />
					<input type="hidden" name="postid" value="<?php echo $_GET["show"];?>" />
					<button>Comment</button>
				 </form>
			
		<?php } ?>
		</div>
		<?php		
	}
}
?>