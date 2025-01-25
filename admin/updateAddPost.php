<?php
session_start();

include_once 'connect.php';
$version = $_POST['version'];
$versionCode = $_POST['versionCode'];
$versionIntro = $_POST['versionIntro'];
$versionUrl = $_POST['versionUrl'];
$force = $_POST['force'];

$file = $_SERVER['PHP_SELF'];


if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    $connectRedis = new Redis();
    if (!$connectRedis->connect($redis_host, $redis_port)) {
        echo "<script>alert('连接Redis失败，请检查Config_DB.php中Redis配置');history.back();</script>";
        exit;
    }
    if (!empty($redis_password)) {
        if (!$connectRedis->auth($redis_password)) {
            echo "<script>alert('Redis认证失败，请检查Config_DB.php中的Redis密码');history.back();</script>";
            exit;
        }
    }
    $redisKeys = $connectRedis->keys($redis_prefix.'_starapi_*');
    foreach ($redisKeys as $redisKey) {
        $connectRedis->del($redisKey);
    }
    $stmt = mysqli_prepare($connect, "INSERT INTO ".$db_prefix."_admin_update (`version`, `versionCode`, `versionIntro`, `versionUrl`, `force`) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sissi', $version, $versionCode, $versionIntro, $versionUrl, $force);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo "<script>alert('添加成功');location.href = 'updateAdmin.php';</script>";
    } else {
        echo "<script>alert('添加失败');location.href = 'updateAdmin.php';</script>";   
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
