<?php
session_start();
include_once 'Menu.php';

$curl = curl_init();
$url = $API_VIP_TYPE_LIST.'?webkey='.$api_key;
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

if($responseData['msg']=='请输入正确的访问key'){
    echo "<div class='alert alert-danger'>";
    echo "Star后台Config_DB.php文件的ApiKey错误<br>";
    echo "</div>";
}else if(!$responseData || !isset($responseData['code']) || $responseData['code'] != 1) {
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

<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css"/>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">VIP套餐<a class="fabu" href="vipAdd.php">
                        <button type="button" class="btn btn-success2 btn-sm btn-rounded right_10">
                            <i class="dripicons-upload"></i> 创建
                        </button>
                    </a></h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>套餐名称</th>
                        <th>套餐价格</th>
                        <th>购买天数</th>
                        <th>赠送天数</th>
                        <th style="width: 125px;">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                     foreach ($responseData['vip'] as $app) {
                    ?>
                    <tr>
                        <td><?php echo $app['name']; ?></td> 
                        <td><?php echo $app['price']; ?></td> 
                        <td><?php echo $app['day']."天"; ?></td> 
                        <td><?php echo $app['giftDay']."天"; ?></td> 
                        <td>
                            <a href="vipEdit.php?id=<?php echo $app['id']; ?>&name=<?php echo $app['name']; ?>&price=<?php echo $app['price']; ?>&day=<?php echo $app['day']; ?>&giftDay=<?php echo $app['giftDay']; ?>&intro=<?php echo $app['intro']; ?>">
                                <button style="white-space: nowrap;" type="button" class="btn btn-info btn-rounded">
                                    <i class="dripicons-document-edit"></i> 编辑
                                </button>
                            </a>
                            <a href="javascript:del('<?php echo $app['name']; ?>', '<?php echo $app['id']; ?>');">
                                <button style="white-space: nowrap;" type="button" class="btn btn-danger btn-rounded">
                                    <i class="mdi mdi-delete-empty mr-1"></i>删除
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>  
        </div>  
    </div> 
</div>


<script>
    function del(name,id) {
        if (confirm('您确认要删除' + name + '套餐吗？')) {
            location.href = 'vipDel.php?id=' + id;
        }
    }
</script>


<?php
include_once 'Footer.php';
?>

<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/dataTables.bootstrap4.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/buttons.html5.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/buttons.flash.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/buttons.print.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/dataTables.select.min.js"></script>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/pages/demo.datatable-init.js"></script>

</body>
</html>