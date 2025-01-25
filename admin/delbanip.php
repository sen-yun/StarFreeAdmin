<?php
session_start();
include_once 'connect.php';
$id = $_GET['id'];
$file = $_SERVER['PHP_SELF'];

if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    if (is_numeric($id)) {
        $stmt = mysqli_prepare($connect, "DELETE FROM ".$db_prefix."_admin_banip WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($result) {
            echo "<script>alert('删除成功');location.href = 'ipbanList.php';</script>";
        } else {
            echo "<script>alert('删除失败')';history.back();</script>";
        }
    } else {
        echo "<script>alert('参数错误');history.back();</script>";
    }
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
