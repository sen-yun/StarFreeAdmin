<?php
$sql1 = "SELECT * FROM ".$db_prefix."_admin_set";
$result1 = mysqli_query($db, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
}
$h5_of = (int) $row1['h5of'];
if ($h5_of == 1) {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
}
$redis = new Redis();
if ($redis_password) {
    $redis->connect($redis_host, $redis_port);
    $redis->auth($redis_password);
} else {
    $redis->connect($redis_host, $redis_port);
}
$act=$_GET['act'];
$cacheKeyPrefix = $redis_prefix.'_starapi_';
$cacheKey = $cacheKeyPrefix . $act;
$cacheTTL = 86400; 

$cachedData = $redis->get($cacheKey);
if ($cachedData !== false) {
    header('Content-Type: application/json');
    echo base64_decode($cachedData);
    exit;
}


$sql2 = "SELECT * FROM ".$db_prefix."_admin_pages";
$result2 = mysqli_query($db, $sql2);
if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
}
$sql3 = "SELECT * FROM ".$db_prefix."_admin_popups";
$result3 = mysqli_query($db, $sql3);
if (mysqli_num_rows($result3) > 0) {
    $row3 = mysqli_fetch_assoc($result3);
}
$sql4 = "SELECT * FROM ".$db_prefix."_admin_functions";
$result4 = mysqli_query($db, $sql4);
if (mysqli_num_rows($result4) > 0) {
    $row4 = mysqli_fetch_assoc($result4);
}

$announcement = $row2['Announcement'];
$ggtime = (int) $row2['Displaytime'];
$xzcategory = $row2['Admin'];
$post_tool1 = (int) $row2['Gallery'];
$post_tool2 = (int) $row2['Code'];
$post_tool3 = (int) $row2['Hyperlinks'];
$post_tool4 = (int) $row2['Comments'];
$post_tool5 = (int) $row2['Image'];
$post_tool6 = (int) $row2['Topic'];
$post_tool7 = (int) $row2['Shop'];
$post_tool8 = (int) $row2['Video'];
$post_tool9 = (int) $row2['Viptext'];
$post_tool10 = (int) $row2['Music'];
$musicpic1 = $row2['Musicimg1'];
$musicpic2 = $row2['Musicimg2'];
$musicpic3 = $row2['Musicimg3'];

$findtop = (int) $row2['Findtop'];
$hometop = (int) $row2['Hometop'];
$dumnum = (int) $row2['Dumnum'];
$dsof = (int) $row1['Tipping'];
$dsstyle = (int) $row1['Tippingstyle'];
$shareof = (int) $row1['Share'];
$lvof = (int) $row1['Lvof'];
$posttext = $row3['Postpopup'];
$shoptext = $row3['Shoppopup'];

$renwutext = $row3['Taskpopup'];

$jingyantext = $row3['Signpopup'];

$cztext1 = $row3['Alipaypopup'];
$cztext2 = $row3['Wechatpopup'];
$cztext3 = $row3['Camipopup'];
$cztext4 = $row3['Yipaypopup'];
$logintext = $row3['Loginpopup'];
$registertext = $row3['Registpopup'];
$fogettext = $row3['Forgetpopup'];
$qqqun = $row1['Groupurl'];
$shenhe = $row1['Auditurl'];
$kefu = $row1['Waiterurl'];
$assetsname = $row1['Assetname'];
$vipzk = (int) $row4['Vipdiscount'];
$gonggao = $row2['Notice'];
$sousuok = $row2['Searchtext'];

$viptext = $row4['Vipprivilege'];

$viptct = (int) $row4['Vippackage'];
$viptctitle = $row4['Vippackagetitle'];

$viptctext = $row4['Vippackagetext'];

$tixianed = $row1['Threshold'];
$tixiansx = $row1['Premium'];

$lunbo_of = (int) $row2['Carouselswitch'];
$gonggao_of = (int) $row2['Noticeswitch'];
$top_of = (int) $row2['Iconswitch'];
$act_of = (int) $row2['Postswitch'];
$videoimg = $row2['Dynamicimg'];
$userlist_of = (int) $row2['Usernumber'];
$userdiy = (int) $row1['Dummy'];
$quanzi_style = (int) $row2['Circlestyle'];
$bannerswitch = (int) $row2['Bannerswitch'];
$chongzhi = (int) $row1['Payswith'];
$czof1 = (int) $row1['Alipay'];
$czof2 = (int) $row1['WePay'];
$czof3 = (int) $row1['Cami'];
$czof4 = (int) $row1['Yipay'];

$tixian = (int) $row1['Withdrawals'];
$qqlogin  =  (int) $row1['Qlogin'];
$qqgroup  =  $row1['Qgroup']; 
$correctPassword = $row1['Viewspw'];

$adimage_sl = (int) $row2['Bannernumber'];
$adimage1 = $row2['Bannerimg1'];
$link_url1 = $row2['Bannerurl1'];

$adimage2 = $row2['Bannerimg2'];
$link_url2 = $row2['Bannerurl2'];

$adimage3 = $row2['Bannerimg3'];
$link_url3 = $row2['Bannerurl3'];

$adimage4 = $row2['Bannerimg4'];
$link_url4 = $row2['Bannerurl4'];

$adimage5 = $row2['Bannerimg5'];
$link_url5 =$row2['Bannerurl5'];
$adimage6 = $row2['Bannerimg6'];
$link_url6 = $row2['Bannerurl6'];


$assets_1day = (int) $row4['Signinasset1'];
$assets_2day = (int) $row4['Signinasset2'];
$assets_3day = (int) $row4['Signinasset3'];
$assets_4day = (int) $row4['Signinasset4'];
$assets_5day = (int) $row4['Signinasset5'];
$assets_6day = (int) $row4['Signinasset6'];
$assets_7day = (int) $row4['Signinasset7'];

$experience_1day = (int) $row4['Signinexp1'];
$experience_2day = (int) $row4['Signinexp2'];
$experience_3day = (int) $row4['Signinexp3'];
$experience_4day = (int) $row4['Signinexp4'];
$experience_5day = (int) $row4['Signinexp5'];
$experience_6day = (int) $row4['Signinexp6'];
$experience_7day = (int) $row4['Signinexp7'];
