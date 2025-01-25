<?php
session_start();

include_once 'Menu.php';
?>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3 size_18">新增版本</h4>

                <form class="needs-validation" m action="updateAddPost.php" method="post" onsubmit="return check()"
                      novalidate>
                    <div class="form-group ">
                        <label for="validationCustom01">版本名称</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">比如：1.0.1</span>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="请输入版本名称"
                               name="version" required>
                    </div>
                    <div class="form-group ">
                        <label for="validationCustom01">版本号</label><small>（只有纯数字,没有任何小数点和其他符号，请勿跟版本名称混淆）</small><span class="badge badge-success-lighten"style="font-size: 0.8rem;">版本号务必要比上版本的大 比如：101</span>
                        <input type="number" class="form-control" id="validationCustom01" placeholder="请输入版本号"
                               name="versionCode" required>
                    </div>
                    <div class="form-group mb-3">
                      <label for="notice">更新描述</label><span class="badge badge-success-lighten"style="font-size: 0.8rem;">支持html</span>
                      <textarea id="notice" class="form-control" name="versionIntro" rows="6" placeholder="请输入更新描述"></textarea>
                    </div>
                    <div class="form-group ">
                        <label for="validationCustom01">下载链接</label>
                        <input type="url" class="form-control" id="validationCustom01" placeholder="请输入下载链接"
                               name="versionUrl" required>
                    </div>
                    <div class="form-group ">
                        <label>更新类型</label>
                            <select class="form-control" id="dynamic-type" name="force">
                                    <option value="1" selected>强制更新</option>
                                    <option value="0">普通更新</option>
                            </select>
                    </div>
                  
                    <div class="form-group mb-3 text_right">
                        <button class="btn btn-primary" type="submit" id="updateAddPost">发布新版本</button>
                    </div>
                </form>

            </div>
        </div> 
    </div> 
</div>

<script>
    function check() {
        let version = document.getElementsByName('version')[0].value.trim();
        let versionCode = document.getElementsByName('versionCode')[0].value.trim();
        let versionIntro = document.getElementsByName('versionIntro')[0].value.trim();
        let versionUrl = document.getElementsByName('versionUrl')[0].value.trim();
        
        if (version.length == 0) {
            alert("版本名不能为空");
            return false;
        } else if (versionCode.length == 0) {
            alert("版本号不能为空");
            return false;
        } else if (versionIntro.length == 0) {
            alert("更新描述不能为空");
            return false;
        } else if (versionUrl.length == 0) {
            alert("下载链接不能为空");
            return false;
        }
    }
</script>

<?php
include_once 'Footer.php';
?>

</body>
</html>