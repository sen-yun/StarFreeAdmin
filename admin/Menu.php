<?php
session_start();
include_once 'ipban.php';
include_once 'connect.php';
if (!isset($_SESSION['loginadmin'])) {
    die("<script>alert('请先登录');window.location.href='".$ADMIN_PATH."/login.php';</script>");
}

if (!$connect) {
    die("<script>alert('数据库连接失败: " . mysqli_connect_error() . "');</script>");
}

$sql = "SELECT * FROM ".$db_prefix."_admin_login WHERE `user` = ?";
if (!($stmt = $connect->prepare($sql))) {
    die("<script>alert('准备语句失败: " . $connect->error . "');</script>");
}

$stmt->bind_param("s", $_SESSION['loginadmin']);
if (!$stmt->execute()) {
    die("<script>alert('执行查询失败: " . $stmt->error . "');</script>");
}

$loginresult = $stmt->get_result();

if ($loginresult && $loginresult->num_rows > 0) {
    $login = $loginresult->fetch_assoc();
} else {
    die("<script>alert('登录检查失败: 找不到相关用户信息');</script>");
}

$stmt->close();

?>


<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8"/>
    <title>StarFree 后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400&display=swap" rel="stylesheet">
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/menu.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<script src="../Style/jquery/jquery.min.js"></script>

<?php
$adminuser = "admin";
$adminpw = "123456";
?>

<div class="navbar-custom topnav-navbar" style="background-color: white;">
    <div class="container-fluid">

        <a class="topnav-logo anchor">
                    <span class="topnav-logo-lg">
                        StarFree
                    </span>
            <span class="topnav-logo-sm anchor">
                        StarFree
                    </span>
        </a>

        <ul class="list-unstyled topbar-right-menu float-right mb-0">


            <li class="dropdown notification-list">
                <a class="nav-link right-bar-toggle"  href="<?php echo $ADMIN_PATH;?>/userOperate.php">
                    <i class="dripicons-gear noti-icon"></i>
                </a>
            </li>

        </ul>
        <a class="button-menu-mobile disable-btn">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        <div class="app-search">
        </div>
    </div>
</div>
<div class="container-fluid">

    <div class="wrapper">
        
        <div class="left-side-menu" style="border-radius:14px;">
            <div class="leftbar-user">
                <div class="text-center w-75 m-auto">
                            <h1>
                            <a class="anchor"><span>StarFree</span></a></h1>
                        </div>
            </div>

            <ul class="metismenu side-nav">
                <li class="side-nav-item">
                    <a href="<?php echo $ADMIN_PATH;?>/index.php" class="side-nav-link">
                        <i class="dripicons-meter"></i>
                        <span>数据面板</span> 
                        <span class="menu-arrow"></span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-gear"></i>
                        <span>系统设置</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/settings.php" class="side-nav-link">
                                <i class="dripicons-device-desktop"></i>
                                <span>全局设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a  href="<?php echo $ADMIN_PATH;?>/setUser.php" class="side-nav-link">
                                <i class="dripicons-user"></i>
                                <span>用户设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setAudit.php" class="side-nav-link">
                                <i class="dripicons-inbox"></i>
                                <span>审核设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setOther.php" class="side-nav-link">
                                <i class="dripicons-document"></i>
                                <span>发布设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a  href="<?php echo $ADMIN_PATH;?>/setAd.php" class="side-nav-link">
                                <i class="dripicons-broadcast"></i>   
                                <span>广告配置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        
                    </ul>
                    
                </li>
               
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-document-new"></i>
                        <span>页面设置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/homePage.php" class="side-nav-link">
                                <i class="dripicons-home"></i>
                                <span>首页</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/findPage.php" class="side-nav-link">
                                <i class="dripicons-camera"></i>
                                <span>发现页</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/postPage.php" class="side-nav-link">
                                <i class="dripicons-document-edit"></i>
                                <span>发帖页</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/circlePage.php" class="side-nav-link">
                                <i class="dripicons-help"></i>
                                <span>圈子动态页</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/Popups.php" class="side-nav-link">
                                <i class="dripicons-message"></i>
                                <span>弹窗设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-list"></i>
                        <span>功能设置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/updateAdmin.php" class="side-nav-link">
                                <i class="dripicons-cloud-upload"></i>
                                <span>版本管理</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="#" class="side-nav-link">
                                <i class="dripicons-star"></i>
                                <span>VIP配置</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="metismenu side-nav">
                                <li class="side-nav-item right_10">
                                    <a href="<?php echo $ADMIN_PATH;?>/vipAdmin.php" class="side-nav-link">
                                        <i class="dripicons-view-list-large"></i>
                                        <span>VIP套餐</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                </li>
                                <li class="side-nav-item right_10">
                                    <a href="<?php echo $ADMIN_PATH;?>/vipFunction.php" class="side-nav-link">
                                        <i class="dripicons-star"></i>
                                        <span>VIP设置</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/signinFunction.php" class="side-nav-link">
                                <i class="dripicons-calendar"></i>   
                                <span>签到设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-cloud-upload"></i>
                        <span>上传配置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setUpload.php" class="side-nav-link">
                                <i class="dripicons-pamphlet"></i>
                                <span>上传设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setCos.php" class="side-nav-link">
                                <i class="dripicons-network-3"></i>
                                <span>COS模式</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setOss.php" class="side-nav-link">
                                <i class="dripicons-network-2"></i>
                                <span>OSS模式</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setQiniu.php" class="side-nav-link">
                                <i class="dripicons-network-4"></i>
                                <span>七牛模式</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setFtp.php" class="side-nav-link">
                                <i class="dripicons-network-1"></i>
                                <span>FTP模式</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-wallet"></i>
                        <span>支付配置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/payAlipay.php" class="side-nav-link">
                                <i class="dripicons-user-id"></i>
                                <span>支付宝支付</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/payWxpay.php" class="side-nav-link">
                                <i class="dripicons-ticket"></i>
                                <span>微信支付</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/payEpay.php" class="side-nav-link">
                                <i class="dripicons-shopping-bag"></i>   
                                <span>易支付</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                   
                    <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-user"></i>
                        <span>登录配置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                    <li class="side-nav-item right_10">
                        <a  href="<?php echo $ADMIN_PATH;?>/loginWx.php" class="side-nav-link">
                            <i class="dripicons-message"></i>
                            <span>微信登录</span>
                            <span class="menu-arrow"></span>
                        </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a  href="<?php echo $ADMIN_PATH;?>/loginQQ.php" class="side-nav-link">
                                <i class="dripicons-graduation"></i>   
                                <span>QQ登录</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a  href="<?php echo $ADMIN_PATH;?>/loginWb.php" class="side-nav-link">
                                <i class="dripicons-conversation"></i>   
                                <span>微博登录</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-broadcast"></i>
                        <span>通知配置</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a  href="<?php echo $ADMIN_PATH;?>/setPush.php" class="side-nav-link">
                                <i class="dripicons-bell"></i>
                                <span>UniPush推送</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                         <li class="side-nav-item right_10">
                        <a href="#" class="side-nav-link">
                            <i class="dripicons-calendar"></i>
                            <span>邮箱设置</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="metismenu">
                                 <li class="side-nav-item right_10">
                                        <a  href="<?php echo $ADMIN_PATH;?>/setEmail.php" class="side-nav-link">
                                            <i class="dripicons-document-remove"></i>   
                                            <span>邮箱配置</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    </li>
                                    <li class="side-nav-item right_10">
                                        <a  href="<?php echo $ADMIN_PATH;?>/setEmailMode.php" class="side-nav-link">
                                            <i class="dripicons-article"></i>   
                                            <span>邮箱模板</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                    </li>
                                </ul>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-stack"></i>
                        <span>核心配置</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="metismenu side-nav">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setSafe.php" class="side-nav-link">
                                <i class="dripicons-web"></i>
                                <span>安全设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setMysql.php" class="side-nav-link">
                                <i class="dripicons-stack"></i>
                                <span>Mysql设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/setRedis.php" class="side-nav-link">
                                <i class="dripicons-view-apps"></i>
                                <span>Redis设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-item">
                    <a href="<?php echo $ADMIN_PATH;?>/lovelist.php" class="side-nav-link">
                        <i class="dripicons-lock"></i>  
                        <span> 后台安全</span> 
                        <span class="menu-arrow"></span>
                    </a>
                         <ul class="metismenu">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/user.php" class="side-nav-link">
                                <i class="dripicons-user"></i>   
                                <span> 账号设置</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/ipList.php" class="side-nav-link">
                                <i class="dripicons-web"></i>
                                <span> 登录日志</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/errorList.php" class="side-nav-link">
                                <i class="dripicons-warning"></i>
                                <span> 非法操作</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/ipbanList.php" class="side-nav-link">
                                <i class="dripicons-wrong"></i>
                                <span> 后台IP封禁</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        
                    </ul>
                    
                </li>
                
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link">
                        <i class="dripicons-folder-open"></i>   
                        <span>关于程序</span> 
                        <span class="menu-arrow"></span>
                    </a>
                    
                    <ul class="metismenu">
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/updateVersion.php" class="side-nav-link">
                                <i class="dripicons-cloud-download"></i>   
                                <span> 版本更新</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/upgradePro.php" class="side-nav-link">
                                <i class="dripicons-browser-upload"></i>
                                <span> 升级Pro</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                        <li class="side-nav-item right_10">
                            <a href="<?php echo $ADMIN_PATH;?>/aboutAuthor.php" class="side-nav-link">
                                <i class="dripicons-star"></i>
                                <span> 关于作者</span>
                                <span class="menu-arrow"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="content-page">
            <div class="content">

</body>
</html>
<?php


$versionFile = dirname(__DIR__) . '/version.ini';
$currentVersion = parse_ini_file($versionFile);

$curl = curl_init();
$url = $API_NEW_VERSION;
curl_setopt_array($curl, array(
   CURLOPT_URL => $url,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
if (curl_errno($curl)) {
    echo "<div class='alert alert-danger'>";
    echo "CURL错误: " . curl_error($curl) . "<br>";
    echo "</div>";
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$latestVersion = array(
    'version' => '未知',
    'name' => '',
    'code' => 0
);
$versions = array();
$systemInfo = array();
$lastUpdateTime = '未知';

$responseData = json_decode($response, true);
if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {
    // 从data字段中获取数据
    $data = $responseData['data'];
    
    if (isset($data['currentVersion'])) {
        $latestVersion = $data['currentVersion'];
        $versions = $data['versions'] ?? array();
        $systemInfo = $data['systemInfo'] ?? array();
        $lastUpdateTime = $data['lastUpdateTime'] ?? '未知';
        $downloadUrl = $data['freeapiupdate'] ?? '';
        $downloadUrlApp = $data['freeapiupdateapp'] ?? '';
        // 检查是否需要更新
        $needUpdate = $currentVersion['versionCode'] < $latestVersion['code'];
        
        if ($needUpdate && !strpos($_SERVER['PHP_SELF'], 'updateVersion')) {
            echo "<div class='alert alert-info'>";
            echo "发现新版本可用！建议更新到最新版本 " . $latestVersion['version'] . " <a href='" . $ADMIN_PATH . "/updateVersion.php' class='alert-link'>点我查看新版本</a>";
            echo "</div>";
        }
    }
}
?>