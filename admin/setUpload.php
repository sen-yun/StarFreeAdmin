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

// 第二个API请求
$curl2 = curl_init();
$url2 = $API_ALL_CONFIG.'?webkey='.$api_key;
curl_setopt_array($curl2, array(
   CURLOPT_URL => $url2,
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

$response2 = curl_exec($curl2);
$responseData2 = json_decode($response2, true);

if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {  
    $webinfoUploadUrl = $responseData['data']['webinfoUploadUrl'];    
    $uploadType = $responseData['data']['uploadType'];  
    $local = $responseData['data']['local'];  
    $localPath = $responseData['data']['localPath'];  
    $uploadLevel = $responseData['data']['uploadLevel'];  
    $uploadPicMax = $responseData['data']['uploadPicMax'];  
    $uploadMediaMax = $responseData['data']['uploadMediaMax']; 
    $uploadFilesMax = $responseData['data']['uploadFilesMax'];  
    
    if($responseData2 && isset($responseData2['code']) && $responseData2['code'] == 1) {
        $allowedExtensions = $responseData2['data']['allowedExtensions'];
    }
    
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
                <h4 class="header-title mb-3">上传设置</h4>

                <form class="needs-validation" action="setUploadPost.php" method="post" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validationCustom01">上传模式
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        除选择的外，其它模式都将关闭
                                    </span>
                                </label>
                                <select class="form-control" id="example-select" name="uploadType">
                                    <?php
                                    $regions = [
                                        "local" => "本地上传",
                                        "cos" => "腾讯云COS",
                                        "oss" => "阿里云OSS",
                                        "qiniu" => "七牛存储",
                                        "ftp" => "远程FTP"
                                    ];
                                    foreach ($regions as $key => $value) {
                                        $selected = ($uploadType == $key) ? "selected" : "";
                                        echo "<option value=\"$key\" $selected>$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="webinfoUploadUrl">图片访问地址【本地、ftp、七牛模式都要填】
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        例:http(s)://img.xx.com/ 【结尾要加"/"】
                                    </span>
                                </label>
                                <input name="webinfoUploadUrl" class="form-control" type="url" id="webinfoUploadUrl" 
                                    placeholder="请输入本地或ftp图片访问地址" value="<?php echo $webinfoUploadUrl; ?>">
                            </div>

                            <div class="form-group">
                                <label for="localPath">本地存储地址【程序多开时建议修改】
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        可不填，不填为默认路径/opt/starfree/files/static，填写后即为填写地址
                                    </span>
                                </label>
                                <input name="localPath" class="form-control" type="text" id="localPath" 
                                    placeholder="请输入本地存储地址" value="<?php echo $localPath; ?>">
                            </div>

                            <div class="form-group">
                                <label for="validationCustom01">文件类型上传限制</label>
                                <select class="form-control" id="example-select" name="uploadLevel">
                                    <?php
                                    $regions2 = [
                                        "1" => "关闭文件上传",
                                        "0" => "图片上传",
                                        "2" => "图片和视频上传",
                                        "3" => "自定义允许的格式"
                                    ];
                                    foreach ($regions2 as $key2 => $value2) {
                                        $selected2 = ($uploadLevel == $key2) ? "selected" : "";
                                        echo "<option value=\"$key2\" $selected2>$value2</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notice">允许上传的文件格式
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        上传不限制文件类型时生效。根据英文逗号","进行分割，不要存在换行或者空格。
                                    </span>
                                </label>
                                <textarea id="notice" class="form-control" placeholder="请输入允许上传的文件格式（可留空）" 
                                    name="allowedExtensions" rows="3"><?php echo $allowedExtensions ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="uploadPicMax">图片最大上传大小
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        单位MB，只允许整数
                                    </span>
                                </label>
                                <input name="uploadPicMax" class="form-control" required="" type="number" 
                                    id="uploadPicMax" placeholder="请输入图片最大上传大小" value="<?php echo $uploadPicMax; ?>">
                            </div>

                            <div class="form-group">
                                <label for="uploadMediaMax">媒体最大上传大小
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        单位MB，只允许整数
                                    </span>
                                </label>
                                <input name="uploadMediaMax" class="form-control" required="" type="number" 
                                    id="uploadMediaMax" placeholder="请输入媒体最大上传大小" value="<?php echo $uploadMediaMax; ?>">
                            </div>

                            <div class="form-group">
                                <label for="uploadFilesMax">其他文件最大上传大小
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        单位MB，只允许整数
                                    </span>
                                </label>
                                <input name="uploadFilesMax" class="form-control" required="" type="number" 
                                    id="uploadFilesMax" placeholder="请输入其他文件最大上传大小" value="<?php echo $uploadFilesMax; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group text_right">
                        <button class="btn btn-success" type="submit" id="setUploadPost">保存修改</button>
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