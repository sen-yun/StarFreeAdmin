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
    $qiniuDomain = $responseData['data']['qiniuDomain'];    
    $qiniuAccessKey = $responseData['data']['qiniuAccessKey'];  
    $qiniuSecretKey = $responseData['data']['qiniuSecretKey'];  
    $qiniuBucketName = $responseData['data']['qiniuBucketName'];   
    
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
                <h4 class="header-title mb-3">七牛云上传配置</h4>
                <form class="needs-validation" action="setQiniuPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>七牛云对象存储，和其它上传方式四选一配置即可，<a href="https://developer.qiniu.com/kodo" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="qiniuDomain">七牛云访问域名
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              如https://cdn.domain.com/ 【结尾要加“/”】
                          </span></label>
                          <input name="qiniuDomain" class="form-control" type="text" id="qiniuDomain" placeholder="请输入地域节点Endpoint" value="<?php echo $qiniuDomain;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="qiniuAccessKey">七牛云AccessKey</label>
                          <input name="qiniuAccessKey" class="form-control" type="text" id="qiniuAccessKey" placeholder="请输入七牛云AccessKey" value="<?php echo $qiniuAccessKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="qiniuSecretKey">七牛云SecretKey</label>
                          <input name="qiniuSecretKey" class="form-control" type="text" id="qiniuSecretKey" placeholder="请输入七牛云SecretKey" value="<?php echo $qiniuSecretKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="qiniuBucketName">存储桶名称（不能包含中文）</label>
                          <input name="qiniuBucketName" class="form-control" type="text" id="qiniuBucketName" placeholder="请输入存储桶名称" value="<?php echo $qiniuBucketName;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setQiniuPost">保存修改</button>
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