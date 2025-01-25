<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Dynamicimg = $_POST['Dynamicimg'];
    
    if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
        // 写入数据库
        $query = "UPDATE Sy_pages SET Dynamicimg=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $Dynamicimg);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'dynamicPage.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'dynamicPage.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'dynamicPage.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
