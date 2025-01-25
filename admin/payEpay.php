<?php
session_start();

include_once 'Menu.php';

$curl = curl_init();
$url = $API_GET_API_CONFIG.'?webkey='.$api_key;
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
    $epayUrl = $responseData['data']['epayUrl'];    
    $epayPid = $responseData['data']['epayPid'];  
    $epayKey = $responseData['data']['epayKey'];  
    $epayNotifyUrl = $responseData['data']['epayNotifyUrl'];  
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
                <h4 class="header-title mb-3">易支付配置</h4>
                <form class="needs-validation" action="payEpayPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>易支付接口可支持所有核心程序为彩虹易支付的第三方支付平台。不过，为了财产安全，对于非官方的支付渠道，请谨慎选择。<br />注意：目前仅支持对接易支付SDK版本为1.2及以下的系统</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="epayUrl">易支付接口地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              输入易支付平台的接口地址
                          </span></label>
                          <input name="epayUrl" class="form-control" type="text" id="epayUrl" placeholder="请输入易支付接口地址" value="<?php echo $epayUrl;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="epayPid">易支付商户ID</label>
                          <input name="epayPid" class="form-control" type="text" id="epayPid" placeholder="请输入易支付商户ID" value="<?php echo $epayPid;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="epayKey">易支付商户密钥</label>
                          <input name="epayKey" class="form-control" type="text" id="epayKey" placeholder="请输入易支付商户密钥" value="<?php echo $epayKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="epayNotifyUrl">易支付回调地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              示例：http://xxx.com/pay/EPayNotify 请将xxx.com部分替换为自己的API域名，需要注意区分https和http
                          </span></label>
                          <input name="epayNotifyUrl" class="form-control" type="text" id="epayNotifyUrl" placeholder="请输入回调地址" value="<?php echo $epayNotifyUrl;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="payEpayPost">保存修改</button>
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