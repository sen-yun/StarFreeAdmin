<?php
session_start();

include_once 'Menu.php';
$sql = "SELECT * FROM ".$db_prefix."_admin_functions";
$result = mysqli_query($connect, $sql);
if($result){
  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
  }

}
$sql2 = "SELECT * FROM ".$db_prefix."_admin_set";
$result2 = mysqli_query($connect, $sql2);
if($result2){
  if (mysqli_num_rows($result2) > 0) {
      $row2 = mysqli_fetch_assoc($result2);
  }
}

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">签到设置</h4>

                <form class="needs-validation" action="signinFunctionPost.php" method="post" onsubmit="return check()"
                      novalidate>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">单次签到奖励：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp1" class="form-control" type="number" required="" id="Vipdiscount" placeholder="单次签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp1']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset1" class="form-control" type="number" required="" id="Vipdiscount" placeholder="单次签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset1']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>

                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到2天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp2" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp2']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset2" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset2']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>

                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到3天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp3" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp3']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset3" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset3']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>

                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到4天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp4" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp4']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset4" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset4']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到5天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp5" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp5']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset5" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset5']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>

                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到6天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp6" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp6']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset6" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset6']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>

                          <div class="form-group" style="width:85%">
                            <label for="Vipdiscount">连续签到7天：</label>
                            <div class="d-flex align-items-center">
                              <input name="Signinexp7" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinexp7']; ?>">
                              <span style="margin-left: 15px;">经验</span>
                            </div>
                            <div class="d-flex align-items-center margin-t5">
                                  <input name="Signinasset7" class="form-control" type="number" required="" id="Vipdiscount" placeholder="连续签到奖励" style="flex: 1;" value="<?php echo $row['Signinasset7']; ?>">
                                  <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mb-3 text_right">
                          <button class="btn btn-success" type="submit" id="signinFunctionPost">保存修改</button>
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