<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $Auditurl = isset($_POST['Auditurl']) ? $_POST['Auditurl'] : '';
    $Waiterurl = isset($_POST['Waiterurl']) ? $_POST['Waiterurl'] : '';
    $Groupurl = isset($_POST['Groupurl']) ? $_POST['Groupurl'] : '';
    $Share = isset($_POST['Share']) ? $_POST['Share'] : 0;
    $Tipping = isset($_POST['Tipping']) ? $_POST['Tipping'] : 0;
    $Payswith = isset($_POST['Payswith']) ? $_POST['Payswith'] : 0;
    $Alipay = isset($_POST['Alipay']) ? $_POST['Alipay'] : 0;
    $WePay = isset($_POST['WePay']) ? $_POST['WePay'] : 0;
    $Cami = isset($_POST['Cami']) ? $_POST['Cami'] : 0;
    $Yipay = isset($_POST['Yipay']) ? $_POST['Yipay'] : 0;
    $Tippingstyle = isset($_POST['Tippingstyle']) ? $_POST['Tippingstyle'] : '';
    $Assetname = isset($_POST['Assetname']) ? $_POST['Assetname'] : '';
    $Withdrawals = isset($_POST['Withdrawals']) ? $_POST['Withdrawals'] : '';
    $Threshold = isset($_POST['Threshold']) ? $_POST['Threshold'] : '';
    $Premium = isset($_POST['Premium']) ? $_POST['Premium'] : '';
    $Qlogin = isset($_POST['Qlogin']) ? $_POST['Qlogin'] : 0;
    $h5of = isset($_POST['h5of']) ? $_POST['h5of'] : 0;
    $wxlogin = isset($_POST['wxlogin']) ? $_POST['wxlogin'] : 0;
    $wblogin = isset($_POST['wblogin']) ? $_POST['wblogin'] : 0; 
    //api
    $postMax = $_POST['postMax'];
    $webinfoTitle = $_POST['webinfoTitle'];
    $isLogin = isset($_POST['isLogin']) && $_POST['isLogin'] == 1 ? true : false;  
       
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
        $query = "UPDATE ".$db_prefix."_admin_set SET Auditurl=?, Waiterurl=?, Groupurl=?, Share=?, Tipping=?, Payswith=?, Alipay=?, WePay=?, Cami=?, Yipay=?, Tippingstyle=?, Assetname=?, Withdrawals=?, Threshold=?, Premium=?, Qlogin=?, h5of=?, wxlogin=?, wblogin=?";
        $stmt = $connect->prepare($query);
        //api
        $curl = curl_init();
        $api_url = $API_CONFIG_UPDATE;
        $params = array(  
        'postMax' => $postMax,
        'webinfoTitle' => $webinfoTitle
        );  
        $encoded_params = urlencode(json_encode($params)); 
        $url = $api_url . '?' . 'params=' . $encoded_params . '&webkey=' . $api_key;   
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
        $responseData = json_decode($response, true);

        if ($stmt) {
            $stmt->bind_param("sssiiiiiiisssssiiii", 
                $Auditurl, $Waiterurl, $Groupurl, 
                $Share, $Tipping, $Payswith, $Alipay, 
                $WePay, $Cami, $Yipay, $Tippingstyle, 
                $Assetname, $Withdrawals, $Threshold, 
                $Premium, $Qlogin, $h5of, $wxlogin, $wblogin);

            if ($stmt->execute() && isset($responseData['code']) && $responseData['code'] == 1) {
                echo "<script>alert('更改成功');location.href = 'settings.php';</script>";
            } else {
                $apiError = isset($responseData['msg']) ? $responseData['msg'] : '未知错误';
                echo "<script>alert('更改失败，API错误：" . $apiError . "');location.href = 'settings.php';</script>";
            }
            $stmt->close();
        } else {
            $error = mysqli_error($connect);
            die('请联系开发者，错误信息：' . $error);
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
