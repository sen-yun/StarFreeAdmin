<?php
session_start();
include_once 'Menu.php';

$versionFile = dirname(__DIR__) . '/version.ini';
$currentVersion = parse_ini_file($versionFile);

$curl = curl_init();
$url = $API_NEW_VERSION;
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
if (curl_errno($curl)) {
    echo "<div class='alert alert-danger'>";
    echo "CURL错误: " . curl_error($curl) . "<br>";
    echo "</div>";
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$latestVersion = array(
    'version' => '未知',
    'name' => '',
    'code' => 0
);
$versions = array();
$systemInfo = array();
$lastUpdateTime = '未知';

$responseData = json_decode($response, true);
if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {
    // 从data字段中获取数据
    $data = $responseData['data'];
    
    if (isset($data['currentVersion'])) {
        $latestVersion = $data['currentVersion'];
        $versions = $data['versions'] ?? array();
        $systemInfo = $data['systemInfo'] ?? array();
        $lastUpdateTime = $data['lastUpdateTime'] ?? '未知';
        $downloadUrl = $data['freeapiupdate'] ?? '';
        $downloadUrlApp = $data['freeapiupdateapp'] ?? '';
        // 检查是否需要更新
        $needUpdate = $currentVersion['versionCode'] < $latestVersion['code'];
        
        if ($needUpdate) {
            echo "<div class='alert alert-info'>";
            echo "发现新版本可用！建议更新到最新版本 " . $latestVersion['version'];
            echo "</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>";
    echo "API请求失败或返回数据异常<br>";
    echo "HTTP状态码: " . $httpCode . "<br>";
    echo "错误信息: " . (isset($responseData['msg']) ? $responseData['msg'] : '') . "<br>";
    echo "状态码: " . (isset($responseData['code']) ? $responseData['code'] : '无状态码') . "<br>";
    echo "原始返回数据: <pre>" . htmlspecialchars($response) . "</pre>";
    echo "</div>";
}

if (isset($_POST['auto_update']) && $needUpdate && $downloadUrl) {
    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir . '/update_' . time() . '.zip';
    
    $ch = curl_init($downloadUrl);
    $fp = fopen($tempFile, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);
    
    if ($httpCode == 200) {
        try {
            $zip = new ZipArchive;
            if ($zip->open($tempFile) === TRUE) {
                $extractPath = dirname(dirname(__FILE__)); 
                
                $zip->extractTo($extractPath);
                $zip->close();
                
                if (isset($latestVersion['version']) && isset($latestVersion['code'])) {
                    $newVersion = "version=" . $latestVersion['version'] . "\n";
                    $newVersion .= "versionCode=" . $latestVersion['code'] . "\n";
                    file_put_contents($versionFile, $newVersion);
                }
                
                echo "<div class='alert alert-success'>";
                echo "更新成功！新版本已安装完成。";
                echo "<meta http-equiv='refresh' content='2;url=" . $_SERVER['PHP_SELF'] . "'>";
                echo "</div>";
            } else {
                throw new Exception("无法打开ZIP文件");
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>";
            echo "更新失败：" . $e->getMessage();
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>下载更新包失败，HTTP状态码：" . $httpCode . "</div>";
    }
    
    @unlink($tempFile);
}

?>
<style>
    .alert-primary {
        color: #3b407f;
        background-color: #fff8fb;
        border-color: #ffa4e1;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">版本更新</h4>
                
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading">后台当前版本: <?php echo $currentVersion['version']; ?>
                        <?php if ($needUpdate && $downloadUrl){ ?>
                            【有更新】
                        <?php }else{ ?>
                            【无需更新】
                        <?php } ?> 
                    </h4>
                    <p>后台最新版本: <?php echo isset($latestVersion['version']) ? $latestVersion['version'] . ' ' . $latestVersion['name'] : '未知'; ?></p>
                    <p>最后更新时间: <?php echo isset($lastUpdateTime) ? $lastUpdateTime : '未知'; ?></p>
                    
                    <hr>
                    <p class="mb-0">
                        <form method="post" style="display: inline;">
                                
                                 <?php if ($needUpdate && $downloadUrl){ ?>
                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-2">
                                            <button type="submit" name="auto_update" class="btn btn-success w-100">
                                                <i class="mdi mdi-update mr-1"></i> 一键更新后台
                                            </button>
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <a href="<?php echo htmlspecialchars($downloadUrlApp); ?>" class="w-100">
                                                <button type="button" class="btn btn-success w-100">
                                                    <i class="mdi mdi-download mr-1"></i> 下载APP源码
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <button type="button" href="https://www.yuque.com/senyun-ev0j3/starfree/ykha04yba6hiskrx" class="btn btn-success w-100">
                                                更新教程
                                            </button>
                                        </div>
                                        <div class="col-12 col-md-6 mb-2">
                                            <a href="https://qm.qq.com/q/u6z3dCTvB6" target="_blank" class="w-100">
                                                <button type="button" class="btn btn-success w-100">
                                                    用户交流群
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="row">
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <a href="<?php echo htmlspecialchars($downloadUrlApp); ?>" class="w-100">
                                                <button type="button" class="btn btn-success w-100">
                                                    <i class="mdi mdi-download mr-1"></i> 下载APP源码
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <button type="button" href="https://www.yuque.com/senyun-ev0j3/starfree/ykha04yba6hiskrx" class="btn btn-success w-100">
                                                更新教程
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <a href="https://qm.qq.com/q/u6z3dCTvB6" target="_blank" class="w-100">
                                                <button type="button" class="btn btn-success w-100">
                                                    用户交流群
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            
                        </form>
                       <?php if ($needUpdate && $downloadUrl): ?>
                        <p class="mt-2 text-black">
                            <small>
                            更新注意事项：<br>
                            • 一键更新前如果修改过后台路径的请改回/admin 否则无法正常覆盖后台文件！<br>
                            • 一键更新仅更新StarFree后台程序<br>
                            • API更新请参考文档的更新教程<br>
                            • APP更新需手动下载源码，并重新打包<br>
                            • 更新有任何问题请看<a href="https://www.yuque.com/senyun-ev0j3/starfree/ykha04yba6hiskrx" target="_blank">更新教程</a> 或 <a href="https://qm.qq.com/q/u6z3dCTvB6" target="_blank">加交流群</a>
                            </small>
                        </p>
                         <?php endif; ?>
                    </p>
                    
                </div>

                <?php if (!empty($versions)): ?>
                <div class="timeline-alt pb-0">
                    <?php foreach ($versions as $version): ?>
                    <div class="timeline-item">
                        <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
                        <div class="timeline-item-info">
                            <h5 class="mt-0 mb-1">版本 <?php echo $version['version']; ?> <?php echo $version['name']; ?></h5>
                            <p class="font-14">发布时间: <?php echo $version['date']; ?></p>
                            <p class="text-muted mt-2 mb-0 pb-3">
                            <?php if (isset($version['changes']) && is_array($version['changes'])): ?>
                                <?php foreach ($version['changes'] as $change): ?>
                                • <?php echo $change; ?><br>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Footer.php'; ?>