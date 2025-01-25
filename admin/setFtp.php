<?php
session_start();

include_once 'Menu.php';

//获取配置有问题
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
    $ftpHost = $responseData['data']['ftpHost'];    
    $ftpPort = $responseData['data']['ftpPort'];  
    $ftpUsername = $responseData['data']['ftpUsername'];  
    $ftpPassword = $responseData['data']['ftpPassword'];   
    $ftpBasePath = $responseData['data']['ftpBasePath'];   
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
                <h4 class="header-title mb-3">FTP上传配置</h4>
                <form class="needs-validation" action="setFtpPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>配置远程FTP上传，部分可能不支持，和其它上传方式四选一配置即可。</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="ftpHost">FTP地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              填写域名或者IP地址，不需要ftp请求头
                          </span></label>
                          <input name="ftpHost" class="form-control" type="text" id="ftpHost" placeholder="请输入FTP地址" value="<?php echo $ftpHost;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="ftpPort">FTP端口号</label>
                          <input name="ftpPort" class="form-control" type="text" id="ftpPort" placeholder="请输入FTP端口号" value="<?php echo $ftpPort;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="ftpUsername">FTP用户名</label>
                          <input name="ftpUsername" class="form-control" type="text" id="ftpUsername" placeholder="请输入FTP用户名" value="<?php echo $ftpUsername;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="ftpPassword">FTP密码</label>
                          <input name="ftpPassword" class="form-control" type="text" id="ftpPassword" placeholder="请输入FTP密码" value="<?php echo $ftpPassword;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="ftpBasePath">FTP根目录
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              暂时只支持一级目录，如/www
                          </span></label>
                          <input name="ftpBasePath" class="form-control" type="text" id="ftpBasePath" placeholder="请输入FTP根目录" value="<?php echo $ftpBasePath;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setFtpPost">保存修改</button>
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