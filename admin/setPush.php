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
    $pushAppId = $responseData['data']['pushAppId'];    
    $pushAppKey = $responseData['data']['pushAppKey'];  
    $pushMasterSecret = $responseData['data']['pushMasterSecret'];  
    $isPush = $responseData['data']['isPush'];

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

                <h4 class="header-title mb-3">推送配置</h4>
                <form class="needs-validation" action="setPushPost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>UniPush是DCloud 联合个推公司推出的集成型统一推送服务，配置后可实现安卓原生App的推送服务。<br>目前StarFree对接了uniPush1.0<a href="https://uniapp.dcloud.net.cn/unipush-v1.html" target="_blank">官方文档</a></p>
                    </div>
                    <div class="form-group col-sm-4">
                        <script>
                            function myOnClickHandler0(obj) {
                                var input = document.getElementById("isPush");
                                console.log(input);
                                if (obj.checked) {
                                    input.setAttribute("value", "1");
                                } else {
                                    input.setAttribute("value", "0");
                                }
                            }
                        </script>



                        <label for="validationCustom08">消息推送开关
                        <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              开启后，APP状态栏将支持推送信息。目前StarFree仅支持推送帖子、评论、订单推送，升级StarPro后将支持私信推送。
                          </span></label>
                        <?php
                        if ($isPush=='1') {
                            echo '<input type="checkbox" name="isPush" id="isPush" value="1" data-switch="success"
                               onclick="myOnClickHandler0(this)" checked>';
                        }else{
                            echo '<input type="checkbox" name="isPush" id="isPush" value="0" data-switch="success"
                               onclick="myOnClickHandler0(this)">';
                        }
                        ?>
                        
                        <label id="switchurl" style="display:block;" for="isPush" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <div class="form-group mb-3">
                          <label for="pushAppId">pushAppId</label>
                          <input name="pushAppId" class="form-control" type="text" id="pushAppId" placeholder="请输入pushAppId" value="<?php echo $pushAppId;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="pushAppKey">pushAppKey</label>
                          <input name="pushAppKey" class="form-control" type="text" id="pushAppKey" placeholder="请输入pushAppKey" value="<?php echo $pushAppKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="pushMasterSecret">pushMasterSecret</label>
                          <input name="pushMasterSecret" class="form-control" type="text" id="pushMasterSecret" placeholder="请输入pushMasterSecret" value="<?php echo $pushMasterSecret;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setPushPost">保存修改</button>
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