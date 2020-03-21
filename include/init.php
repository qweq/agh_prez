<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once('class/global_functions.php');
require_once('class/Base.class.php');
require_once('class/Database.class.php');

$mysqli = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$base = new Base($mysqli);
?>