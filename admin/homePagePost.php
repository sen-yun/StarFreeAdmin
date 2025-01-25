<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Hometop = isset($_POST['Hometop']) ? $_POST['Hometop'] : 0;
    $Announcement = $_POST['Announcement'];
    $Displaytime  = $_POST['Displaytime'];
    $Searchtext = $_POST['Searchtext'];
    $Carouselswitch = isset($_POST['Carouselswitch']) ? $_POST['Carouselswitch'] : 0;
    $Iconswitch = isset($_POST['Iconswitch']) ? $_POST['Iconswitch'] : 0;
    $Noticeswitch = isset($_POST['Noticeswitch']) ? $_POST['Noticeswitch'] : 0;
    $Notice = $_POST['Notice'];
    $Postswitch = isset($_POST['Postswitch']) ? $_POST['Postswitch'] : 0;
    
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
        $query = "UPDATE ".$db_prefix."_admin_pages SET Hometop=?, Announcement=?, Displaytime=?, Searchtext=?, Notice=?, Carouselswitch=?, Iconswitch=?, Noticeswitch=?, Postswitch=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("issssiiii", $Hometop, $Announcement, $Displaytime, $Searchtext, $Notice, $Carouselswitch, $Iconswitch, $Noticeswitch, $Postswitch);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'homePage.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'homePage.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库: " . $connect->error . "');location.href = 'homePage.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
