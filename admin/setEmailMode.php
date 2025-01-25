<?php
session_start();

include_once 'Menu.php';

// 第一个
$url1 = $API_GET_EMAIL_TEMPLATE_CONFIG . '?webkey=' . $api_key;
$responseData1 = executeCurlRequestapi($url1);

// 第二个
$url2 = $API_GET_API_CONFIG.'?webkey='.$api_key;
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
    $orderTemplate = $responseData1['data']['orderTemplate'];    
    $replyTemplate = $responseData1['data']['replyTemplate'];  
    $reviewTemplate = $responseData1['data']['reviewTemplate'];  
    $safetyTemplate = $responseData1['data']['safetyTemplate'];  
    $verifyTemplate = $responseData1['data']['verifyTemplate'];  
    
}
if (isset($responseData2['code']) && $responseData2['code'] == "1") {  
    $webinfoUrl = $responseData2['data']['webinfoUrl'];  
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">邮件模板配置</h4>
                <form class="needs-validation" action="setEmailModePost.php" method="post"
                      novalidate>
                     <div class="form-group mb-3">
                          <p>配置全站的邮件发信页面显示模板，支持HTML代码内容，支持远程图片。</p>
                    </div>
                     
                     <div class="form-group mb-3">
                          <label for="webinfoUrl">邮件中的站点地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              邮件中点击转跳地址，可以填官网、H5、web端地址
                          </span></label>
                          <input name="webinfoUrl" class="form-control" type="text" id="webinfoUrl" placeholder="请输入站点地址" value="<?php echo $webinfoUrl;  ?>">
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">订单通知邮件模板</label>
                      <textarea id="notice" class="form-control" placeholder="请输入内容" name="orderTemplate" rows="4"><?php echo $orderTemplate ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">评论&回复邮件模板</label>
                      <textarea id="notice" class="form-control" placeholder="请输入内容" name="replyTemplate" rows="4"><?php echo $replyTemplate ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">安全通知邮件模板</label>
                      <textarea id="notice" class="form-control" placeholder="请输入内容" name="reviewTemplate" rows="4"><?php echo $reviewTemplate ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">审核通知邮件模板</label>
                      <textarea id="notice" class="form-control" placeholder="请输入内容" name="safetyTemplate" rows="4"><?php echo $safetyTemplate ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">验证码邮件模板</label>
                      <textarea id="notice" class="form-control" placeholder="请输入内容" name="verifyTemplate" rows="4"><?php echo $verifyTemplate ?></textarea>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setEmailModePost">保存修改</button>
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