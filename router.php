<?php


/*
The action taken depends on the request method used. Using the CRUD principle the actions will be mapped like:
PUT   => Create
GET    => Read
PATCH  => Update
DELETE => Delete
Which actions are allowed, will be set within the given object that been requested.
*/
//Ensure that only Method provided by the rest API can be used. Unsupported methods will be redirected to the mainpage.
if ($_SERVER['REQUEST_METHOD'] == 'PUT' || 
	$_SERVER['REQUEST_METHOD'] == 'GET' || 
	$_SERVER['REQUEST_METHOD'] == 'PATCH' || 
	$_SERVER['REQUEST_METHOD'] == 'DELETE'
	) {
		//echo "DEBUG : REST.php > valid method used.\n";
		// if there is no DB connection declared create one now. The REST modules need DB access.
		if (!isset($conn)){
			/* Include generic config file */
			include('config.php');

			$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

			if (!$conn) {
				echo "Error: Unable to connect to MySQL." . PHP_EOL;
				echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
				echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			}
		}
		// punch out the resource name accessed
		$resource_accessed = array_slice(explode("/",$_SERVER['REQUEST_URI']), -2);
		if (isset($resource_accessed[0]) && isset($resource_accessed[1])){
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
			// if one of the fields is missing, then something went wrong!!Redirect to mainpage silently. 
			header("Location: index.php");
		}
		// clos the database connection.
		mysqli_close($conn);
		
		
		
		
} else {
	// redirect all other method calls back to the main site.
	header("Location: index.php");
}

exit;

echo $_SERVER['REQUEST_METHOD'];
//echo $_SERVER['HTTP_REFERER'];
echo urldecode($_SERVER['REQUEST_URI']);






?>