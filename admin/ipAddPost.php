<?php
session_start();
?>

<?php
$ip = trim($_POST['ipdz']);
$bz = trim($_POST['bz']);
$time = gmdate("Y-m-d H:i:s", time() + 8 * 3600);
$ipgsd = get_ip_city($ip);
$file = $_SERVER['PHP_SELF'];
function get_ip_city($ip)
{
    $ch = curl_init();
    $url = 'https://whois.pconline.com.cn/ipJson.jsp?ip=' . $ip;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $location = curl_exec($ch);
    curl_close($ch);
    $location = mb_convert_encoding($location, 'utf-8', 'GB2312');
    $location = substr($location, strlen('({') + strpos($location, '({'), (strlen($location) - strpos($location, '})')) * (-1));
    $location = str_replace('"', "", str_replace(":", "=", str_replace(",", "&", $location)));
    parse_str($location, $ip_location);
    return $ip_location['addr'];
}

include_once 'connect.php';

if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
    $stmt = mysqli_prepare($connect, "INSERT INTO ".$db_prefix."_admin_banip (ipAdd, Time, State, text) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $ipgsd, $time, $ip, $bz);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    if ($result) {
        echo "<script>alert('添加成功');location.href = 'ipbanList.php';</script>";
    } else {
        echo "<script>alert('添加失败');location.href = 'ipbanList.php';</script>";
    }
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}

