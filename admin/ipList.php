<?php
session_start();
include_once 'Menu.php';

$ipkiki = "select * from " . $db_prefix . "_admin_ip order by id desc";
$ipki = mysqli_query($connect, $ipkiki);
?>


<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css"/>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">后台登录日志<a class="fabu" onclick="deleteAll()">
                        <button type="button" class="btn btn-success2 btn-sm btn-rounded right_10">
                            <i class="mdi mdi-delete-empty mr-1"></i>清空
                        </button>
                    </a></h4>
                
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>IP归属地</th>
                        <th>登录时间</th>
                        <th>IP</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ($IPinfo = mysqli_fetch_array($ipki)) {
                        ?>
                        <tr>
                            <td><?php echo $IPinfo['ipAdd'] ?></td>
                            <td>
                                <small class="text-muted"><?php echo $IPinfo['Time'] ?></small>
                            </td>
                            <td>
                                <h5>
                                    <span class="badge badge-danger-lighten"><?php if ($IPinfo['State']) { ?><?php echo $IPinfo['State'] ?><?php } else { ?>127.0.0.1<?php } ?></span>
                                </h5>
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
    function deleteAll() {
        if (confirm('您确认要清空记录吗？')) {
            location.href = 'delip.php?id=all';
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