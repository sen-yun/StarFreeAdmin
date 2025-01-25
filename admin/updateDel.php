<?php
session_start();

include_once 'connect.php';
$id = $_GET['id'];
$status = $_GET['status'];
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
    $redisKeys = $connectRedis->keys($redis_prefix.'_admin_functions');
    foreach ($redisKeys as $redisKey) {
        $connectRedis->del($redisKey);
    }
    if ($status === 'one') {
        $stmt = mysqli_prepare($connect, "DELETE FROM ".$db_prefix."_admin_update WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "<script>alert('删除成功');location.href = 'updateAdmin.php';</script>";
        } else {
            echo "<script>alert('删除失败');history.back();</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('参数错误');history.back();</script>";
    }
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}