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
		echo "add new post";
		
		
	// is a existing post to be edited/deleted? The method has to be either PATCH or DELETE.
	} elseif ($_SERVER['REQUEST_METHOD'] == "PATCH"
			  || $_SERVER['REQUEST_METHOD'] == "DELETE") {
		// only allow Numerics to be entered as ID for a post.		  
		if (!is_numeric($resource_accessed[1])) {
			echo "is not numeric!";
		}
		// query the DB for the post.
		$sql = "SELECT postid from posts where postid = " . $resource_accessed[1];
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			die(mysqli_error($conn));
		} elseif ($result->num_rows == 1) {
			echo "Post exists";			
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