# AWAS project

#### Installation instructions
To run the project, you'll need to have Apache, MySQL and PHP installed on your system. You can either use XAMPP 5.6.30 or install all the components manually.

1. Clone the repository and modify DocumentRoot in httpd.conf to match the directory the files are at OR copy the contents to the default htdocs directory
2. Modify config.php to match your installation SQL configuration
3. Start Apache, MySQL and PHP
4. Point your browser to http://127.0.0.1 and click on "RESTORE DATABASE"

To disable or enabled errors from showing, modify index.php and set error display to either 1 (enabled) or 0 (disabled):
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
