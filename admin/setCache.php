<?php
session_start();
include_once 'Menu.php';

//获取配置有问题
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
    $usertime = $responseData['data']['usertime'];    
    $contentCache = $responseData['data']['contentCache'];  
    $contentInfoCache = $responseData['data']['contentInfoCache'];  
    $CommentCache = $responseData['data']['CommentCache']; 
    $userCache = $responseData['data']['userCache']; 

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

                <h4 class="header-title mb-3">缓存配置</h4>
                <form class="needs-validation" action="setRedisPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>配置API各模块数据的Redis缓存时间，<b>修改后需重启接口生效</b>。</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="usertime">用户登录状态持续时间（s）</label>
                          <input name="usertime" class="form-control" type="number" id="usertime" placeholder="请输入用户登录状态持续时间" value="<?php echo $usertime;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="contentCache">内容列表缓存时间（s）</label>
                          <input name="contentCache" class="form-control" type="number" id="contentCache" placeholder="请输入内容列表缓存时间" value="<?php echo $contentCache;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="contentInfoCache">内容详情缓存时间（s）</label>
                          <input name="contentInfoCache" class="form-control" type="number" id="contentInfoCache" placeholder="请输入内容详情缓存时间" value="<?php echo $contentInfoCache;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="CommentCache">评论列表缓存时间（s）</label>
                          <input name="CommentCache" class="form-control" type="number" id="CommentCache" placeholder="请输入评论列表缓存时间" value="<?php echo $CommentCache;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="userCache">用户列表缓存时间（s）</label>
                          <input name="userCache" class="form-control" type="number" id="userCache" placeholder="请输入用户列表缓存时间" value="<?php echo $userCache;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setRedisPost">保存修改</button>
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