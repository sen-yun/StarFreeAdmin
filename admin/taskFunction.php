<?php
session_start();
?>



<?php
include_once 'Nav.php';
$sql = "SELECT * FROM Sy_functions";
$result = mysqli_query($connect, $sql);
// 检查查询结果是否为空
if (mysqli_num_rows($result) > 0) {
    // 获取第一行数据作为结果集
    $row = mysqli_fetch_assoc($result);
}

$sql2 = "SELECT * FROM Sy_set";
$result2 = mysqli_query($connect, $sql2);
if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">每日任务设置</h4>
                <form class="needs-validation" action="taskFunctionPost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler1(obj) {
                                var input = document.getElementById("switch1");
                                var task1 = document.getElementById("task1");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task1.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task1.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">绑定QQ任务</label>
                            <?php
                            if ($row['Task1']==1) {
                                echo '<input type="checkbox" name="Task1" id="switch1" value="1" data-switch="success"
                               onclick="myOnClickHandler1(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task1" id="switch1" value="0" data-switch="success"
                               onclick="myOnClickHandler1(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch1" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task1']==1) {
                        echo '<div id="task1" style="display: block;">';
                    } else {
                        echo '<div id="task1" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp1" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp1']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset1" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset1']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler2(obj) {
                                var input = document.getElementById("switch2");
                                var task2 = document.getElementById("task2");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task2.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task2.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">发布帖子任务</label>
                            <?php
                            if ($row['Task2']==1) {
                                echo '<input type="checkbox" name="Task2" id="switch2" value="1" data-switch="success"
                               onclick="myOnClickHandler2(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task2" id="switch2" value="0" data-switch="success"
                               onclick="myOnClickHandler2(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch2" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task2']==1) {
                        echo '<div id="task2" style="display: block;">';
                    } else {
                        echo '<div id="task2" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp2" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp2']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset2" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset2']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                        <div class="d-flex align-items-center margin-t5">
                            <input name="Tasklimit2" class="form-control" type="number" required="" id="Vipdiscount" placeholder="每日任务上限" style="flex: 1;" value="<?php echo $row['Tasklimit2']; ?>">
                            <span style="margin-left: 15px;">次上限</span>
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler3(obj) {
                                var input = document.getElementById("switch3");
                                var task3 = document.getElementById("task3");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task3.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task3.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">发动态任务</label>
                            <?php
                            if ($row['Task3']==1) {
                                echo '<input type="checkbox" name="Task3" id="switch3" value="1" data-switch="success"
                               onclick="myOnClickHandler3(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task3" id="switch3" value="0" data-switch="success"
                               onclick="myOnClickHandler3(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch3" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task3']==1) {
                        echo '<div id="task3" style="display: block;">';
                    } else {
                        echo '<div id="task3" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp3" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp3']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset3" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset3']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                        <div class="d-flex align-items-center margin-t5">
                            <input name="Tasklimit3" class="form-control" type="number" required="" id="Vipdiscount" placeholder="每日任务上限" style="flex: 1;" value="<?php echo $row['Tasklimit3']; ?>">
                            <span style="margin-left: 15px;">次上限</span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler5(obj) {
                                var input = document.getElementById("switch5");
                                var task5 = document.getElementById("task5");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task5.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task5.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">发布评论任务</label>
                            <?php
                            if ($row['Task5']==1) {
                                echo '<input type="checkbox" name="Task5" id="switch5" value="1" data-switch="success"
                               onclick="myOnClickHandler5(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task5" id="switch5" value="0" data-switch="success"
                               onclick="myOnClickHandler5(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch5" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task5']==1) {
                        echo '<div id="task5" style="display: block;">';
                    } else {
                        echo '<div id="task5" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp5" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp5']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset5" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset5']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                        <div class="d-flex align-items-center margin-t5">
                            <input name="Tasklimit5" class="form-control" type="number" required="" id="Vipdiscount" placeholder="每日任务上限" style="flex: 1;" value="<?php echo $row['Tasklimit5']; ?>">
                            <span style="margin-left: 15px;">次上限</span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler4(obj) {
                                var input = document.getElementById("switch4");
                                var task4 = document.getElementById("task4");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task4.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task4.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">打赏帖子任务</label>
                            <?php
                            if ($row['Task4']==1) {
                                echo '<input type="checkbox" name="Task4" id="switch4" value="1" data-switch="success"
                               onclick="myOnClickHandler4(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task4" id="switch4" value="0" data-switch="success"
                               onclick="myOnClickHandler4(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch4" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task4']==1) {
                        echo '<div id="task4" style="display: block;">';
                    } else {
                        echo '<div id="task4" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp4" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp4']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset4" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset4']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                        <div class="d-flex align-items-center margin-t5">
                            <input name="Tasklimit4" class="form-control" type="number" required="" id="Vipdiscount" placeholder="每日任务上限" style="flex: 1;" value="<?php echo $row['Tasklimit4']; ?>">
                            <span style="margin-left: 15px;">次上限</span>
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <script>
                            function myOnClickHandler6(obj) {
                                var input = document.getElementById("switch6");
                                var task6 = document.getElementById("task6");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("打开");
                                    input.value = "1";
                                    task6.style.display = "block";
                                } else {
                                    console.log("关闭");
                                    input.value = "0";
                                    task6.style.display = "none";
                                }
                            }
                        </script>
                        <label for="validationCustom01">关注用户任务</label>
                            <?php
                            if ($row['Task6']==1) {
                                echo '<input type="checkbox" name="Task6" id="switch6" value="1" data-switch="success"
                               onclick="myOnClickHandler6(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Task6" id="switch6" value="0" data-switch="success"
                               onclick="myOnClickHandler6(this)">';
                            }
                            ?>
                        
                        <label id="switchurl" style="display:block;" for="switch6" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Task6']==1) {
                        echo '<div id="task6" style="display: block;">';
                    } else {
                        echo '<div id="task6" style="display: none;">';
                    }
                    ?>
                    <div class="form-group col-sm-4" style="width:85%">
                      <label for="Vipdiscount">任务奖励：</label>
                      <div class="d-flex align-items-center">
                        <input name="Taskexp6" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskexp6']; ?>">
                        <span style="margin-left: 15px;">经验</span>
                      </div>
                      <div class="d-flex align-items-center margin-t5">
                            <input name="Taskasset6" class="form-control" type="number" required="" id="Vipdiscount" placeholder="任务奖励数额" style="flex: 1;" value="<?php echo $row['Taskasset6']; ?>">
                            <span style="margin-left: 15px;"><?php echo $row2['Assetname']; ?></span>
                        </div>
                        <div class="d-flex align-items-center margin-t5">
                            <input name="Tasklimit6" class="form-control" type="number" required="" id="Vipdiscount" placeholder="每日任务上限" style="flex: 1;" value="<?php echo $row['Tasklimit6']; ?>">
                            <span style="margin-left: 15px;">次上限</span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="taskFunctionPost">保存修改</button>
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