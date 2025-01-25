<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    
    $Usernumber = isset($_POST['Usernumber']) ? $_POST['Usernumber'] : 0;
    $Circlestyle = $_POST['Circlestyle'];
    $Dumnum = $_POST['Dumnum'];
    $Dynamicimg = $_POST['Dynamicimg'];
    
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
        $query = "UPDATE ".$db_prefix."_admin_pages SET Usernumber=?, Circlestyle=?, Dumnum=?, Dynamicimg=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("isss", $Usernumber, $Circlestyle, $Dumnum, $Dynamicimg);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'circlePage.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'circlePage.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'circlePage.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
