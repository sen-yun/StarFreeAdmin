<!DOCTYPE html>
<html lang="zh-CN">
<?php
include_once 'connect.php';
$sql = "select * from " . $db_prefix . "_admin_banip where State=? limit 1";
$stmt=$connect->prepare($sql);
$stmt->bind_param("s",$ip);
$ip = $_SERVER['REMOTE_ADDR'];
$stmt->bind_result($id,$ipAdd,$Time,$State,$text);
$result = $stmt->execute();
if(!$result) echo "错误信息：".$stmt->error;
$stmt->fetch();
$bantime = $Time;
?>
<head>
    <meta charset="utf-8"/>
    <title>您的IP已被封禁</title>
    <meta name="
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400&display=swap" rel="stylesheet">
</head>


<style>
    .card {
        border-radius: 15px;
    }

    .card-header.pt-4.pb-4.text-center.bg-primary {
        border-radius: 15px 15px 0 0;
    }

    .btn-primary {
        padding: 10px 25px;
        border-radius: 20px;
    }

    body {
        font-family: 'Noto Serif SC', serif;
        font-weight: 700;
    }

    span.badge.badge-danger-lighten {
        font-size: 1.1rem;
    }
    span.badge.badge-success-lighten {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
</style>

<body>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">

                     
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="##">
                                <span style="color: #fff;font-size: 1.3rem;font-family: '宋体';font-weight: 700;">你的IP已被封禁</span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <p class="text-muted mb-4" style="font-family: '宋体'">
                                <span class="badge badge-success-lighten">时间:
                                <?php if ($bantime) { ?><?php echo $bantime; ?><?php } else { ?>无 <?php } ?>
                                </span>
                                <span class="badge badge-danger-lighten">原因：
                                <?php if ($text) { ?><?php echo $text; ?><?php } else { ?>您的IP未被封禁 <?php } ?>
                                </span>

                            </p>
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