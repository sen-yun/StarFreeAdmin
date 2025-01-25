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
    $cosAccessKey = $responseData['data']['cosAccessKey'];    
    $cosSecretKey = $responseData['data']['cosSecretKey'];  
    $cosBucket = $responseData['data']['cosBucket'];  
    $cosBucketName = $responseData['data']['cosBucketName'];  
    $cosPath = $responseData['data']['cosPath'];  
    $cosPrefix = $responseData['data']['cosPrefix'];   
    
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
                <h4 class="header-title mb-3">COS上传配置</h4>

                <form class="needs-validation" action="setCosPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>COS为腾讯云对象存储，和其它上传方式四选一配置即可,<a href="https://cloud.tencent.com/document/product/436/7751" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="cosAccessKey">AccessKey</label>
                          <input name="cosAccessKey" class="form-control" type="text" id="cosAccessKey" placeholder="请输入AccessKey" value="<?php echo $cosAccessKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="cosSecretKey">SecretKey</label>
                          <input name="cosSecretKey" class="form-control" type="text" id="cosSecretKey" placeholder="请输入SecretKey" value="<?php echo $cosSecretKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="cosBucket">地域节点Bucket<span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              地域节点：如ap-guangzhou
                          </span></label>
                          <input name="cosBucket" class="form-control" type="text" id="cosBucket" placeholder="请输入地域节点Bucket" value="<?php echo $cosBucket;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="cosBucketName">存储桶名称BucketName</label>
                          <input name="cosBucketName" class="form-control" type="text" id="cosBucketName" placeholder="请输入存储桶名称BucketName" value="<?php echo $cosBucketName;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="cosPath">访问地址Path
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              对象存储外网访问地址，格式为https://外网域名，【末尾不要加斜杆】
                          </span></label>
                          <input name="cosPath" class="form-control" type="text" id="cosPath" placeholder="请输入访问地址Path" value="<?php echo $cosPath;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="cosPrefix">文件夹名称
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              直接输入名称（建议纯英文），不要加斜杠
                          </span></label>
                          <input name="cosPrefix" class="form-control" type="text" id="cosPrefix" placeholder="请输入文件夹名称" value="<?php echo $cosPrefix;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setCosPost">保存修改</button>
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