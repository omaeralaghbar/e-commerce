<?php

//ob_start() as saying "Start remembering everything that would normally be outputted, but don't quite do anything with it yet.
ob_start();

//start session
session_start();
//session_destroy();
//define the core paths
//define them as absolute paths to make sure that require_once works as expected
 
 //directory_separator is a php pre-defined constant
 // (\ for windows, and / for unix)

defined("DS")?null:define("DS",DIRECTORY_SEPARATOR);

//make route that direct you to front folder and back folder
//__DIR__ is a magic var which create directory
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT",__DIR__ .DS. "templates/front");

defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK",__DIR__ .DS. "templates/back");

defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");

//configuring database

defined("DB_HOST") ? null : define("DB_HOST", "localhost");

defined("DB_USER") ? null : define("DB_USER", "root");

defined("DB_PASS") ? null : define("DB_PASS", "");

defined("DB_NAME") ? null : define("DB_NAME", "ecom_db");

$connection = mysqli_connect(DB_HOST , DB_USER , DB_PASS , DB_NAME ,3307);

require_once("functions.php");
require_once("cart.php");





?>