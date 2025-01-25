<?php
session_start();
$file = $_SERVER['PHP_SELF'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once 'connect.php';
    $webinfoUploadUrl = $_POST['webinfoUploadUrl'];
    $uploadType = $_POST['uploadType'];
    $local = $_POST['local'];
    $localPath = $_POST['localPath'];
    $uploadLevel = $_POST['uploadLevel'];
    $uploadPicMax = $_POST['uploadPicMax'];
    $uploadMediaMax = $_POST['uploadMediaMax'];
    $uploadFilesMax = $_POST['uploadFilesMax'];
    $allowedExtensions = $_POST['allowedExtensions'];
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
        function makeApiRequest($apiUrl, $params, $apiKey) {
            $curl = curl_init();
            $encoded_params = urlencode(json_encode($params));
            $url = $apiUrl . '?' . 'params=' . $encoded_params . '&webkey=' . $apiKey;
            
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

        // 第一个API请求
        $params1 = array(  
            'webinfoUploadUrl' => $webinfoUploadUrl,
            'uploadType' => $uploadType,
            'local' => $local,
            'localPath' => $localPath,
            'uploadLevel' => $uploadLevel,
            'uploadPicMax' => (int)$uploadPicMax,
            'uploadMediaMax' => (int)$uploadMediaMax,
            'uploadFilesMax' => (int)$uploadFilesMax
        );
        $responseData = makeApiRequest($API_CONFIG_UPDATE, $params1, $api_key);

        // 第二个API请求
        $params2 = array(
            'extensions' => $allowedExtensions
        );
        $url = $API_UPDATE_ALLOWED_EXTENSIONS . '?extensions=' . urlencode($allowedExtensions) . '&webkey=' . $api_key;
        
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
        $responseData2 = json_decode($response, true);
        
        if ($responseData['code'] == 1 && $responseData2['code'] == 1) {
            echo "<script>alert('设置已更新，若修改了允许上传格式，请重启api');history.back();</script>";
        } else {
            echo "<script>alert('更新失败：上传配置返回：" . $responseData['msg'] . " 格式配置返回" . $responseData2['msg'] . "');history.back();</script>";
        }
    } else {
        echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
    }
} else {
    
    echo "<script>alert('非法操作，行为已记录');location.href = 'warning.php?route=$file';</script>";
}
?>
