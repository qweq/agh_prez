<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/include/init.php');

$type = $_POST['type'];

if ($type == 'adduser_generate_username') {
    do {
        $username = ucfirst(strtolower($_POST['firstname'])).ucfirst(strtolower($_POST['lastname'])).rand(100, 999);
        $exists = (boolval($mysqli->gdb("SELECT u_id FROM ".$base::db.".user WHERE u_username = '".$username."'")));
    } while ($exists);
    echo $username;
}

if ($type == 'userlist_delete_user') {
    $base->UserDelete($_POST['id']);
}