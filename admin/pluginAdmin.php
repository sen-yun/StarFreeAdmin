<?php
session_start();
include_once 'Menu.php';
$pluginActionExists = file_exists('pluginAction.php');
$pluginMenuExists = file_exists('pluginMenu.php');
$pluginModuleInstalled = $pluginActionExists && $pluginMenuExists;

if ($pluginActionExists) {
    include_once 'pluginAction.php';
}
?>
<?php if (!$pluginModuleInstalled) { ?>
<div class="modal fade" id="pluginModuleModal" tabindex="-1" role="dialog" aria-labelledby="pluginModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pluginModuleModalLabel">插件模块检测</h5>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="dripicons-warning" style="font-size: 48px; color: #f1556c;"></i>
                    <h4 class="mt-3">检测到未安装插件模块</h4>
                    <p class="text-muted">若要安装请参考文档教程，安装后即可打开此页。</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalAndGoBack()">关闭</button>
                <button type="button" class="btn btn-primary" onclick="openInstallTutorial()">安装教程</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#pluginModuleModal').modal({
        backdrop: 'static',
        keyboard: false
    }).modal('show');
});

function closeModalAndGoBack() {
    $('#pluginModuleModal').modal('hide');
    setTimeout(function() {
        if (document.referrer) {
            window.location.href = document.referrer;
        } else {
            window.history.back();
        }
    }, 300);
}

function openInstallTutorial() {
    window.open('https://www.yuque.com/senyun-ev0j3/starfree/nwmehnv6ocmmf9o8', '_blank');
}
</script>

<?php
include_once 'Footer.php';
exit;
?>
<?php } ?>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $ADMIN_PATH;?>/assets/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css"/>
<!-- third party css end -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="header-title mb-3 text-center title-h1">管理插件</h2>
                <br>
                <div style="display:flex;justify-content: space-between;">
                <a class="fabu" target="_blank" href='https://starfree.qxzhi.cn/pluginStore.php'>
                    <button type="button" class="btn btn-success2 btn-sm btn-rounded" style="margin-bottom: 20px;">
                        <i class="dripicons-gear mr-1"></i><span>插件商城</span>
                    </button>
                </a>
                <a class="fabu" target="_blank" href='https://www.yuque.com/senyun-ev0j3/starfree/qhvwc8872ewgb2dy'>
                    <button type="button" class="btn btn-success2 btn-sm btn-rounded" style="margin-bottom: 20px;">
                        <i class="dripicons-trophy mr-1"></i><span>开发插件</span>
                    </button>
                </a>
                </div>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>文件名</th>
                        <th>作者</th>
                        <th>版本</th>
                        <th>状态</th>
                        <th>安装</th>
                        <th style="width: 125px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($plugins as $plugin) { ?>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" onclick="showConfigPath('<?php echo htmlspecialchars($plugin['name']); ?>', '<?php echo htmlspecialchars($plugin['configPath']); ?>')" style="color: #007bff; cursor: pointer; text-decoration: none;">
                                    <?php echo htmlspecialchars($plugin['name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($plugin['filename']); ?></td>
                            <td><?php echo htmlspecialchars($plugin['author']); ?></td>
                            <td><?php echo htmlspecialchars($plugin['version']); ?></td>
                            <td>
                                <h5>
                                    <?php if ($plugin['enabled']== 'true') { ?><span class="badge badge-success-lighten">已打开</span><?php } else { ?><span class="badge badge-danger-lighten">已关闭</span><?php } ?>
                                </h5>
                            <td>
                                <h5>
                                     <?php if ($plugin['installed']== 'true') { ?><span class="badge badge-success-lighten">已安装</span><?php } else { ?><span class="badge badge-danger-lighten">未安装</span><?php } ?>
                                </h5>
                            </td>
                            <td>
                                <?php if ($plugin['enabled'] == 'false') { ?>
                                    <a href="javascript:void(0);" onclick="performAction('enable', '<?php echo $plugin['filename']; ?>', '', '确定要打开这个插件吗？')">
                                        <button style="white-space: nowrap;" type="button" class="btn btn-info btn-rounded">
                                            <i class="dripicons-checkmark"></i> 打开
                                        </button>
                                    </a>
                                <?php } elseif ($plugin['enabled'] == 'true' && $plugin['installed'] == 'false') { ?>
                                    <a href="javascript:void(0);" onclick="performAction('disable', '<?php echo $plugin['filename']; ?>', '', '确定要关闭这个插件吗？')">
                                        <button style="white-space: nowrap;" type="button" class="btn btn-danger btn-rounded">
                                            <i class="dripicons-cross"></i> 关闭
                                        </button>
                                    </a>
                                    <a href="javascript:void(0);" onclick="performAction('install', '<?php echo $plugin['filename']; ?>', '<?php echo $plugin['isFree']; ?>', '确定要执行安装吗？安装会数据库造成修改，请在安装前备份好数据！')">
                                        <button style="white-space: nowrap;" type="button" class="btn btn-info btn-rounded">
                                            <i class="dripicons-inbox"></i> 安装
                                        </button>
                                    </a>
                                <?php } elseif ($plugin['enabled'] == 'true' && $plugin['installed'] == 'true') { ?>
                                    <a href="javascript:void(0);" onclick="performAction('uninstall', '<?php echo $plugin['filename']; ?>', '<?php echo $plugin['isFree']; ?>', '确定要执行卸载吗？卸载会删除插件相关的一切数据，请在卸载前备份好数据！')">
                                        <button style="white-space: nowrap;" type="button" class="btn btn-danger btn-rounded">
                                            <i class="dripicons-trash"></i> 卸载
                                        </button>
                                    </a>
                                <?php } ?>
                            </td>



                        </tr>
                    <?php } ?>
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

<script>
function showConfigPath(pluginName, configPath) {
    alert('插件：' + pluginName + '\n配置文件路径：' + configPath);
}

function performAction(type, plugin, isFree, confirmMsg) {
    if (confirm(confirmMsg)) {
        var url = '?action=save&type=' + type + '&plugin=' + plugin;
        if (isFree && isFree !== '') {
            url += '&isFree=' + isFree;
        }
        window.location.href = url;
    }
}
</script>


</body>
</html>
