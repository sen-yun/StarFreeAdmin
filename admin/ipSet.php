<?php
session_start();

include_once 'Menu.php';
$ipchaxun = "select * from ".$db_prefix."_admin_banip";
$ipres = mysqli_query($connect, $ipchaxun);
$IPinfo = mysqli_fetch_array($ipres);
?>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">IP封禁</h4>

                <form class="needs-validation" action="ipAddPost.php" method="post" novalidate>
                    <div class="form-group mb-3">
                        <label for="validationCustom05">IP地址</label>
                        <input type="text" class="form-control" id="validationCustom05" placeholder="请输入需封禁的IP"
                               name="ipdz" value="" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="validationCustom05">备注</label>
                        <input type="text" class="form-control" id="validationCustom05"
                               placeholder="备注IP封禁原因" name="bz" value="" required>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success"  type="submit" id="ipAddPost">提交添加</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>

<?php
include_once 'Footer.php';
?>

</body>
</html>