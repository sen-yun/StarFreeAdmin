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
    $wxpayAppId = $responseData['data']['wxpayAppId'];    
    $wxpayMchId = $responseData['data']['wxpayMchId'];  
    $mchSerialNo = $responseData['data']['mchSerialNo'];  
    $wxpayKey = $responseData['data']['wxpayKey'];  
    $mchApiV3Key = $responseData['data']['mchApiV3Key'];  
    $wxpayNotifyUrl = $responseData['data']['wxpayNotifyUrl'];  

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
                <h4 class="header-title mb-3">微信支付配置</h4>
                <form class="needs-validation" action="payWxpayPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>微信支付是微信官方提供的支付接口，目前采用Native模式生成二维码并唤醒微信，<a href="https://pay.weixin.qq.com/wiki/doc/apiv3/open/pay/chapter2_7_2.shtml" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxpayAppId">公众号APP Id</label>
                          <input name="wxpayAppId" class="form-control" type="text" id="wxpayAppId" placeholder="请输入公众号APP Id" value="<?php echo $wxpayAppId;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxpayMchId">商户号</label>
                          <input name="wxpayMchId" class="form-control" type="text" id="wxpayMchId" placeholder="请输入商户号" value="<?php echo $wxpayMchId;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="mchSerialNo">商户证书序列号</label>
                          <input name="mchSerialNo" class="form-control" type="text" id="mchSerialNo" placeholder="请输入商户证书序列号" value="<?php echo $mchSerialNo;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxpayKey">支付密钥
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              支付密钥，证书的***key.pem文件内容
                          </span></label>
                          <textarea id="wxpayKey" class="form-control" placeholder="请输入支付密钥" name="wxpayKey" rows="3"><?php echo $wxpayKey ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                          <label for="mchApiV3Key">API3私钥</label>
                          <textarea id="mchApiV3Key" class="form-control" placeholder="请输入API3私钥" name="mchApiV3Key" rows="3"><?php echo $mchApiV3Key ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxpayNotifyUrl">回调地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              示例：http://xxx.com/pay/wxPayNotify 请将xxx.com部分替换为自己的API域名，需要注意区分https和http
                          </span></label>
                          <input name="wxpayNotifyUrl" class="form-control" type="text" id="wxpayNotifyUrl" placeholder="请输入回调地址" value="<?php echo $wxpayNotifyUrl;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="payWxpayPost">保存修改</button>
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