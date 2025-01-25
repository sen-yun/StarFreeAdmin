<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $wxpayAppId = $_POST['wxpayAppId'];
    $wxpayMchId = $_POST['wxpayMchId'];
    $mchSerialNo = $_POST['mchSerialNo'];
    $mchApiV3Key = $_POST['mchApiV3Key'];
    $wxpayKey = $_POST['wxpayKey'];
    $wxpayNotifyUrl = $_POST['wxpayNotifyUrl'];
    
    if (isset($_SESSION['loginadmin']) && $_SESSION['loginadmin'] <> '') {
        $connectRedis = new Redis();
        if (!$connectRedis->connect($redis_host, $redis_port)) {
            echo "<script>alert('连接Redis失败，请检查Config_DB.php中Redis配置');history.back();</script>";
            exit;
        }
        if (!empty($redis_password)) {
            if (!$connectRedis->auth($redis_password)) {
                echo "<script>alert('Redis认证失败，请检查Config_DB.php中的Redis密码');history.back();</script>";
                exit;
            }
        }
        $redisKeys = $connectRedis->keys($redis_prefix.'_starapi_*');
        foreach ($redisKeys as $redisKey) {
            $connectRedis->del($redisKey);
        }
        $curl = curl_init();
        
        $api_url = $API_CONFIG_UPDATE;
        $params = array(  
        'wxpayAppId' => $wxpayAppId,
        'wxpayMchId' => $wxpayMchId,
        'mchSerialNo' => $mchSerialNo,
        'mchApiV3Key' => $mchApiV3Key,
        'wxpayKey' => $wxpayKey,
        'wxpayNotifyUrl' => $wxpayNotifyUrl
        );  
        $encoded_params = urlencode(json_encode($params)); 
        $url = $api_url . '?' . 'params=' . $encoded_params . '&webkey=' . $api_key;   
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);  
  
        if ($responseData['code'] == 1) {  
            echo "<script>alert('".$responseData['msg']."');history.back();</script>";
        } else {
            echo "<script>alert('".$responseData['msg']."');history.back();</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
