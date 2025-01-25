<?php
session_start();

include_once 'Menu.php';
$sql = "select * from ".$db_prefix."_admin_update order by id desc";
$contents = mysqli_query($connect, $sql);


?>

<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css"/>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">版本管理<a class="fabu" href="updateAdd.php">
                        <button type="button" class="btn btn-success2 btn-sm btn-rounded right_10">
                            <i class="dripicons-plus"></i> 添加新版本
                        </button>
                    </a></h4>
                
                <table id="basic-update" class="table dt-responsive nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>版本名</th>
                        <th>版本号</th>
                        <th>描述</th>
                        <th>下载链接</th>
                        <th>类型</th>
                        <th style="width: 125px;">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ($articledata = mysqli_fetch_array($contents)) {
                        ?>
                        <tr>
                            <td><?php echo $articledata['id'] ?></td>
                            <td><?php echo $articledata['version'] ?></td>
                            <td><?php echo $articledata['versionCode'] ?></td>
                            <td><?php echo $articledata['versionIntro'] ?></td>
                             <td>
                                <?php echo $articledata['versionUrl'] ?>
                            </td>
                            <td>
                                 <h5>
                                    <?php if ($articledata['force']== 0) { ?>
                                    <span class="badge badge-success-lighten">普通更新</span>
                                    <?php } else { ?>
                                    <span class="badge badge-info-lighten">强制更新</span>
                                    <?php }?>
                                </h5>
                                
                            </td>
                            <td>
                                <a href="javascript:del(<?php echo $articledata['id']; ?>);">
                                    <button style="white-space: nowrap;" type="button"
                                            class="btn btn-danger btn-rounded">
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
    function del(id) {
        if (confirm('您确认要删除id为' + id + '的版本吗？')) {
            location.href = 'updateDel.php?id=' + id +'&status=one';
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