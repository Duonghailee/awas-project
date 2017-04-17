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

if ($_SERVER['REQUEST_METHOD'] == ""){
	
}



if ($_SERVER['REQUEST_METHOD'] == "PUT") {
	
	echo "add new post";
} elseif ($_SERVER['REQUEST_METHOD'] == "PATCH") {
	echo "edit post";
} elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	echo "delete post";
} else {
	
	exit;
}


//exit;




?>