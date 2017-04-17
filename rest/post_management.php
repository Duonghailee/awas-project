<?php 
/*
This file provides functionality to

- add
- edit
- delete 

Posts. The functions have different access levels. A user has to have the proper rights to use the function.

- add (everyone)
- edit (owner/admin)
- delete (admin)

Note! At this point the vulnerabilitzy A7 will take place. The authentication will be flawed.

*/

// Run the module only if the "posts" resource has been called. In either resource fields it should state "posts".
if ($resource_accessed[1] == "posts" 
	|| $resource_accessed[0] == "posts") {
	// at this point we know that we have to interact with posts. 
	
	// is a new Post to be placed? The method has to be PUT 
	if ($_SERVER['REQUEST_METHOD'] == "PUT") {

		// read in the input placed by the user.
		// At this point the input should be satanized. User input can not be trusted.
		// Note: In this case we leave this out. The vulnerability is a flawed authentication at this state.
		//       Formular fields should not show internal structure to the outside world.
		parse_str(file_get_contents("php://input"),$post_vars);
		// only if all fields provided the blog can be added.
		if (isset($post_vars['author']) && is_numeric($post_vars['author'])
			&& isset($post_vars['subject']) && strlen($post_vars['subject']) > 1
			&& isset($post_vars['message']) && strlen($post_vars['message']) > 1
			&& isset($post_vars['topic']) && is_numeric($post_vars['author'])){
				
			// at this point the input would  be filtered/sanatized.	
			$author =  $post_vars['author'];
			$subject = $post_vars['subject'];
			$message = base64_encode("<p>" . $post_vars['message'] . "</p>" . PHP_EOL);
			$topic = $post_vars['topic'];
			// create the timestamp
			$timestamp = date ("Y-m-d H:i:s", time());
			
			// create the insert query
			$sql = "insert into posts (`author`, `subject`, `message`, `date`, `topic`) VALUES ('$author','$subject', '$message', '" . $timestamp . "',$topic)";
			
			if ($conn->query($sql) === TRUE){
				http_response_code(200);
				echo 'Your Blog entry has been added.';
				exit;
			} else  {
				echo mysqli_error($conn) . "\n" . $sql;
			}
		}
		echo 'Your blog could not be added!';
		exit;
		
	// is a existing post to be edited/deleted? The method has to be either PATCH or DELETE.
	} elseif ($_SERVER['REQUEST_METHOD'] == "PATCH"
			  || $_SERVER['REQUEST_METHOD'] == "DELETE") {
		// only allow Numerics to be entered as ID for a post.		  
		if (!is_numeric($resource_accessed[1])) {
			echo "is not numeric!" . $resource_accessed[1];
		}
		// query the DB for the post.
		$sql = "SELECT * from posts where postid = " . $resource_accessed[1];
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			die(mysqli_error($conn));
		} elseif ($result->num_rows == 1) {
			if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
				$sql = "delete from posts where postid = " . $resource_accessed[1];
				if ($conn->query($sql) === TRUE){
					http_response_code(200);
					echo 'The selected Blog has been deleted.';
					exit;
				} else  {
					echo mysqli_error($conn) . "\n" . $sql;
				}
			} elseif ($_SERVER['REQUEST_METHOD'] == "PATCH") {
				
			}
		} else {
			echo "DEBUG : Could not fetch the post selected. Might not exist yet. Found rows with specified ID ". $result->num_rows ;
		}
	}
	// no need to run any further checks on other modules. The resource has been found.
	exit;
} else {
	echo "not for this module";
}
?>