<?php
session_start();

include_once 'Menu.php';
$sql = "SELECT * FROM ".$db_prefix."_admin_pages";
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
                <h4 class="header-title mb-3">发现页设置</h4>
                <form class="needs-validation" action="findPagePost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="form-group mb-3">
                    <script>
                        function myOnClickHandler22(obj) {
                            var input = document.getElementById("switch21");
                            console.log(input);
                            if (obj.checked) {
                                console.log("置顶帖子打开");
                                input.value = "1";
                            } else {
                                console.log("置顶帖子关闭");
                                input.value = "0";
                            }
                        }
                    </script>
                    <label for="validationCustom01">置顶帖子开关</label>
                    <?php
                    if ($row['Findtop']==1) {
                        echo '<input type="checkbox" name="Findtop" id="switch21" value="1" data-switch="success"
                           onclick="myOnClickHandler22(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Findtop" id="switch21" value="0" data-switch="success"
                           onclick="myOnClickHandler22(this)">';
                    }
                    ?>
                    <label id="switchurl" style="display:block;" for="switch21" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler1(obj) {
                                var input = document.getElementById("switch1");
                                var PaymentMethods = document.getElementById("PaymentMethods");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("发现页轮播图打开");
                                    input.value = "1";
                                    PaymentMethods.style.display = "block";
                                } else {
                                    console.log("发现页轮播图关闭");
                                    input.value = "0";
                                    PaymentMethods.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">发现页广告位轮播图开关</label>
                            <?php
                            if ($row['Bannerswitch']==1) {
                                echo '<input type="checkbox" name="Bannerswitch" id="switch1" value="1" data-switch="success"
                               onclick="myOnClickHandler1(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Bannerswitch" id="switch1" value="0" data-switch="success"
                               onclick="myOnClickHandler1(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch1" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                            <?php
                            if ($row['Bannerswitch']==1) {
                                echo '<div id="PaymentMethods" style="display: block;">';
                            }else{
                                echo '<div id="PaymentMethods" style="display: none;">';
                            }
                            ?>
                   
                     <div class="form-group col-sm-4" style="width:65%">
                      <label for="Bannernumber">广告位轮播图显示数量</label>
                      <div class="d-flex align-items-center">
                        <input name="Bannernumber" class="form-control" type="number" required="" id="Bannernumber" placeholder="1~6" style="flex: 1;" value="<?php echo $row['Bannernumber']; ?>">
                        <span style="margin-left: 15px;">张</span>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位1：</label>
                          <input name="Bannerimg1" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg1']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl1" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl1']; ?>">
                    <?php
                    if ($row['Bannerimg1'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg1'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位2：</label>
                          <input name="Bannerimg2" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg2']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl2" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl2']; ?>">
                    <?php
                    if ($row['Bannerimg2'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg2'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位3：</label>
                          <input name="Bannerimg3" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg3']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl3" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl3']; ?>">
                    <?php
                    if ($row['Bannerimg3'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg3'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位4：</label>
                          <input name="Bannerimg4" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg4']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl4" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl4']; ?>">
                    <?php
                    if ($row['Bannerimg4'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg4'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位5：</label>
                          <input name="Bannerimg5" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg5']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl5" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl5']; ?>">
                    <?php
                    if ($row['Bannerimg5'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg5'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="Banner">轮播图广告位6：</label>
                          <input name="Bannerimg6" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Bannerimg6']; ?>">
                          <label for="Banner">转跳链接：</label>
                          <input name="Bannerurl6" class="form-control" type="url" required="" id="Banner" placeholder="转跳链接" value="<?php echo $row['Bannerurl6']; ?>">
                    <?php
                    if ($row['Bannerimg6'] !== '') {
                        echo '<label for="yl">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Bannerimg6'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="findPagePost">保存修改</button>
                    </div>
                </form>

            </div>  
        </div> 
    </div>  
</div>


<script>
function check() {
  let Bannernumber = document.getElementsByName('Bannernumber')[0].value.trim();
  
  if (Bannernumber < 1 || Bannernumber > 6) {

    alert('轮播图显示数量在1~6之间！');

    return false;
  }
}
</script>



<?php
include_once 'Footer.php';
?>

</body>
</html>