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
    $dataUrl = $responseData['data']['dataUrl'];    
    $dataUsername = $responseData['data']['dataUsername'];  
    $dataPassword = $responseData['data']['dataPassword'];  
    $dataPrefix = $responseData['data']['dataPrefix']; 

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

                <h4 class="header-title mb-3">Mysql设置</h4>
                <form class="needs-validation" action="setMysqlPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>设置Mysql链接和基本信息，<b>修改后需重启接口生效</b>。</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="dataUrl">Mysql链接串
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              同时包括了地址，端口和数据库名，请注意修改
                          </span></label>
                          <input name="dataUrl" class="form-control" type="text" id="dataUrl" placeholder="请输入Mysql链接串" value="<?php echo $dataUrl;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="dataUsername">Mysql用户名</label>
                          <input name="dataUsername" class="form-control" type="text" id="dataUsername" placeholder="请输入Mysql用户名" value="<?php echo $dataUsername;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="dataPassword">Mysql密码</label>
                          <input name="dataPassword" class="form-control" type="text" id="dataPassword" placeholder="请输入Mysql密码" value="<?php echo $dataPassword;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="dataPrefix">数据表前缀
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              数据表前缀，默认就是typecho，非特殊情况请勿修改
                          </span></label>
                          <input name="dataPrefix" class="form-control" type="text" id="dataPrefix" placeholder="请输入数据表前缀" value="<?php echo $dataPrefix;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setMysqlPost">保存修改</button>
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