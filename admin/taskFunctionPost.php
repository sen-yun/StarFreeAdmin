<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Task1 = isset($_POST['Task1']) ? $_POST['Task1'] : 0;
    $Taskexp1 = $_POST['Taskexp1'];
    $Taskasset1 = $_POST['Taskasset1'];
    $Task2 = isset($_POST['Task2']) ? $_POST['Task2'] : 0;
    $Taskexp2 = $_POST['Taskexp2'];
    $Taskasset2 = $_POST['Taskasset2'];
    $Tasklimit2 = $_POST['Tasklimit2'];
    $Task3 = isset($_POST['Task3']) ? $_POST['Task3'] : 0;
    $Taskexp3 = $_POST['Taskexp3'];
    $Taskasset3 = $_POST['Taskasset3'];
    $Tasklimit3 = $_POST['Tasklimit3'];
    $Task4 = isset($_POST['Task4']) ? $_POST['Task4'] : 0;
    $Taskexp4 = $_POST['Taskexp4'];
    $Taskasset4 = $_POST['Taskasset4'];
    $Tasklimit4 = $_POST['Tasklimit4'];
    $Task5 = isset($_POST['Task5']) ? $_POST['Task5'] : 0;
    $Taskexp5 = $_POST['Taskexp5'];
    $Taskasset5 = $_POST['Taskasset5'];
    $Tasklimit5 = $_POST['Tasklimit5'];
    $Task6 = isset($_POST['Task6']) ? $_POST['Task6'] : 0;
    $Taskexp6 = $_POST['Taskexp6'];
    $Taskasset6 = $_POST['Taskasset6'];
    $Tasklimit6 = $_POST['Tasklimit6'];
    if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
        // 写入数据库
        $query = "UPDATE Sy_functions SET Task1=?, Taskexp1=?, Taskasset1=?, Task2=?, Taskexp2=?, Taskasset2=?, Tasklimit2=?, Task3=?, Taskexp3=?, Taskasset3=?, Tasklimit3=?, Task4=?, Taskexp4=?, Taskasset4=?, Tasklimit4=?, Task5=?, Taskexp5=?, Taskasset5=?, Tasklimit5=?, Task6=?, Taskexp6=?, Taskasset6=?, Tasklimit6=?";
        $stmt = $connect->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ississsisssisssisssisss", $Task1, $Taskexp1, $Taskasset1, $Task2, $Taskexp2, $Taskasset2, $Tasklimit2, $Task3, $Taskexp3, $Taskasset3, $Tasklimit3, $Task4, $Taskexp4, $Taskasset4, $Tasklimit4, $Task5, $Taskexp5, $Taskasset5, $Tasklimit5, $Task6, $Taskexp6, $Taskasset6, $Tasklimit6);

            if ($stmt->execute()) {
                echo "<script>alert('更改成功');location.href = 'taskFunction.php';</script>";
            } else {
                echo "<script>alert('更改失败');location.href = 'taskFunction.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('无法连接数据库');location.href = 'taskFunction.php';</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
