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
    $scale = $responseData['data']['scale'];    
    $vipPrice = $responseData['data']['vipPrice'];  
    $vipDay = $responseData['data']['vipDay'];  
    $vipDiscount = $responseData['data']['vipDiscount'];
    $isEmail = $responseData['data']['isEmail'];  
    $isInvite = $responseData['data']['isInvite'];  
    $webinfoAvatar = $responseData['data']['webinfoAvatar'];  
    $rebateLevel = $responseData['data']['rebateLevel'];  
    $rebateNum = $responseData['data']['rebateNum']; 
    $rebateProportion = $responseData['data']['rebateProportion']; 
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
                <h4 class="header-title mb-3">用户设置</h4>
                <form class="needs-validation" action="setUserPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <label for="scale">货币充值比例
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              必须为整数，一元钱等于多少货币
                          </span></label>
                          <input name="scale" class="form-control" type="number" id="scale" placeholder="请输入货币充值比例" value="<?php echo $scale;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="vipDay">多少天VIP视为永久
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              必须为整数，当用户购买VIP时间超过指定天数时，将变为永久VIP，不会过期
                          </span></label>
                          <input name="vipDay" class="form-control" type="number" id="vipDay" placeholder="请输入一天VIP价格" value="<?php echo $vipDay;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="vipDiscount">VIP折扣
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              商品价格乘以该折扣，为0.0则免费购买商品，为1.0则为原价购买。注意，商品可单独设置折扣，权重高于此设置。
                          </span></label>
                          <input name="vipDiscount" class="form-control" type="text" id="vipDiscount" placeholder="请输入VIP折扣" value="<?php echo $vipDiscount;  ?>">
                    </div>
                     <div class="form-group col-sm-4">
                    
                        <label for="validationCustom01">邮箱发信等级</label>
                            <select class="form-control" id="example-select" name="isEmail">
                                <?php
                                $regions = [
                                    "0" => "关闭邮箱功能",
                                    "1" => "注册需验证邮箱",
                                    "2" => "全局邮箱发信【全局消息提醒】"
                                ];
                                
                                foreach ($regions as $key => $value) {
                                    $selected = ($isEmail == $key) ? "selected" : "";
                                    echo "<option value=\"$key\" $selected>$value</option>";
                                }
                                ?>
                            </select>
                    </div>
                     <div class="form-group col-sm-4">
                        <script>
                            function isInvite1(obj) {
                                var input = document.getElementById("isInvite");
                                console.log(input);
                                if (obj.checked) {
                                    input.setAttribute("value", "1");
                                } else {
                                    input.setAttribute("value", "0");
                                }
                            }
                        </script>
                        <label for="validationCustom08">是否开启邀请码
                        <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              开启后，注册将必须填写后台生成的邀请码。
                          </span></label>
                        <?php
                        if ($isInvite=='1') {
                            echo '<input type="checkbox" name="isInvite" id="isInvite" value="1" data-switch="success"
                               onclick="isInvite1(this)" checked>';
                        }else{
                            echo '<input type="checkbox" name="isInvite" id="isInvite" value="0" data-switch="success"
                               onclick="isInvite1(this)">';
                        }
                        ?>
                        
                        <label style="display:block;" for="isInvite" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                     <div class="form-group mb-3">
                          <label for="webinfoAvatar">头像源avatar
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              公共头像库的源
                          </span></label>
                          <input name="webinfoAvatar" class="form-control" type="text" id="webinfoAvatar" placeholder="请输入头像源avatar" value="<?php echo $webinfoAvatar;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setUserPost">保存修改</button>
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