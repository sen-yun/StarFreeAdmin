<?php
session_start();

include_once 'Menu.php';

?>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">账号操作</h4>
                <div class="form-group button-bg-4" >
                    <a href="user.php"><button class="btn btn-success w-100" type="button"><i class="dripicons-gear"></i> 账号设置</button></a>
                    <br><br>
                    <a href="javascript:void(0)" onclick="if(confirm('确定要退出登录吗?')){window.location.href='loginOut.php'}">
                        <button class="btn btn-danger w-100" type="button"><i class="dripicons-power"></i> 退出登录</button>
                    </a>
                </div>
            </div>  
        </div> 
    </div>  


</div>

<?php
include_once 'Footer.php';
?>

</body>
</html>