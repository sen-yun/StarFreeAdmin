<?php
session_start();

include_once 'connect.php';
$id = $_GET['id'];
$file = $_SERVER['PHP_SELF'];

if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    if ($id === 'all') {
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = date('Y-m-d H:i:s');
        $ipAdd = "清空了日志";
        
        $sql = "TRUNCATE TABLE " . $db_prefix . "_admin_ip";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            $insert_sql = "INSERT INTO " . $db_prefix . "_admin_ip (ipAdd, Time, State) VALUES (?, ?, ?)";
            $stmt = $connect->prepare($insert_sql);
            $stmt->bind_param("sss", $ipAdd, $time, $ip);
            $stmt->execute();
            $stmt->close();
            
            echo "<script>alert('删除成功');location.href = 'ipList.php';</script>";
        } else {
            echo "<script>alert('删除失败');history.back();</script>";
        }
    } else {
        echo "<script>alert('参数错误');history.back();</script>";
    }
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}