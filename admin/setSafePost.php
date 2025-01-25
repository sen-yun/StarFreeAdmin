<?php
session_start();
$file = $_SERVER['PHP_SELF'];
function executeCurlRequest($url) {
    $curl = curl_init();
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
    curl_close($curl);
    return json_decode($response, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $banRobots = isset($_POST['banRobots']) ? $_POST['banRobots'] : 0;
    $silenceTime = $_POST['silenceTime'];
    $interceptTime = $_POST['interceptTime'];
    $webinfoKey = $_POST['webinfoKey'];
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
        $api_url = $API_CONFIG_UPDATE;
        $api_url2 = $API_SETUP_WEB_KEY;
        // 第一个
        $params1 = array(  
            'banRobots' => $banRobots,
            'silenceTime' => (int)$silenceTime,
            'interceptTime' => (int)$interceptTime
        );  
        $encoded_params1 = urlencode(json_encode($params1)); 
        $url1 = $api_url . '?' . 'params=' . $encoded_params1 . '&webkey=' . $api_key;   
        $responseData1 = executeCurlRequest($url1);

        // 第二个
        $params2 = array(  
            'webinfoKey' => $webinfoKey
        );  
        $encoded_params2 = urlencode(json_encode($params2)); 
        $url2 = $api_url2 . '?' . 'params=' . $encoded_params2 . '&webkey=' . $api_key;   
        $responseData2 = executeCurlRequest($url2);

        // 处理
        if ($responseData1['code'] == 1 && $responseData2['code'] == 1) {  
            echo "<script>alert('".$responseData1['msg']."，如果修改过APIKey，请重启API');history.back();</script>";
        } else {
            echo "<script>alert('error:api1=>".$responseData1['msg'].";api2=>".$responseData2['msg']."');history.back();</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
