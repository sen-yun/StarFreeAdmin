<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    
    $Signinexp1 = $_POST['Signinexp1'];
    $Signinasset1 = $_POST['Signinasset1'];
    $Signinexp2 = $_POST['Signinexp2'];
    $Signinasset2 = $_POST['Signinasset2'];
    $Signinexp3 = $_POST['Signinexp3'];
    $Signinasset3 = $_POST['Signinasset3'];
    $Signinexp4 = $_POST['Signinexp4'];
    $Signinasset4 = $_POST['Signinasset4'];
    $Signinexp5 = $_POST['Signinexp5'];
    $Signinasset5 = $_POST['Signinasset5'];
    $Signinexp6 = $_POST['Signinexp6'];
    $Signinasset6 = $_POST['Signinasset6'];
    $Signinexp7 = $_POST['Signinexp7'];
    $Signinasset7 = $_POST['Signinasset7'];
    
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
        $query = "UPDATE ".$db_prefix."_admin_functions SET Signinexp1=?, Signinasset1=?, Signinexp2=?, Signinasset2=?, Signinexp3=?, Signinasset3=?, Signinexp4=?, Signinasset4=?, Signinexp5=?, Signinasset5=?, Signinexp6=?, Signinasset6=?, Signinexp7=?, Signinasset7=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssssssssssss", $Signinexp1, $Signinasset1, $Signinexp2, $Signinasset2, $Signinexp3, $Signinasset3, $Signinexp4, $Signinasset4, $Signinexp5, $Signinasset5, $Signinexp6, $Signinasset6, $Signinexp7, $Signinasset7);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'signinFunction.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'signinFunction.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'signinFunction.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
