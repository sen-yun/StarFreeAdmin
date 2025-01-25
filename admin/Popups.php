<?php
session_start();

include_once 'Menu.php';
$sql = "SELECT * FROM ".$db_prefix."_admin_popups";
$result = mysqli_query($connect, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">弹窗设置</h4>

                <form class="needs-validation" action="PopupsPost.php" method="post" onsubmit="return check()"
                      novalidate>
                    <div class="form-group mb-3">
                      <label for="notice">发帖页弹窗：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Postpopup" rows="6"><?php echo $row['Postpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">商品发布规范：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Shoppopup" rows="6"><?php echo $row['Shoppopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">签到页说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Signpopup" rows="6"><?php echo $row['Signpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">支付宝充值说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Alipaypopup" rows="6"><?php echo $row['Alipaypopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">微信充值说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Wechatpopup" rows="6"><?php echo $row['Wechatpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">卡密充值说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Camipopup" rows="6"><?php echo $row['Camipopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">易支付充值说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Yipaypopup" rows="6"><?php echo $row['Yipaypopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">登录页弹窗：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Loginpopup" rows="6"><?php echo $row['Loginpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">注册页弹窗：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Registpopup" rows="6"><?php echo $row['Registpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">找回页弹窗：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="Forgetpopup" rows="6"><?php echo $row['Forgetpopup']; ?></textarea>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="PopupsPost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>

<script>
    function check() {
        var textareas = document.querySelectorAll("textarea");
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].value = htmlEncode(textareas[i].value);
        }

        return true;
    }

    function htmlEncode(value) {
        return value.replace(/&/g, "&amp;")
                    .replace(/script/g, "?")
                    .replace(/SCRIPT/g, "?")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#39;");
    }
</script>

<?php
include_once 'Footer.php';
?>

</body>
</html>