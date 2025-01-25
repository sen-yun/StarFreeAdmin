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
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$responseData = json_decode($response, true);  
  
if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {  
    $alipayAppId = $responseData['data']['alipayAppId'];    
    $alipayPrivateKey = $responseData['data']['alipayPrivateKey'];  
    $alipayPublicKey = $responseData['data']['alipayPublicKey'];  
    $alipayNotifyUrl = $responseData['data']['alipayNotifyUrl'];  

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
                <h4 class="header-title mb-3">支付宝配置</h4>
                <form class="needs-validation" action="payAlipayPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>支付宝当面付是个人可用的在线支付接口，在这里配置支付宝当面付的基本信息，<a href="https://opendocs.alipay.com/open/01csp3?ref=api" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="alipayAppId">APP ID</label>
                          <input name="alipayAppId" class="form-control" type="text" id="alipayAppId" placeholder="请输入APP ID" value="<?php echo $alipayAppId;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="alipayPrivateKey">应用私钥
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              请不要存在换行
                          </span></label>
                          <textarea id="alipayPrivateKey" class="form-control" placeholder="请输入应用私钥" name="alipayPrivateKey" rows="3"><?php echo $alipayPrivateKey ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                          <label for="alipayPublicKey">支付宝公钥
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              不等于应用公钥，请不要存在换行
                          </span></label>
                          <textarea id="alipayPublicKey" class="form-control" placeholder="请输入支付宝公钥" name="alipayPublicKey" rows="3"><?php echo $alipayPublicKey ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                          <label for="alipayNotifyUrl">回调地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              示例：http://xxx.com/pay/notify 请将xxx.com部分替换为自己的API域名，需要注意区分https和http
                          </span></label>
                          <input name="alipayNotifyUrl" class="form-control" type="text" id="alipayNotifyUrl" placeholder="请输入回调地址" value="<?php echo $alipayNotifyUrl;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="payAlipayPost">保存修改</button>
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