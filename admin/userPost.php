<?php
session_start();
?>

<?php
$adminName = trim($_POST['adminName']);
$pw = trim($_POST['pw']);
$file = $_SERVER['PHP_SELF'];
include_once 'connect.php';

if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    
    if ($pw) {
        $stmt = $connect->prepare("UPDATE " . $db_prefix . "_admin_login SET user=?, pw=? WHERE id=1");
        $password = md5($pw);
        $stmt->bind_param("ss", $adminName, $password);
        session_destroy();
    } else {
        $stmt = $connect->prepare("UPDATE " . $db_prefix . "_admin_login SET user=? WHERE id=1");
        $stmt->bind_param("s", $adminName);
    }

    if ($stmt->execute()) {
        echo "<script>alert('修改成功');location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('修改失败');location.href = 'login.php';</script>";
    }
    $stmt->close();

} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
