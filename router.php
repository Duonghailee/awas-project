<?php


/*
The action taken depends on the request method used. Using the CRUD principle the actions will be mapped like:
PUT   => Create
GET    => Read
PATCH  => Update
DELETE => Delete
Which actions are allowed, will be set within the given object that been requested.
*/

// punsh out the resource name access
$resource_accessed = array_slice(explode("/",$_SERVER['REQUEST_URI']), -1)[0];

echo $resource_accessed . "\n";

//Ensure that only Method provided by the rest API can be used. Unsupported methods will be redirected to the mainpage.
if ($_SERVER['REQUEST_METHOD'] == 'PUT' || 
	$_SERVER['REQUEST_METHOD'] == 'GET' || 
	$_SERVER['REQUEST_METHOD'] == 'PATCH' || 
	$_SERVER['REQUEST_METHOD'] == 'DELETE'
	) {
		echo "DEBUG : REST.php > valid method used.\n";
		// path to the rest modules to handle the REST calls
		$path = "rest";
		// load all modules found in the rest module folder
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if ('.' === $file) continue;
				if ('..' === $file) continue;
				// include the module
				include($path . DIRECTORY_SEPARATOR . $file);
			}
			closedir($handle);
		}
		
		
		
		
} else {
	// redirect all other method calls back to the main site.
	header("Location: index.php");
}

//exit;

echo $_SERVER['REQUEST_METHOD'];
//echo $_SERVER['HTTP_REFERER'];
echo urldecode($_SERVER['REQUEST_URI']);






?>