<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Admin = $_POST['Admin'];
    $Gallery = isset($_POST['Gallery']) ? $_POST['Gallery'] : 0;
    $Code = isset($_POST['Code']) ? $_POST['Code'] : 0;
    $Hyperlinks = isset($_POST['Hyperlinks']) ? $_POST['Hyperlinks'] : 0;
    $Comments = isset($_POST['Comments']) ? $_POST['Comments'] : 0;
    $Image = isset($_POST['Image']) ? $_POST['Image'] : 0;
    $Video = isset($_POST['Video']) ? $_POST['Video'] : 0;
    $Topic = isset($_POST['Topic']) ? $_POST['Topic'] : 0;
    $Shop = isset($_POST['Shop']) ? $_POST['Shop'] : 0;
    $Viptext = isset($_POST['Viptext']) ? $_POST['Viptext'] : 0;
    $Music = isset($_POST['Music']) ? $_POST['Music'] : 0;
    $Musicimg1 = $_POST['Musicimg1'];
    $Musicimg2 = $_POST['Musicimg2'];
    $Musicimg3 = $_POST['Musicimg3'];
    
    
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
        $query = "UPDATE ".$db_prefix."_admin_pages SET Admin=?, Gallery=?, Code=?, Hyperlinks=?, Comments=?, Image=?, Video=?, Topic=?, Shop=?, Viptext=?, Music=?, Musicimg1=?, Musicimg2=?, Musicimg3=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("siiiiiiiiiisss", $Admin, $Gallery, $Code, $Hyperlinks, $Comments, $Image, $Video, $Topic, $Shop, $Viptext, $Music, $Musicimg1, $Musicimg2, $Musicimg3);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'postPage.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'postPage.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'postPage.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
