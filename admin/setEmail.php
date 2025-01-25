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
    $mailHost = $responseData['data']['mailHost'];    
    $mailUsername = $responseData['data']['mailUsername'];  
    $mailPassword = $responseData['data']['mailPassword'];  
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

                <h4 class="header-title mb-3">邮箱发信设置</h4>
                <form class="needs-validation" action="setEmailPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>设置基于SMTP协议的邮箱发信，<b>修改后需重启接口生效</b>。不知道邮箱怎么配置的，参考<a href="https://www.cnblogs.com/chenxiaomeng/p/13266941.html" target="_blank">常见的SMTP邮箱配置教程</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="mailHost">邮件Host
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              请根据所选择发件平台获取
                          </span></label>
                          <input name="mailHost" class="form-control" type="text" id="mailHost" placeholder="请输入邮件Host" value="<?php echo $mailHost;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="mailUsername">发信邮箱</label>
                          <input name="mailUsername" class="form-control" type="text" id="mailUsername" placeholder="请输入发信邮箱" value="<?php echo $mailUsername;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="mailPassword">发信授权码
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              请根据所选择发件平台获取
                          </span></label>
                          <input name="mailPassword" class="form-control" type="text" id="mailPassword" placeholder="请输入发信授权码" value="<?php echo $mailPassword;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setEmailPost">保存修改</button>
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