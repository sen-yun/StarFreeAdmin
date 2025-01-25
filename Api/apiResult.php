<?php
$updatesql = "SELECT * FROM ".$db_prefix."_admin_update ORDER BY id DESC LIMIT 1";
$updateresult = $db->query($updatesql);
if ($updateresult->num_rows > 0) {
    while($updaterow = $updateresult->fetch_assoc()) {
        $version = $updaterow["version"];
        $versionIntro = $updaterow["versionIntro"];
        $versionUrl = $updaterow["versionUrl"];
        $versionCode = (int) $updaterow["versionCode"];
        $qzgx = (int) $updaterow["force"];
    }
} else {
   $version = "1.0.0";
    $versionIntro = "看到该条消息，说明你打包时候版本号设置错误，需要把版本号改成100";
    $versionUrl = "https://starfree.qxzhi.cn/";
    $versionCode = 100;
    $qzgx = 1;
}
?>