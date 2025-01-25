<?php
session_start();

include_once 'Menu.php';

$sql2 = "SELECT * FROM ".$db_prefix."_admin_set";
$result2 = mysqli_query($connect, $sql2);
if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
}

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
    $pushAdsPrice = $responseData['data']['pushAdsPrice'];  
    $pushAdsNum = $responseData['data']['pushAdsNum'];
    $bannerAdsPrice = $responseData['data']['bannerAdsPrice'];  
    $bannerAdsNum = $responseData['data']['bannerAdsNum'];  
    $startAdsPrice = $responseData['data']['startAdsPrice'];  
    $startAdsNum = $responseData['data']['startAdsNum'];  
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
                <h4 class="header-title mb-3">广告配置</h4>
                <form class="needs-validation" action="setAdPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <p>在这里设置付费广告位</p>
                    </div>
                    <div class="form-group mb-3">
                          <label for="pushAdsPrice">内容推流广告价格
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              （<?php echo $row2['Assetname'];  ?>/天）
                          </span></label>
                          <input name="pushAdsPrice" class="form-control" type="number" id="pushAdsPrice" placeholder="请输入内容推流广告价格" value="<?php echo $pushAdsPrice;  ?>" required>
                    </div>
                    <div class="form-group mb-3">
                          <label for="pushAdsNum">内容推流广告位数量
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              随机在帖子列表加载刷新时显示，建议数量为10
                          </span></label>
                          <input name="pushAdsNum" class="form-control" type="number" id="pushAdsNum" placeholder="请输入内容推流广告位数量" value="<?php echo $pushAdsNum;  ?>" required>
                    </div>
                    
                    <div class="form-group mb-3">
                          <label for="bannerAdsPrice">横幅广告价格
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              （<?php echo $row2['Assetname'];  ?>/天）
                          </span></label>
                          <input name="bannerAdsPrice" class="form-control" type="number" id="bannerAdsPrice" placeholder="请输入横幅广告价格" value="<?php echo $bannerAdsPrice;  ?>" required>
                    </div>
                    <div class="form-group mb-3">
                          <label for="bannerAdsNum">横幅广告位数量
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              在APP不同位置随机展现（比如帖子详情页下方），建议数量为5
                          </span></label>
                          <input name="bannerAdsNum" class="form-control" type="number" id="bannerAdsNum" placeholder="请输入横幅广告位数量" value="<?php echo $bannerAdsNum;  ?>" required>
                    </div>
                    
                     <div class="form-group mb-3">
                          <label for="startAdsPrice">启动图广告价格
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              （<?php echo $row2['Assetname'];  ?>/天）
                          </span></label>
                          <input name="startAdsPrice" class="form-control" type="number" id="startAdsPrice" placeholder="请输入横幅广告价格" value="<?php echo $startAdsPrice;  ?>" required>
                    </div>
                    <div class="form-group mb-3">
                          <label for="startAdsNum">启动图广告位数量
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              进入APP时会展现的广告，建议数量为1
                          </span></label>
                          <input name="startAdsNum" class="form-control" type="number" id="startAdsNum" placeholder="请输入横幅广告位数量" value="<?php echo $startAdsNum;  ?>" required>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setAdPost">保存修改</button>
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