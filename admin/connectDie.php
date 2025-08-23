<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Config_DB.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8"/>
    <title>数据库连接失败</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
</head>

<style>
    .card {
        border-radius: 15px;
    }

    .card-header.pt-4.pb-4.text-center.bg-primary {
        border-radius: 15px 15px 0 0;
    }

    .bg-primary {
        background-color: #e91e63 !important;
    }

    .btn-success {
        padding: 10px 25px;
        border-radius: 20px;
    }

    .info {
        margin-bottom: 20px;
        font-size: 1rem;
    }
    .mar_top{
        margin-top: 20px;
    }
    .btn-success{
        border-radius: 20px;
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
                                <span
                                        style="color: #fff;font-size: 1.3rem;font-family: '宋体';font-weight: 700;">数据库连接失败</span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="info">请检查数据库信息是否配置正确</div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <div class="mar_top">
                                <a href="../admin">
                                    <button
                                            class="btn btn-success" type="submit"> 跳转登录
                                    </button>
                                </a>
                            </div>
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
<script>
    Copyright © 2025 <a href="https://starfree.qxzhi.cn" target="_blank">StarFree</a> Powered by 森云
</script>
<script src="../Style/jquery/jquery.min.js"></script>
<script src="../Style/pagelir/spotlight.bundle.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/app.min.js"></script>
</body>

</html>

