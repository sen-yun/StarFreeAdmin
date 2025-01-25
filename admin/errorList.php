<?php
session_start();

include_once 'Menu.php';
$ipkiki = "select * from " . $db_prefix . "_admin_warning order by id desc";
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
                <h4 class="header-title mb-3">非法访问列表</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                    <thead>
                    <tr>
                    <th>IP</th>
                        <th>IP归属地</th>
                        <th>时间</th>
                        <th>路径</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ($IPinfo = mysqli_fetch_array($ipki)) {
                        ?>
                        <tr>
                        <td>
                                <h5>
                                    <span class="badge badge-danger-lighten"><?php if ($IPinfo['ip']) { ?><?php echo $IPinfo['ip'] ?><?php } else { ?>127.0.0.1<?php } ?></span>
                                </h5>
                            </td>
                            <td><?php echo $IPinfo['gsd'] ?></td>
                            <td>
                                <small class="text-muted"><?php echo $IPinfo['time'] ?></small>
                            </td>
                            <td>
                                <h5><span class="badge badge-success-lighten"> <?php echo $IPinfo['file'] ?></span></h5>
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