<?php
session_start();
?>



<?php
include_once 'Nav.php';
$sql = "SELECT * FROM Sy_set";
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
                <h4 class="header-title mb-3">隐藏功能</h4>

                <form class="needs-validation" action="otherSetPost.php" method="post" onsubmit="return check()"
                      novalidate>
                    
                    <div class="form-group mb-3">
                          <label for="Dummy">用户冲假数量</label>
                          <input name="Dummy" class="form-control" type="number" required="" id="Dummy" placeholder="用户冲假数量" value="<?php echo $row['Dummy']; ?>">
                    </div>
                    <div class="form-group mb-3">
                          <label for="Viewspw">刷浏览量密码</label>
                          <input name="Viewspw" class="form-control" type="text" required="" id="Viewspw" placeholder="刷浏览量密码" value="<?php echo $row['Viewspw']; ?>">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="otherSetPost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>


<script src="../Style/jquery/jquery.min.js"></script>


<?php
include_once 'Footer.php';
?>

</body>
</html>