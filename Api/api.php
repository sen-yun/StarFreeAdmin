<?php
header('Content-Type: application/json;charset=utf-8');
include('config.php');
include('apiResult.php');
include('set.php');

function json($code,$msg){
    echo json_encode(array("code"=>$code,"msg"=>$msg));
}

if(isset($_GET['update'])){
    $result=array(
    'version'=>$version,
    'versionIntro'=>$versionIntro,
    'versionUrl'=>$versionUrl,
    'versionCode'=>$versionCode,
    'qzgx'=>$qzgx,
    'announcement'=>$announcement
   );
   echo json_encode($result);
}

$musicpic = array(
  $musicpic1,
  $musicpic2,
  $musicpic3
);

if($act=="opset"){
if ($vipzk == 10) {
  $vipDiscount = 1.0;
  $vipzkname = '无折扣';
} else if ($vipzk >= 1 && $vipzk <= 9) {
  $vipDiscount = $vipzk / 10.0;
  $vipzkname = $vipzk.'折';
} else if ($vipzk == 0) {
  $vipDiscount = 0.0;
  $vipzkname = '免费';
} else {
 $vipDiscount = 1.0;
 $vipzkname = '无折扣';
}
$data = array(
        'post_tool1' => $post_tool1,
        'post_tool2' => $post_tool2,
        'post_tool3' => $post_tool3,
        'post_tool4' => $post_tool4,
        'post_tool5' => $post_tool5,
        'post_tool6' => $post_tool6,
        'post_tool7' => $post_tool7,
        'post_tool8' => $post_tool8,
        'tixianed' => $tixianed,
        'tixiansx' => $tixiansx,
        'vipDiscount' => $vipDiscount,
        'vipzkname' => $vipzkname,
        'assetsname' => $assetsname,
        'posttext' => $posttext,
        'chongzhi' => $chongzhi,
        'tixian' => $tixian,
        'viptext' => $viptext,
        'viptct' => $viptct,
        'viptctitle' => $viptctitle,
        'viptctext' => $viptctext,
        'renwutext' => $renwutext,
        'jingyantext' => $jingyantext,
        'vipzk' => $vipzk,
        'dsstyle' => $dsstyle,
        'shareof' => $shareof,
        'lvof' => $lvof,
        'dsof' => $dsof,
        'logintext' => $logintext,
        'registertext' => $registertext,
        'fogettext' => $fogettext,
        'shoptext' => $shoptext,
        'qqqun' => $qqqun,
        'shenhe' => $shenhe,
        'kefu' => $kefu
        );
$json = json_encode($data);
$redis->setex($cacheKey, $cacheTTL, base64_encode($json));
header('Content-Type: application/json');
echo $json;
}

if($act=="appdata"){
    $data = array(
        'gonggao' => $gonggao,
        'sousuok' => $sousuok,
        'findtop' => $findtop,
        'bannerswitch' => $bannerswitch,
        'hometop' => $hometop,
        'userlist_of' => $userlist_of,
        'userlist_all' => 0,
        'quanzi_style' => $quanzi_style,
        'lunbo_of' => $lunbo_of,
        'gonggao_of' => $gonggao_of,
        'top_of' => $top_of,
        'act_of' => $act_of,
        'ggtime' => $ggtime,
        'videoimg' => $videoimg
        );
    $response = json_encode($data);
    $redis->setex($cacheKey, $cacheTTL, base64_encode($response));
    header('Content-Type: application/json');
    echo $response;
}

if ($act === 'adimg2') {
$data = array(
    'adimage1' => $adimage1,
    'adimage2' => $adimage2,
    'adimage3' => $adimage3,
    'adimage4' => $adimage4,
    'adimage5' => $adimage5,
    'adimage6' => $adimage6,
    'adimage_sl' => $adimage_sl,
    'link_url1' => $link_url1,
    'link_url2' => $link_url2,
    'link_url3' => $link_url3,
    'link_url4' => $link_url4,
    'link_url5' => $link_url5,
    'link_url6' => $link_url6
    );
    $response = json_encode($data);
    $redis->setex($cacheKey, $cacheTTL, base64_encode($response));
    header('Content-Type: application/json');
    echo $response;
}



// if ($act === 'vip') {
//     $token = $_GET['token'];
//     $user_result = userVerify($token);
//     if ($user_result['code'] !== 200) {
//         $response = array("code" => $user_result['code'], "msg" => $user_result['msg']);
//         header('Content-Type: application/json');
//         echo json_encode($response);
//         exit();
//     }
//     $uid = $user_result['data']['uid'];
//     $stmt = $db->prepare("SELECT vip FROM ".$db_prefix."_users WHERE uid = ?");
//     $stmt->bind_param("s", $uid);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     if ($result->num_rows === 0) {
//         $response = array("code" => 1, "msg" => "你的账号出错，请联系客服");
//         header('Content-Type: application/json');
//         echo json_encode($response);
//         exit();
//     } else {
//         $row = $result->fetch_assoc();
//         $vip = $row['vip'];
//         $response = array('vip' => $vip);
//     }
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }

if($act=="fenlei"){
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = mysqli_real_escape_string($db, $id);
} else {
    $response = array("code" => 400, "msg" => "参数错误");
    echo json_encode($response);
    exit();
}

$stmt = $db->prepare("SELECT COUNT(*) AS count FROM ".$db_prefix."_relationships WHERE mid=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

$data = array('count' => ($count ? $count : 0));
$json = json_encode($data);

header('Content-Type: application/json');
echo $json;
}
if($act=="qiandaojl"){
    $assets = array();
    $experience = array();
    for($i=1; $i<=7; $i++) {
        $assets["assets_{$i}day"] = ${"assets_{$i}day"};
        $experience["experience_{$i}day"] = ${"experience_{$i}day"}; 
    }
    
    $response = array_merge($assets, $experience);

    header('Content-Type: application/json');
    $redis->setex($cacheKey, $cacheTTL, base64_encode(json_encode($response)));
    
    echo json_encode($response);
    exit();
}

if($act=="qiandao"){
    $token = $_GET["token"];
    $user_result = userVerify($token);
    if ($user_result['code'] !== 200) {
        $response = array("code" => $user_result['code'], "msg" => $user_result['msg']);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    $uid = $user_result['data']['uid'];
    $now = time();
    $today = date("Y-m-d", $now);

    // 查询用户签到信息
    $stmt = $db->prepare("SELECT * FROM `".$db_prefix."_admin_Signinlog` WHERE `uid`=? ORDER BY `time` DESC LIMIT 1");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $lastTime = strtotime($row["time"]);
    $lastDate = date("Y-m-d", $lastTime);
    if ($lastDate == $today) {
            $response = array("code" => 1, "msg" => "今天已经签到过了");
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    // 计算连续签到天数
    if ($result->num_rows > 0 && $lastDate == date("Y-m-d", $now - 86400)) {
        // 连续签到
        $continuous = $row["continuous"] + 1;
        if ($continuous == 8) {
            $continuous = 1;
        }
    } else {
        // 中断签到
        $continuous = 1;
    }
    // 没有签到过，进行签到操作
    $assets = $assets_1day;
    $experience = $experience_1day;
    if ($result->num_rows > 0 && $lastDate == date("Y-m-d", $now - 86400)) {
        // 连续签到，增加额外积分
    }
    // 根据连续签到天数设置奖励
    switch ($continuous) {
        case 2:
            $assets = $assets_2day;
            $experience = $experience_2day;
            break;
        case 3:
            $assets = $assets_3day;
            $experience = $experience_3day;
            break;
        case 4:
            $assets = $assets_4day;
            $experience = $experience_4day;
            break;
        case 5:
            $assets = $assets_5day;
            $experience = $experience_5day;
            break;
        case 6:
            $assets = $assets_6day;
            $experience = $experience_6day;
            break;
        case 7:
            $assets = $assets_7day;
            $experience = $experience_7day;
            break;
        default:
            break;
    }
    // 更新用户资产和签到记录
    $stmt = $db->prepare("UPDATE `".$db_prefix."_users` SET `assets`=`assets`+? WHERE `uid`=?");
    $stmt->bind_param("is", $assets, $uid);
    $stmt->execute();

    $stmt = $db->prepare("UPDATE `".$db_prefix."_users` SET `experience`=`experience`+? WHERE `uid`=?");
    $stmt->bind_param("is", $experience, $uid);
    $stmt->execute();

    $stmt = $db->prepare("INSERT INTO `".$db_prefix."_admin_Signinlog`(`id`, `uid`, `time`, `continuous`, `assets`, `exp`) VALUES (NULL,?,NOW(),?,?,?)");
    $stmt->bind_param("siii", $uid, $continuous, $assets, $experience);
    $stmt->execute();

    $subject = "连续签到".$continuous."天";
    $total_amount = $assets;
    $out_trade_no = time() . "Signinlog";
    $paytype = "Signin";
    $created = time();
    $status = 1;

    $stmt = $db->prepare("INSERT INTO ".$db_prefix."_paylog (subject, total_amount, out_trade_no, paytype, uid, created, status) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sisssii", $subject, $total_amount, $out_trade_no, $paytype, $uid, $created, $status);
    $stmt->execute();
    $response = array("code" => 0, "msg" => "签到成功");
    // 返回结果
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

}


if($act=="leiji"){
    $token = $_GET["token"];
    $user_result = userVerify($token);
    if ($user_result['code'] !== 200) {
        $response = array("code" => $user_result['code'], "msg" => $user_result['msg']);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    $uid = $user_result['data']['uid'];
    $time = date("Y-m-d", time());
    
    // 查询用户信息
    $stmt = $db->prepare("SELECT * FROM ".$db_prefix."_users WHERE uid=?");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // 你的账号出错，请联系客服
        $response = array("code" => 1, "msg" => "你的账号出错，请联系客服");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $row = $result->fetch_assoc();
    
    // 查询用户签到信息
    $stmt = $db->prepare("SELECT * FROM `".$db_prefix."_admin_Signinlog` WHERE `uid`=? ORDER BY `time` DESC LIMIT 1");
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $continuous = $row['continuous'];

    // 封装JSON数据
    $data = array(
        'leiji' => ($continuous ? $continuous : 0)
    );
   
    $json = json_encode($data);

    // 输出JSON数据
    header('Content-Type: application/json');
    echo $json;
}

if($act=="viphide"){
    $token = $_GET['token'];
    $user_result = userVerify($token);
    if ($user_result['code'] !== 200) {
        $response = array("code" => $user_result['code'], "msg" => $user_result['msg']);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    if($user_result['data']['isvip']==1){
        $data = array(
            'post_tool9' => $post_tool9,
            'post_tool10' => $post_tool10
        );
    }else{
        $data = array(
            'post_tool9' => 0,
            'post_tool10' => 0
        );
    }
$json = json_encode($data);

// 输出JSON数据
header('Content-Type: application/json');
echo $json;
}
if($act=="musicpic"){
    $url = $musicpic[rand(0, count($musicpic) - 1)];
    header("Location: " . $url);
    exit;
}
if ($act == "likeall") {
    if (!isset($_GET['uid']) || empty($_GET['uid'])) {
        echo json_encode(['error' => '缺少uid参数']);
        exit;
    }
    $uid = $_GET['uid'];
    
    $stmt = $db->prepare("SELECT SUM(likes) as total_likes FROM ".$db_prefix."_contents WHERE authorId = ?");
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $likes_result = $stmt->get_result();
    $likes_row = $likes_result->fetch_assoc();
    $likes_all = $likes_row['total_likes'] ?? 0;

    // 获取粉丝数
    $stmt = $db->prepare("SELECT COUNT(*) AS fan_count FROM ".$db_prefix."_fan WHERE uid = ?");
    $stmt->bind_param('s', $uid);
    $stmt->execute(); 
    $fan_result = $stmt->get_result();
    $fan_row = $fan_result->fetch_assoc();
    $fan_count = $fan_row['fan_count'] ?? 0;

    header('Content-Type: application/json');
    echo json_encode([
        'likesall' => (int)$likes_all,
        'fancount' => (int)$fan_count
    ]);
    exit;
}

if ($act === 'usercount') {
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM ".$db_prefix."_users");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    if(!empty($dumnum) && $dumnum > 1) {
        $userzsl = $count + $dumnum;
    } else {
        $userzsl = $count;
    }
    
    if ($userzsl >= 1000 && $userzsl < 10000) {
        $userqianzhui = round($userzsl / 1000, 2);
        $userhouzhui = 'k';
        $userzsl = $userqianzhui.$userhouzhui;
    } elseif ($userzsl >= 10000) {
        $userqianzhui = round($userzsl / 10000, 2);
        $userhouzhui = 'w';
        $userzsl = $userqianzhui.$userhouzhui;
    }
    
    $response = array('usercount' => strval($userzsl));
    header('Content-Type: application/json');
    $redis->setex($cacheKey, $cacheTTL, base64_encode(json_encode($response)));
    echo json_encode($response);
}


if($act=="chongzhiset"){
$data = array(
        'assetsname' => $assetsname,
        'cztext1' => $cztext1,
        'cztext2' => $cztext2,
        'cztext3' => $cztext3,
        'cztext4' => $cztext4,
        'czof1' => $czof1,
        'czof2' => $czof2,
        'czof3' => $czof3,
        'czof4' => $czof4
        
        );
$json = json_encode($data);
$redis->setex($cacheKey, $cacheTTL, base64_encode($json));

header('Content-Type: application/json');
echo $json;
exit;
}

if($act=="logininfo"){
    $response = array(
        'qqlogin' => $qqlogin,
        'wxlogin' => $wxlogin,
        'wblogin' => $wblogin
    );
    header('Content-Type: application/json');
    $redis->setex($cacheKey, $cacheTTL, base64_encode(json_encode($response)));
    echo json_encode($response);
    exit;
}

if($act=="qzxz"){
    $data = array(
        'xzcategory' => $xzcategory,
    );
    $json = json_encode($data);

    header('Content-Type: application/json');
    echo $json;
}

function userVerify($user_token = null) {
    global $api_site; 
    $api_url = $api_site . 'SFreeUsers/userVerify?token=' . $user_token;
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    if ($data['code'] == 200) {
        $jsondata2 = array(
            'uid' => $data['data']['uid'],
            'group' => $data['data']['group'],
            'isvip' => $data['data']['isvip']
        );
        $jsondata = array(
            'code' => $data['code'],
            'msg' => $data['msg'],
            'data' => $jsondata2,
        );
         return $jsondata;
    } else {
       $jsondata = array(
            'code' => $data['code'],
            'msg' => $data['msg'],
        );
        return $jsondata;
    }
}
function adminVerify($user_token = null) {
    global $api_site;
    $api_url = $api_site . 'SFreeUsers/adminVerify?token=' . $user_token;
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    if ($data['code'] == 200) {
        $jsondata2 = array(
            'uid' => $data['data']['uid'],
            'data' => $data['data']['group'],
            'isAdmin' => $data['data']['isAdmin']
        );
        $jsondata = array(
            'code' => $data['code'],
            'msg' => $data['msg'],
            'data' => $jsondata2,
        );
        return $jsondata;
        
    } else {
        $jsondata = array(
            'code' => $data['code'],
            'msg' => $data['msg'],
        );
        return $jsondata;
    }
}
?>