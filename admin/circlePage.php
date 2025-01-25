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
                <h4 class="header-title mb-3">圈子、动态页设置</h4>

                <form class="needs-validation" action="circlePagePost.php" method="post" onsubmit="return check()"
                      novalidate>
                    <div class="section-title">
                        <h5>圈子页设置</h5>
                        <hr class="section-divider">
                    </div>
                    <div class="form-group mb-3">
                    <script>
                        function handleSwitchChange(element) {
                            var switchInput = document.getElementById("userStatsSwitch");
                            var userNumberInput = document.getElementById("userNumberInput");
                            if (element.checked) {
                                console.log("打开");
                                switchInput.value = "1";
                                userNumberInput.style.display = "block";
                            } else {
                                console.log("关闭"); 
                                switchInput.value = "0";
                                userNumberInput.style.display = "none";
                            }
                        }
                    </script>
                    <label for="validationCustom01">用户统计条</label>
                    <?php
                    if ($row['Usernumber']==1) {
                        echo '<input type="checkbox" name="Usernumber" id="userStatsSwitch" value="1" data-switch="success"
                           onclick="handleSwitchChange(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Usernumber" id="userStatsSwitch" value="0" data-switch="success"
                           onclick="handleSwitchChange(this)">';
                    }
                    ?>
                    <label id="switchLabel" style="display:block;" for="userStatsSwitch" data-on-label="打开"
                           data-off-label="关闭"></label>
                    <div id="userNumberInput" style="display:<?php echo $row['Usernumber']==1 ? 'block' : 'none'; ?>">
                        <label for="Dumnum">用户冲假数量:</label>
                        <input type="number" class="form-control" id="Dumnum" name="Dumnum" value="<?php echo $row['Dumnum']; ?>">
                    </div>
                    </div>
                    <div class="form-group col-sm-4" id="circleLayoutSection">
                        <label for="validationCustom01">圈子排版样式</label>
                        <select class="form-control" id="layoutSelect" name="Circlestyle">
                            <?php
                            $selected1 = ($row['Circlestyle']==1) ? 'selected' : '';
                            $selected2 = ($row['Circlestyle']==2) ? 'selected' : '';
                            echo "<option value='1' $selected1>板块排版</option>
                                  <option value='2' $selected2>大图排版</option>";
                            ?>
                            
                        </select>
                    </div>

                    <div class="section-title mt-4">
                        <h5>动态页设置</h5>
                        <hr class="section-divider">
                    </div>
                    <div class="form-group mb-3">
                          <label for="Banner">视频动态封面：</label><span class="badge badge-success-lighten" style="font-size: 0.8rem;">免费版仅支持显示统一的视频封面</span>
                          <input name="Dynamicimg" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Dynamicimg']; ?>">
                    <?php
                    if ($row['Dynamicimg'] !== '') {
                        echo '<label for="preview" style="margin-top:.5rem">预览图：</label><br><span class="dtr-data" id="preview"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Dynamicimg'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="saveChangesBtn">保存修改</button>
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