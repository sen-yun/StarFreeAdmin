<?php
session_start();

include_once 'Menu.php';
$sql = "SELECT * FROM ".$db_prefix."_admin_pages";
$result = mysqli_query($connect, $sql);

if($result){
    if (mysqli_num_rows($result) > 0) {
        $adminPageData = mysqli_fetch_assoc($result);
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">发帖页设置</h4>
                <form class="needs-validation" action="postPagePost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="adminCircle">限制发帖圈子mid：</label><span class="badge badge-success-lighten" style="font-size: 0.8rem;">仅管理员可发帖的圈子（目前仅为前端限制）</span>
                                <input name="Admin" class="form-control" type="text" required="" id="adminCircle" placeholder="多个请用英文逗号隔开" value="<?php echo $adminPageData['Admin']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <script>
                                    function toggleGalleryCheckbox(obj) {
                                        var galleryInput = document.getElementById("switchGallery");
                                        console.log(galleryInput);
                                        galleryInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">免费图库</label>
                                <?php
                                if ($adminPageData['Gallery'] == 1) {
                                    echo '<input type="checkbox" name="Gallery" id="switchGallery" value="1" data-switch="success" onclick="toggleGalleryCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Gallery" id="switchGallery" value="0" data-switch="success" onclick="toggleGalleryCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchGallery" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleCodeCheckbox(obj) {
                                        var codeInput = document.getElementById("switchCode");
                                        console.log(codeInput);
                                        codeInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入代码片段</label>
                                <?php
                                if ($adminPageData['Code'] == 1) {
                                    echo '<input type="checkbox" name="Code" id="switchCode" value="1" data-switch="success" onclick="toggleCodeCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Code" id="switchCode" value="0" data-switch="success" onclick="toggleCodeCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchCode" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleHyperlinkCheckbox(obj) {
                                        var hyperlinkInput = document.getElementById("switchHyperlink");
                                        console.log(hyperlinkInput);
                                        hyperlinkInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入超链接</label>
                                <?php
                                if ($adminPageData['Hyperlinks'] == 1) {
                                    echo '<input type="checkbox" name="Hyperlinks" id="switchHyperlink" value="1" data-switch="success" onclick="toggleHyperlinkCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Hyperlinks" id="switchHyperlink" value="0" data-switch="success" onclick="toggleHyperlinkCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchHyperlink" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleCommentsCheckbox(obj) {
                                        var commentsInput = document.getElementById("switchComments");
                                        console.log(commentsInput);
                                        commentsInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入回复可见</label>
                                <?php
                                if ($adminPageData['Comments'] == 1) {
                                    echo '<input type="checkbox" name="Comments" id="switchComments" value="1" data-switch="success" onclick="toggleCommentsCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Comments" id="switchComments" value="0" data-switch="success" onclick="toggleCommentsCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchComments" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleImageCheckbox(obj) {
                                        var imageInput = document.getElementById("switchImage");
                                        console.log(imageInput);
                                        imageInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入图片</label>
                                <?php
                                if ($adminPageData['Image'] == 1) {
                                    echo '<input type="checkbox" name="Image" id="switchImage" value="1" data-switch="success" onclick="toggleImageCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Image" id="switchImage" value="0" data-switch="success" onclick="toggleImageCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchImage" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <script>
                                    function toggleVideoCheckbox(obj) {
                                        var videoInput = document.getElementById("switchVideo");
                                        console.log(videoInput);
                                        videoInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入视频</label>
                                <?php
                                if ($adminPageData['Video'] == 1) {
                                    echo '<input type="checkbox" name="Video" id="switchVideo" value="1" data-switch="success" onclick="toggleVideoCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Video" id="switchVideo" value="0" data-switch="success" onclick="toggleVideoCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchVideo" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleTopicCheckbox(obj) {
                                        var topicInput = document.getElementById("switchTopic");
                                        console.log(topicInput);
                                        topicInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入话题</label>
                                <?php
                                if ($adminPageData['Topic'] == 1) {
                                    echo '<input type="checkbox" name="Topic" id="switchTopic" value="1" data-switch="success" onclick="toggleTopicCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Topic" id="switchTopic" value="0" data-switch="success" onclick="toggleTopicCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchTopic" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleShopCheckbox(obj) {
                                        var shopInput = document.getElementById("switchShop");
                                        console.log(shopInput);
                                        shopInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入商品</label>
                                <?php
                                if ($adminPageData['Shop'] == 1) {
                                    echo '<input type="checkbox" name="Shop" id="switchShop" value="1" data-switch="success" onclick="toggleShopCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Shop" id="switchShop" value="0" data-switch="success" onclick="toggleShopCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchShop" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleVipTextCheckbox(obj) {
                                        var vipTextInput = document.getElementById("switchVipText");
                                        console.log(vipTextInput);
                                        vipTextInput.value = obj.checked ? "1" : "0";
                                    }
                                </script>
                                <label for="validationCustom01">插入VIP可见内容【VIP用户专属】</label>
                                <?php
                                if ($adminPageData['Viptext'] == 1) {
                                    echo '<input type="checkbox" name="Viptext" id="switchVipText" value="1" data-switch="success" onclick="toggleVipTextCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Viptext" id="switchVipText" value="0" data-switch="success" onclick="toggleVipTextCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchVipText" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                            <div class="form-group mb-3">
                                <script>
                                    function toggleMusicCheckbox(obj) {
                                        var musicInput = document.getElementById("switchMusic");
                                        var paymentMethods = document.getElementById("PaymentMethods");
                                        console.log(musicInput);
                                        musicInput.value = obj.checked ? "1" : "0";
                                        paymentMethods.style.display = obj.checked ? "block" : "none";
                                    }
                                </script>
                                <label for="validationCustom01">插入音乐【VIP用户专属】</label>
                                <?php
                                if ($adminPageData['Music'] == 1) {
                                    echo '<input type="checkbox" name="Music" id="switchMusic" value="1" data-switch="success" onclick="toggleMusicCheckbox(this)" checked>';
                                } else {
                                    echo '<input type="checkbox" name="Music" id="switchMusic" value="0" data-switch="success" onclick="toggleMusicCheckbox(this)">';
                                }
                                ?>
                                <label id="switchurl" style="display:block;" for="switchMusic" data-on-label="打开" data-off-label="关闭"></label>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($adminPageData['Music'] == 1) {
                        echo '<div id="PaymentMethods" style="display: block;">';
                    } else {
                        echo '<div id="PaymentMethods" style="display: none;">';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="musicCover1">随机音乐封面图1：</label>
                          <input name="Musicimg1" class="form-control" type="url" required="" id="musicCover1" placeholder="图片链接" value="<?php echo $adminPageData['Musicimg1']; ?>">
                    <?php
                    if ($adminPageData['Musicimg1'] !== '') {
                        echo '<label for="preview1" style="margin-top:.5rem">预览图：</label><br><span class="dtr-data" id="preview1"><img style="width: 130px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $adminPageData['Musicimg1'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="form-group mb-3">
                          <label for="musicCover2">随机音乐封面图2：</label>
                          <input name="Musicimg2" class="form-control" type="url" required="" id="musicCover2" placeholder="图片链接" value="<?php echo $adminPageData['Musicimg2']; ?>">
                         
                    <?php
                    if ($adminPageData['Musicimg2'] !== '') {
                        echo '<label for="preview2" style="margin-top:.5rem">预览图：</label><br><span class="dtr-data" id="preview2"><img style="width: 130px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $adminPageData['Musicimg2'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3">
                          <label for="musicCover3">随机音乐封面图3：</label>
                          <input name="Musicimg3" class="form-control" type="url" required="" id="musicCover3" placeholder="图片链接" value="<?php echo $adminPageData['Musicimg3']; ?>">
                          
                    <?php
                    if ($adminPageData['Musicimg3'] !== '') {
                        echo '<label for="preview3" style="margin-top:.5rem">预览图：</label><br><span class="dtr-data" id="preview3"><img style="width: 130px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $adminPageData['Musicimg3'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="postPagePost">保存修改</button>
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