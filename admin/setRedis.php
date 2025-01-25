<?php
session_start();
include_once 'Menu.php';


$curl = curl_init();
$url = $API_ALL_CONFIG.'?webkey='.$api_key;
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
$responseData = json_decode($response, true);  
if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {  
    $redisHost = $responseData['data']['redisHost'];    
    $redisPassword = $responseData['data']['redisPassword'];  
    $redisPort = $responseData['data']['redisPort'];  
    $redisPrefix = $responseData['data']['redisPrefix']; 

}elseif($responseData['msg']=='请输入正确的访问key'){
    echo "<div class='alert alert-danger'>";
    echo "Star后台Config_DB.php文件的ApiKey错误<br>";
    echo "</div>";
}else {
    echo "<div class='alert alert-danger'>";
    echo "API请求失败或返回数据异常<br>";
    echo "错误信息: " . (isset($responseData['msg']) ? $responseData['msg'] : '未知错误') . "<br>";
    echo "状态码: " . (isset($responseData['code']) ? $responseData['code'] : '无状态码') . "<br>";
    echo "返回数据: " . ($response ? $response : '无返回数据')."<br>";
    echo "你配置的API站点：".$api_site."<br>";
    echo "你的后台站点：" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/<br>";
    echo "请确保API站点和后台站点的SSL协议一致！并且API站点后缀以“/”结尾";
    echo "</div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-3">Redis设置</h4>
                <form class="needs-validation" action="setRedisPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>Redis用于验证用户登录状态，缓存低更新率数据，<b>修改后需重启接口生效</b>。</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="redisHost">Redis地址</label>
                          <input name="redisHost" class="form-control" type="text" id="redisHost" placeholder="请输入Redis地址" value="<?php echo $redisHost;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="redisPassword">Redis密码</label>
                          <input name="redisPassword" class="form-control" type="text" id="redisPassword" placeholder="请输入Redis密码" value="<?php echo $redisPassword;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="redisPort">Redis端口</label>
                          <input name="redisPort" class="form-control" type="text" id="redisPort" placeholder="请输入Redis端口" value="<?php echo $redisPort;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="redisPrefix">Redis数据前缀
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              防止数据紊乱，非特殊情况请勿设置
                          </span></label>
                          <input name="redisPrefix" class="form-control" type="text" id="redisPrefix" placeholder="请输入Redis数据前缀" value="<?php echo $redisPrefix;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setRedisPost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>


<?php
include_once 'Footer.php';
?>

</body>
</html>