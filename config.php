<?php

// set error reporting on to help with debugging
error_reporting(E_ALL);
ini_set('display_errors','1');

/* note: connection for cloud9 ... you will need to modify for your own environment */
$ip = getenv('IP');
$port = '3306';

define('DBHOST', '');
define('DBNAME', 'travel');
define('DBUSER', 'testuser');
define('DBPASS', 'mypassword');
define('DBCONNSTRING','mysql:dbname=travel;charset=utf8mb4;');

// auto load all classes so we don't have to explicitly include them
spl_autoload_register(function ($class) {
    $file = 'lib/' . $class . '.class.php';
    if (file_exists($file))
    include $file;
});

// connect to the database
$connection = DatabaseHelper::createConnectionInfo(array(DBCONNSTRING,DBUSER, DBPASS));

$apiKey = "AIzaSyB6aTOlNh4tpyIleHq85TjILeA06fR_ZEw";
?>