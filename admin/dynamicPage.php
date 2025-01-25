<?php
session_start();
?>
<?php
include_once 'Nav.php';
$sql = "SELECT * FROM Sy_pages";
$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">动态页设置</h4>
                <form class="needs-validation" action="dynamicPagePost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="form-group mb-3">
                          <label for="Banner">视频动态封面：</label>
                          <input name="Dynamicimg" class="form-control" type="url" required="" id="Banner" placeholder="图片链接" value="<?php echo $row['Dynamicimg']; ?>">
                    <?php
                    if ($row['Dynamicimg'] !== '') {
                        echo '<label for="yl" style="margin-top:.5rem">预览图：</label><br><span class="dtr-data" id="yl"><img style="width: 220px;height: 130px;object-fit: cover;box-shadow: 0 8px 12px #c9cbcfd6;border-radius: 6px" src="' . $row['Dynamicimg'] . '" class="spotlight"></span></div>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="dynamicPagePost">保存修改</button>
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