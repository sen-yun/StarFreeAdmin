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
                <h4 class="header-title mb-3">首页设置</h4>
                <form class="needs-validation" action="homePagePost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="form-group mb-3">
                      <label for="announcement">首页公告：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="announcement" class="form-control" name="Announcement" rows="5"><?php echo $row['Announcement']; ?></textarea>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="displayTime">公告显示间隔：</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">一天 = 86400000毫秒</span>
                      <div class="d-flex align-items-center">
                        <input name="Displaytime" class="form-control" type="number" required="" id="displayTime" placeholder="单位：毫秒" style="flex: 1;" value="<?php echo $row['Displaytime']; ?>">
                        <span style="margin-left: 10px;">毫秒</span>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                        <script>
                            function handleNoticeSwitch(obj) {
                                var input = document.getElementById("switch4");
                                var noticeContent = document.getElementById("noticeContent");
                                console.log(input);
                                if (obj.checked) {
                                    console.log("滚动公告打开");
                                    input.value = "1";
                                    noticeContent.style.display = "block";
                                } else {
                                    console.log("滚动公告关闭");
                                    input.value = "0";
                                    noticeContent.style.display = "none";
                                }
                            }
                        </script>
                        <label for="noticeSwitch">滚动通知开关</label>
                            <?php
                            if ($row['Noticeswitch']==1) {
                                echo '<input type="checkbox" name="Noticeswitch" id="switch4" value="1" data-switch="success"
                               onclick="handleNoticeSwitch(this)" checked>';
                            }else{
                                echo '<input type="checkbox" name="Noticeswitch" id="switch4" value="0" data-switch="success"
                               onclick="handleNoticeSwitch(this)">';
                            }
                            ?>
                        
                        <label id="switchLabel" style="display:block;" for="switch4" data-on-label="打开"
                               data-off-label="关闭"></label>
                    </div>
                    <?php
                    if ($row['Noticeswitch']==1) {
                        echo '<div id="noticeContent" style="display: block;">';
                    } else {
                        echo '<div id="noticeContent" style="display: none;">';
                    }
                    ?>
                    <div class="form-group mb-3">
                      <label for="notice">滚动通知：</label>
                      <textarea id="notice" class="form-control" name="Notice" rows="3"><?php echo $row['Notice']; ?></textarea>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                          <label for="searchText">搜索框提示语: </label>
                    
                          <input name="Searchtext" class="form-control" type="text" required="" id="searchText" placeholder="搜索框提示语" value="<?php echo $row['Searchtext']; ?>">
                    <div class="form-group mb-3">
                    </div>
                    
                    <div class="form-group mb-3">
                    <script>
                        function handleCarouselSwitch(obj) {
                            var input = document.getElementById("switch1");
                            console.log(input);
                            if (obj.checked) {
                                console.log("帖子轮播图打开");
                                input.value = "1";
                            } else {
                                console.log("帖子轮播图关闭");
                                input.value = "0";
                            }
                        }
                    </script>
                    <label for="carouselSwitch">帖子轮播图开关</label>
                    <?php
                    if ($row['Carouselswitch']==1) {
                        echo '<input type="checkbox" name="Carouselswitch" id="switch1" value="1" data-switch="success"
                           onclick="handleCarouselSwitch(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Carouselswitch" id="switch1" value="0" data-switch="success"
                           onclick="handleCarouselSwitch(this)">';
                    }
                    ?>
                    <label id="switchLabel" style="display:block;" for="switch1" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                   <div class="form-group mb-3">
                    <script>
                        function handleIconSwitch(obj) {
                            var input = document.getElementById("switch2");
                            console.log(input);
                            if (obj.checked) {
                                console.log("图标模块打开");
                                input.value = "1";
                            } else {
                                console.log("图标模块关闭");
                                input.value = "0";
                            }
                        }
                    </script>
                    <label for="iconSwitch">图标模块开关</label>
                    <?php
                    if ($row['Iconswitch']==1) {
                        echo '<input type="checkbox" name="Iconswitch" id="switch2" value="1" data-switch="success"
                           onclick="handleIconSwitch(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Iconswitch" id="switch2" value="0" data-switch="success"
                           onclick="handleIconSwitch(this)">';
                    }
                    ?>
                    <label id="switchLabel" style="display:block;" for="switch2" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                    <div class="form-group mb-3">
                    <script>
                        function handleTopPostSwitch(obj) {
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
                    <label for="topPostSwitch">置顶帖子开关</label>
                    <?php
                    if ($row['Hometop']==1) {
                        echo '<input type="checkbox" name="Hometop" id="switch21" value="1" data-switch="success"
                           onclick="handleTopPostSwitch(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Hometop" id="switch21" value="0" data-switch="success"
                           onclick="handleTopPostSwitch(this)">';
                    }
                    ?>
                    <label id="switchLabel" style="display:block;" for="switch21" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                    
                    <div class="form-group mb-3">
                    <script>
                        function handlePostSwitch(obj) {
                            var input = document.getElementById("switch5");
                            console.log(input);
                            if (obj.checked) {
                                console.log("按钮模块打开");
                                input.value = "1";
                            } else {
                                console.log("按钮模块关闭");
                                input.value = "0";
                            }
                        }
                    </script>
                    <label for="postSwitch">最新帖子开关</label>
                    <?php
                    if ($row['Postswitch']==1) {
                        echo '<input type="checkbox" name="Postswitch" id="switch5" value="1" data-switch="success"
                           onclick="handlePostSwitch(this)" checked>';
                    }else{
                        echo '<input type="checkbox" name="Postswitch" id="switch5" value="0" data-switch="success"
                           onclick="handlePostSwitch(this)">';
                    }
                    ?>
                    <label id="switchLabel" style="display:block;" for="switch5" data-on-label="打开"
                           data-off-label="关闭"></label>
                    </div>
                    
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="homePagePost">保存修改</button>
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