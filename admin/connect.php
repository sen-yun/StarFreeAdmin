<?php
header("Content-Type:text/html; charset=utf8");
include_once '../Config_DB.php';
$connect = mysqli_connect($db_address,$db_username,$db_password,$db_name);

if (!$connect) {
    die("<script>location.href = '../".$ADMIN_PATH."/connectDie.php';</script>");
}
$connect->query("SET NAMES 'utf8'");  