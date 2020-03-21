<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/include/init.php');

$type = $_POST['type'];

if ($type == 'userlist') {
    include($_SERVER['DOCUMENT_ROOT'].'/userlist.php');
}