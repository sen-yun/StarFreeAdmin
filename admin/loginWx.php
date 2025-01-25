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
    $wxAppId = $responseData['data']['wxAppId'];    
    $wxAppSecret = $responseData['data']['wxAppSecret'];  
    $appletsAppid = $responseData['data']['appletsAppid'];  
    $appletsSecret = $responseData['data']['appletsSecret'];  

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
                <h4 class="header-title mb-3">微信配置</h4>
                <form class="needs-validation" action="loginWxPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>在这里配置微信登录的相关信息。</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxAppId">微信应用ID录
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              可不填，负责微信APP登录
                          </span></label>
                          <input name="wxAppId" class="form-control" type="text" id="wxAppId" placeholder="请输入微信应用ID录" value="<?php echo $wxAppId; ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="wxAppSecret">微信应用Secret
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              可不填，负责微信APP登录
                          </span></label>
                          <input name="wxAppSecret" class="form-control" type="text" id="wxAppSecret" placeholder="请输入微信应用Secret" value="<?php echo $wxAppSecret;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="loginWxPost">保存修改</button>
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