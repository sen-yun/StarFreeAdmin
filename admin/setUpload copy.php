<?php
session_start();
?>


<?php
include_once 'Nav.php';

//获取配置有问题
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
    $webinfoUploadUrl = $responseData['data']['webinfoUploadUrl'];    
    $uploadType = $responseData['data']['uploadType'];  
    $local = $responseData['data']['local'];  
    $localPath = $responseData['data']['localPath'];  
    $uploadLevel = $responseData['data']['uploadLevel'];  
    $uploadPicMax = $responseData['data']['uploadPicMax'];  
    $uploadMediaMax = $responseData['data']['uploadMediaMax']; 
    $uploadFilesMax = $responseData['data']['uploadFilesMax'];  
    

} 
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">上传设置</h4>

                <form class="needs-validation" action="setUploadPost.php" method="post"
                      novalidate>
                    <div class="form-group col-sm-4">
                        <label for="validationCustom01">上传模式
                        <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              除选择的外，其它模式都将关闭
                          </span></label>
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
                    <div class="form-group col-sm-4">
                        <label for="validationCustom01">文件类型上传限制</label>
                        <select class="form-control" id="example-select" name="uploadLevel">
                                <?php
                                $regions2 = [
                                    "1" => "关闭文件上传",
                                    "0" => "图片上传",
                                    "2" => "图片和视频上传",
                                    "3" => "不限制类型"
                                ];
                                
                                foreach ($regions2 as $key2 => $value2) {
                                    $selected2 = ($uploadLevel == $key2) ? "selected" : "";
                                    echo "<option value=\"$key2\" $selected2>$value2</option>";
                                }
                                ?>
                            </select>
                    </div>
                    
                    <div class="form-group mb-3">
                          <label for="webinfoUploadUrl">本地或ftp图片访问地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              例如:http(s)://img.xxx.com/ 【结尾要加“/”】
                          </span></label>
                          <input name="webinfoUploadUrl" class="form-control" type="url" id="webinfoUploadUrl" placeholder="请输入本地或ftp图片访问地址" value="<?php echo $webinfoUploadUrl;  ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="localPath">本地存储地址
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              可不填，不填为默认路径/opt/files/static，填写后即为填写地址
                          </span></label>
                          <input name="localPath" class="form-control" type="text" id="localPath" placeholder="请输入本地存储地址" value="<?php echo $localPath;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="uploadPicMax">图片最大上传大小
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              单位MB，只允许整数
                          </span></label>
                          <input name="uploadPicMax" class="form-control" required="" type="number" id="uploadPicMax" placeholder="请输入图片最大上传大小" value="<?php echo $uploadPicMax;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="uploadMediaMax">媒体最大上传大小
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              单位MB，只允许整数
                          </span></label>
                          <input name="uploadMediaMax" class="form-control" required="" type="number" id="uploadMediaMax" placeholder="请输入媒体最大上传大小" value="<?php echo $uploadMediaMax;  ?>">
                    </div>
                    <div class="form-group col-sm-4">
                          <label for="uploadFilesMax">其他文件最大上传大小
                          <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              单位MB，只允许整数
                          </span></label>
                          <input name="uploadFilesMax" class="form-control" required="" type="number" id="uploadFilesMax" placeholder="请输入其他文件最大上传大小" value="<?php echo $uploadFilesMax;  ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="setUploadPost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>


<!--<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>-->


<?php
include_once 'Footer.php';
?>

</body>
</html>