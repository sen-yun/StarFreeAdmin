<?php
include_once 'connect.php';

$ipchaxun = "select * from ".$db_prefix."_admin_banip";
$ipres = mysqli_query($connect, $ipchaxun);
while ($IPinfo = mysqli_fetch_array($ipres)) {

    $iplist = $IPinfo['State'];

    $banned_ip = array($iplist);

    $ip = $_SERVER["REMOTE_ADDR"];

    if (in_array(getenv("REMOTE_ADDR"), $banned_ip)) {
        die ("<script>alert('你的IP($ip)已被封禁，禁止访问');location.href = 'error.php';</script>");

    }
}


?>
