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
    $aliyunEndpoint = $responseData['data']['aliyunEndpoint'];    
    $aliyunAccessKeyId = $responseData['data']['aliyunAccessKeyId'];  
    $aliyunAccessKeySecret = $responseData['data']['aliyunAccessKeySecret'];  
    $aliyunAucketName = $responseData['data']['aliyunAucketName'];  
    $aliyunUrlPrefix = $responseData['data']['aliyunUrlPrefix'];  
    $aliyunFilePrefix = $responseData['data']['aliyunFilePrefix'];   
    
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
                <h4 class="header-title mb-3">OSS上传配置</h4>
                <form class="needs-validation" action="setOssPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>OSS为阿里云对象存储，和其它上传方式四选一配置即可,<a href="https://help.aliyun.com/zh/oss/developer-reference/description" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="aliyunEndpoint">地域节点Endpoint
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              地域节点域名：如oss-cn-beijing.aliyuncs.com
                          </span></label>
                          <input name="aliyunEndpoint" class="form-control" type="text" id="aliyunEndpoint" placeholder="请输入地域节点Endpoint" value="<?php echo $aliyunEndpoint;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="aliyunAccessKeyId">AccessKeyId</label>
                          <input name="aliyunAccessKeyId" class="form-control" type="text" id="aliyunAccessKeyId" placeholder="请输入AccessKeyId" value="<?php echo $aliyunAccessKeyId;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="aliyunAccessKeySecret">AccessKeySecret</label>
                          <input name="aliyunAccessKeySecret" class="form-control" type="text" id="aliyunAccessKeySecret" placeholder="请输入AccessKeySecret" value="<?php echo $aliyunAccessKeySecret;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="aliyunAucketName">存储桶名称BucketName</label>
                          <input name="aliyunAucketName" class="form-control" type="text" id="aliyunAucketName" placeholder="请输入存储桶名称BucketName" value="<?php echo $aliyunAucketName;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="aliyunUrlPrefix">访问地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              对象存储外网访问地址，格式为https://外网域名/，末尾记得加斜杆
                          </span></label>
                          <input name="aliyunUrlPrefix" class="form-control" type="text" id="aliyunUrlPrefix" placeholder="请输入访问地址" value="<?php echo $aliyunUrlPrefix;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="aliyunFilePrefix">文件夹名称
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              直接输入名称，不要加斜杠
                          </span></label>
                          <input name="aliyunFilePrefix" class="form-control" type="text" id="aliyunFilePrefix" placeholder="请输入文件夹名称" value="<?php echo $aliyunFilePrefix;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setOssPost">保存修改</button>
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