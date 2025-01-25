<?php
session_start();

include_once 'Menu.php';

?>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">账号设置</h4>

                <form class="needs-validation" action="userPost.php" method="post" novalidate  onsubmit="return check()">
                    <div class="form-group mb-3">
                        <label for="validationCustom04">管理员账号</label>
                        <?php if ($login['user'] == $adminuser)  {?><span class="badge badge-danger-lighten"style="font-size: 0.8rem;">请尽快修改默认账号</span><?php }else{ ?> <span class="badge badge-success-lighten"style="font-size: 0.8rem;"></span> <?php } ?>
                        <input type="text" class="form-control"  placeholder="请输入新的管理员账号"
                               name="adminName" value="<?php echo $login['user'] ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="validationCustom05">管理员密码</label>
                        <?php if ($login['pw'] == md5($adminpw))  {?><span class="badge badge-danger-lighten"style="font-size: 0.8rem;"> 请尽快修改默认密码</span><?php }else{ ?> <span class="badge badge-success-lighten"style="font-size: 0.8rem;"></span> <?php } ?>
                        <input class="form-control"  name="pw" type="password" value="" placeholder="不修改请留空">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success"  type="submit" id="userPost">提交修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  


</div>

<script>
    function check() {
        let adminName = document.getElementsByName('adminName')[0].value.trim();
        let pw = document.getElementsByName('pw')[0].value.trim();
        
        if (adminName.length == 0) {
            alert("请填写用户名");
            return false;
        }
        
        if (!/^[a-zA-Z0-9_]{3,16}$/.test(adminName)) {
            alert("用户名只能包含3-16位字母、数字和下划线");
            return false;
        }
        
        if (pw.length > 0 && (pw.length < 5 || pw.length > 20)) {
            alert("密码长度必须在5-20位之间");
            return false;
        }
        
        return true;
    }
</script>

<?php
include_once 'Footer.php';
?>

</body>
</html>