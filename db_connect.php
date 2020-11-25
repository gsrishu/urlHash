<?php

//set resource prefix URL
if ($_SERVER["HTTP_HOST"] == "localhost") {
    define("HOST", "localhost"); // The host you want to connect to.
    define("USER", "root"); // The database username.
    define("PASSWORD", ""); // The database password. 
    define("DATABASE", "url"); // The database name.
} 
/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_errno > 0) {
    die('Unable to connect to database [' . $mysqli->connect_error . ']');
}

/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    die("Error loading character set utf8: " . $mysqli->error);
}