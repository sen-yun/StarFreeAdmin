<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Findtop = isset($_POST['Findtop']) ? $_POST['Findtop'] : 0;
    $Bannerswitch = isset($_POST['Bannerswitch']) ? $_POST['Bannerswitch'] : 0;
    $Bannernumber = $_POST['Bannernumber'];
    $Bannerimg1 = $_POST['Bannerimg1'];
    $Bannerurl1 = $_POST['Bannerurl1'];
    $Bannerimg2 = $_POST['Bannerimg2'];
    $Bannerurl2 = $_POST['Bannerurl2'];
    $Bannerimg3 = $_POST['Bannerimg3'];
    $Bannerurl3 = $_POST['Bannerurl3'];
    $Bannerimg4 = $_POST['Bannerimg4'];
    $Bannerurl4 = $_POST['Bannerurl4'];
    $Bannerimg5 = $_POST['Bannerimg5'];
    $Bannerurl5 = $_POST['Bannerurl5'];
    $Bannerimg6 = $_POST['Bannerimg6'];
    $Bannerurl6 = $_POST['Bannerurl6'];
    
    
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
        
        $query = "UPDATE ".$db_prefix."_admin_pages SET Findtop=?, Bannerswitch=?, Bannernumber=?, Bannerimg1=?, Bannerurl1=?, Bannerimg2=?, Bannerurl2=?, Bannerimg3=?, Bannerurl3=?, Bannerimg4=?, Bannerurl4=?, Bannerimg5=?, Bannerurl5=?, Bannerimg6=?, Bannerurl6=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("iisssssssssssss", $Findtop, $Bannerswitch, $Bannernumber, $Bannerimg1, $Bannerurl1, $Bannerimg2, $Bannerurl2, $Bannerimg3, $Bannerurl3, $Bannerimg4, $Bannerurl4, $Bannerimg5, $Bannerurl5, $Bannerimg6, $Bannerurl6);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'findPage.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'findPage.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'findPage.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
