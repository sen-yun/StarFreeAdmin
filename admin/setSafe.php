<?php
session_start();
include_once 'Menu.php';
$url1 = $API_GET_API_CONFIG . '?webkey=' . $api_key;
$responseData1 = executeCurlRequestapi($url1);

// 第二个 cURL 请求
$url2 = $API_ALL_CONFIG.'?webkey='.$api_key;
$responseData2 = executeCurlRequestapi($url2);

function executeCurlRequestapi($url) {
    $curl = curl_init();
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
    curl_close($curl);
    return json_decode($response, true);
}
if (isset($responseData1['code']) && $responseData1['code'] == "1") {  
    $banRobots = $responseData1['data']['banRobots'];    
    $silenceTime = $responseData1['data']['silenceTime'];  
    $interceptTime = $responseData1['data']['interceptTime'];  
    $verifyLevel = $responseData1['data']['verifyLevel'];  
    
}elseif($responseData1['msg']=='请输入正确的访问key'){
    echo "<div class='alert alert-danger'>";
    echo "Star后台Config_DB.php文件的ApiKey错误<br>";
    echo "</div>";
}else {
    echo "<div class='alert alert-danger'>";
    echo "API请求失败或返回数据异常<br>";
    echo "错误信息: " . (isset($responseData1['msg']) ? $responseData['msg'] : '未知错误') . "<br>";
    echo "状态码: " . (isset($responseData1['code']) ? $responseData['code'] : '无状态码') . "<br>";
    echo "返回数据: " . ($response ? $response : '无返回数据')."<br>";
    echo "你配置的API站点：".$api_site."<br>";
    echo "你的后台站点：" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/<br>";
    echo "请确保API站点和后台站点的SSL协议一致！并且API站点后缀以“/”结尾";
    echo "</div>";
}
if (isset($responseData2['code']) && $responseData2['code'] == "1") {  
    $webinfoKey = $responseData2['data']['webinfoKey'];  
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">安全设置</h4>

                <form class="needs-validation" action="setSafePost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <label for="webinfoKey">APIKey
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              APIKey修改后，<b>需重启接口生效</b>
                          </span></label>
                          <input name="webinfoKey" class="form-control" type="text" id="webinfoKey" placeholder="请输入APIKey" required="" value="<?php echo $webinfoKey;  ?>">
                    </div>
                    <div class="form-group mb-3">
                    <script>
                        function banRobots1(obj) {
                            var input = document.getElementById("banRobots");
                            if (obj.checked) {
                                input.value = "1";
                            } else {
                                input.value = "0";
                            }
                        }
                    </script>
                    <label for="validationCustom01">机器人限制模式
                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              开启后，将对疑似非人类行为进行拦截和通知
                          </span></label>
                    <?php
                    if ($banRobots=="1") {
                        echo '<input type="checkbox" name="banRobots" id="banRobots" value="1" data-switch="success"
                           onclick="banRobots1(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="banRobots" id="banRobots" value="0" data-switch="success"
                           onclick="banRobots1(this)">';
                    }
                    ?>
                    <label id="switchurl" style="display:block;" for="banRobots" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                    <div class="form-group mb-3">
                          <label for="silenceTime">疑似攻击自动封禁时间
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              单位秒，当用户疑似进行攻击行为时，进行封禁
                          </span></label>
                          <input name="silenceTime" class="form-control" type="number" id="silenceTime" placeholder="请输入本地存储地址" required="" value="<?php echo $silenceTime;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="interceptTime">多次触发违规自动封禁时间
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              单位秒，当用户疑多次触发违规词时，进行封禁
                          </span></label>
                          <input name="interceptTime" class="form-control" type="number" id="interceptTime" placeholder="请输入本地存储地址" required="" value="<?php echo $interceptTime;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setSafePost">保存修改</button>
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