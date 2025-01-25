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
    $forumAudit = $responseData['data']['forumAudit'];    
    $forumReplyAudit = $responseData['data']['forumReplyAudit'];  
    $spaceAudit = $responseData['data']['spaceAudit'];  
    $auditlevel = $responseData['data']['auditlevel'];  
    $contentAuditlevel = $responseData['data']['contentAuditlevel'];  
    $forbidden = $responseData['data']['forbidden'];
    $fields = $responseData['data']['fields'];  
    $disableCode = $responseData['data']['disableCode'];  
    $allowDelete = $responseData['data']['allowDelete'];  
    $identifylvPost = $responseData['data']['identifylvPost'];  
    $identifysmPost = $responseData['data']['identifysmPost']; 

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
                <h4 class="header-title mb-3">审核设置</h4>

                <form class="needs-validation" action="setAuditPost.php" method="post"
                      novalidate>
                     <div class="form-group col-sm-4">
                        <label for="validationCustom01">帖子审核</label>
                        <select class="form-control" id="example-select" name="contentAuditlevel">
                            <option value="0" <?php echo $contentAuditlevel == 0 ? 'selected' : ''; ?>>直接发布</option>
                            <option value="1" <?php echo $contentAuditlevel == 1 ? 'selected' : ''; ?>>违禁词匹配审核</option>
                            <option value="2" <?php echo $contentAuditlevel == 2 ? 'selected' : ''; ?>>全部审核</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="validationCustom01">帖子评论审核</label>
                        <select class="form-control" id="example-select" name="auditlevel">
                            <option value="0" <?php echo $auditlevel == 0 ? 'selected' : ''; ?>>直接发布</option>
                            <option value="1" <?php echo $auditlevel == 1 ? 'selected' : ''; ?>>第一次评论审核</option>
                            <option value="2" <?php echo $auditlevel == 2 ? 'selected' : ''; ?>>违禁词匹配审核</option>
                            <option value="3" <?php echo $auditlevel == 3 ? 'selected' : ''; ?>>违禁词匹配拦截</option>
                            <option value="4" <?php echo $auditlevel == 4 ? 'selected' : ''; ?>>全部审核</option>
                        </select>
                    </div>
                     <div class="form-group mb-3">
                      <label for="notice">违禁词
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              用于帖子、帖子评论、个性签名拦截。根据英文逗号”,“进行分割，不要存在换行或者空格。
                          </span></label>
                      <textarea id="notice" class="form-control" placeholder="请输入违禁词（可留空）" name="forbidden" rows="3"><?php echo $forbidden ?></textarea>
                    </div>
                    <div class="form-group col-sm-4">
                        <script>
                            function myOnClickHandler3(obj) {
                                var input = document.getElementById("spaceAudit");
                                console.log(input);
                                if (obj.checked) {
                                    input.setAttribute("value", "1");
                                } else {
                                    input.setAttribute("value", "0");
                                }
                            }
                        </script>
                        <label for="validationCustom08">动态审核</label>
                        <?php
                        if ($spaceAudit=='1') {
                            echo '<input type="checkbox" name="spaceAudit" id="spaceAudit" value="1" data-switch="success"
                               onclick="myOnClickHandler3(this)" checked>';
                        }else{
                            echo '<input type="checkbox" name="spaceAudit" id="spaceAudit" value="0" data-switch="success"
                               onclick="myOnClickHandler3(this)">';
                        }
                        ?>
                        
                        <label id="switchurl" style="display:block;" for="spaceAudit" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setAuditPost">保存修改</button>
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