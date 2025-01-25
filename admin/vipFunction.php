<?php
session_start();

include_once 'Menu.php';
$sql = "SELECT * FROM ".$redis_prefix."_admin_functions";
$result = mysqli_query($connect, $sql);
if($result){
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">VIP设置</h4>
                <form class="needs-validation" action="vipFunctionPost.php" method="post" onsubmit="return check()" novalidate>
                <div class="form-group mb-3">
                      <label for="notice">VIP特权说明：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                          <textarea id="notice" class="form-control" name="Vipprivilege" rows="6"><?php echo $row['Vipprivilege']; ?></textarea>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="vipFunctionPost">保存修改</button>
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