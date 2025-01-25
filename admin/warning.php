<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8"/>
    <title>非法请求</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
</head>
<?php
function get_ip_city($ip)
{
    $ch = curl_init();
    $url = 'https://whois.pconline.com.cn/ipJson.jsp?ip=' . $ip;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $location = curl_exec($ch);
    curl_close($ch);
    $location = mb_convert_encoding($location, 'utf-8', 'GB2312');
    $location = substr($location, strlen('({') + strpos($location, '({'), (strlen($location) - strpos($location, '})')) * (-1));
    $location = str_replace('"', "", str_replace(":", "=", str_replace(",", "&", $location)));
    parse_str($location, $ip_location);
    return $ip_location['addr'];
}
$file = $_GET['route'];
include_once 'connect.php';
if ($file ){
    $ipcharu = "insert into ".$db_prefix."_admin_warning (ip,gsd,time,file) values (?,?,?,?)";
    $stmt = $connect->prepare($ipcharu);
    $stmt->bind_param("ssss", $ip, $gsd, $time, $file);
    $ip = $_SERVER["REMOTE_ADDR"];
    $gsd = get_ip_city($ip);
    $time = gmdate("Y-m-d H:i:s", time() + 8 * 3600);
    $file = $_GET['route'];
    $result = $stmt->execute();
    if (!$result) echo "错误信息：" . $stmt->error;
    $stmt->fetch();
}else{
    die ("参数错误");
}
?>

<style>
    .card {
        border-radius: 15px;
    }

    .card-header.pt-4.pb-4.text-center.bg-primary {
        border-radius: 15px 15px 0 0;
    }

    .btn-success {
        padding: 10px 25px;
        border-radius: 20px;
    }

    .info {
        margin: ;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }
</style>

<body>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="#">
                                <span style="color: #fff;font-size: 1.3rem;font-family: '宋体';font-weight: 700;">非法请求</span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="info">IP:<i style="color: #ff9b9b;"><?php echo $ip ?></i> 已记录到数据库</div>
                        </div>
                       

                    </div> 
                </div>


            </div>

        </div> 
    </div>
</div>
</div>
<footer class="footer">
    <div class="row footer_center">
        <div class="col-md-6">
            Copyright © 2025 <a href="https://starfree.qxzhi.cn" target="_blank">StarFree</a> Powered by 森云 
        </div>
    </div>
</footer>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/app.min.js"></script>
</body>

</html>