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
    $postMax = $responseData['data']['postMax'];    
    $violationExp = $responseData['data']['violationExp'];  
    $deleteExp = $responseData['data']['deleteExp'];  
    $spaceMinExp = $responseData['data']['spaceMinExp'];  
    $chatMinExp = $responseData['data']['chatMinExp'];  
    $disableCode = $responseData['data']['disableCode'];  
    $allowDelete = $responseData['data']['allowDelete']; 
    $fields = $responseData['data']['fields'];  
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
$mb4url = $API_TO_UTF8MB4 . '?webkey=' . $api_key; 
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">其他发布设置</h4>

                <form class="needs-validation" action="setOtherPost.php" method="post" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="Utf8mb4">Utf8mb4支持
                                <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                    开启后，帖子评论等支持包含emoji表情等特殊符号，但可能会占用更多的数据库空间。
                                </span></label>
                                <div class="mt-2">
                                    <button class="btn btn-info" type="button" onclick="toMb4()">点击开启支持</button>
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group mb-3">
                                <label for="spaceMinExp">发布动态最低要求经验</label>
                                <input name="spaceMinExp" class="form-control" type="number" required="" id="spaceMinExp" placeholder="请输入发布动态最低要求经验" value="<?php echo $spaceMinExp;  ?>">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="chatMinExp">聊天最低要求经验值</label>
                                <input name="chatMinExp" class="form-control" type="number" required="" id="chatMinExp" placeholder="请输入聊天最低要求经验值" value="<?php echo $chatMinExp;  ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <script>
                                    function myOnClickHandler0(obj) {
                                        var input = document.getElementById("disableCode");
                                        console.log(input);
                                        if (obj.checked) {
                                            input.setAttribute("value", "1");
                                        } else {
                                            input.setAttribute("value", "0");
                                        }
                                    }
                                </script>
                                <label for="validationCustom08">敏感代码禁用模式
                                <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                    开启后，则发布帖子，商品，评论，都将禁用js或者嵌套代码
                                </span></label>
                                <?php
                                if ($disableCode=='1') {
                                    echo '<input type="checkbox" name="disableCode" id="disableCode" value="1" data-switch="success"
                                       onclick="myOnClickHandler0(this)" checked>';
                                }else{
                                    echo '<input type="checkbox" name="disableCode" id="disableCode" value="0" data-switch="success"
                                       onclick="myOnClickHandler0(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="disableCode" data-on-label="打开"
                                       data-off-label="关闭"></label>
                            </div>
                            
                            <div class="form-group mb-3">
                                <script>
                                    function myOnClickHandler5(obj) {
                                        var input = document.getElementById("allowDelete");
                                        console.log(input);
                                        if (obj.checked) {
                                            input.setAttribute("value", "1");
                                        } else {
                                            input.setAttribute("value", "0");
                                        }
                                    }
                                </script>
                                <label for="validationCustom08">用户删除权限
                                <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                    允许用户删除自己的内容（评论，帖子）
                                </span></label>
                                <?php
                                if ($allowDelete=='1') {
                                    echo '<input type="checkbox" name="allowDelete" id="allowDelete" value="1" data-switch="success"
                                       onclick="myOnClickHandler5(this)" checked>';
                                }else{
                                    echo '<input type="checkbox" name="allowDelete" id="allowDelete" value="0" data-switch="success"
                                       onclick="myOnClickHandler5(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="allowDelete" data-on-label="打开"
                                       data-off-label="关闭"></label>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="fields">帖子自定义字段
                                <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                    输入字段的名称，根据英文逗号","进行分割。配置后，可通过自定义字段接口为帖子设置自定义字段。
                                </span></label>
                                <input name="fields" class="form-control" type="text" required="" id="fields" placeholder="请输入帖子自定义字段" value="<?php echo $fields;  ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3" style="display: none;">
                                <label for="postMax">每日最大发布数量
                                <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                    针对帖子，动态，帖子等
                                </span></label>
                                <input name="postMax" class="form-control" type="number" required="" id="postMax" placeholder="请输入每日最大发布数量" value="<?php echo $postMax;  ?>">
                            </div>
                    <div class="form-group mb-3" style="display: none;">
                          <label for="violationExp">违规扣除经验
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              必须为整数，小于1则不扣除
                          </span></label>
                          <input name="violationExp" class="form-control" type="number" required="" id="violationExp" placeholder="请输入违规扣除经验" value="<?php echo $violationExp;  ?>">
                    </div>
                    <div class="form-group mb-3" style="display: none;">
                          <label for="deleteExp">删除扣除经验
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              删除帖子，评论，动态时扣除，必须为整数，小于1则不扣除
                          </span></label>
                          <input name="deleteExp" class="form-control" type="number" required="" id="deleteExp" placeholder="请输入删除扣除经验" value="<?php echo $deleteExp;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setOtherPost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>

<script>
    function toMb4() {
        if(confirm('确定要执行该操作吗？操作后所有内容字段开启Utf8mb4支持，此操作不可逆！')) {
            $.ajax({
                url: '<?php echo $mb4url;  ?>',
                type: 'GET',
                success: function(responseString) {
                    var response = JSON.parse(responseString);
                    if (response.code === 1) {
                        alert('操作成功');
                    } else if (response.code === 0) {
                        alert('失败: ' + response.msg);
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert('错误: ' + error);
                }
            });
        }
    }
</script>


<?php
include_once 'Footer.php';
?>

</body>
</html>