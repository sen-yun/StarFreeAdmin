<?php
session_start();

include_once 'Menu.php';
$id = $_GET['id'];
$name = $_GET['name'];
$price = $_GET['price'];
$day = $_GET['day'];
$giftDay = $_GET['giftDay'];
$intro = $_GET['intro'];


?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">编辑VIP套餐</h4>
                <form class="needs-validation" action="vipEditPost.php" method="post"
                      novalidate>
                    <div class="form-group mb-3">
                          <label for="id">套餐ID</label>
                          <input name="id" class="form-control" type="text" id="id" value="<?php echo $id;  ?>" readonly>
                    </div>
                    <div class="form-group mb-3">
                          <label for="name">套餐名称</label>
                          <input name="name" class="form-control" type="text" id="name" value="<?php echo $name; ?>" placeholder="请输入套餐名称" required="">
                    </div>
                     <div class="form-group mb-3">
                          <label for="price">套餐价格<span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              只能为整数，单位：货币
                          </span></label>
                          <input name="price" class="form-control" type="text" id="price" value="<?php echo $price; ?>" placeholder="请输入套餐价格" required="">
                    </div>
                    <div class="form-group mb-3">
                          <label for="day">购买天数</label>
                          <input name="day" class="form-control" type="number" id="day" value="<?php echo $day; ?>" placeholder="请输入购买天数" required="">
                    </div>
                     <div class="form-group mb-3">
                          <label for="giftDay">赠送天数<span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                              购买后额外赠送天数，不赠送填0
                          </span></label>
                          <input name="giftDay" class="form-control" type="number" id="giftDay" value="<?php echo $giftDay; ?>" placeholder="请输入赠送天数" required="">
                    </div>
                     <div class="form-group mb-3">
                      <label for="intro">套餐简介（仅纯文本）</label>
                      <input name="intro" class="form-control" type="text" id="intro" value="<?php echo $intro; ?>" placeholder="请输入套餐简介" required="">
                    </div>
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-success" type="submit" id="vipEditPost">保存修改</button>
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