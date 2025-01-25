<?php
session_start();
include_once 'Menu.php';
$sql = "SELECT * FROM ".$db_prefix."_admin_set";
$result = mysqli_query($connect, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    $row = array();
}

$curl = curl_init();
$url = $API_GET_API_CONFIG.'?webkey='.$api_key;
curl_setopt_array($curl, array(
   CURLOPT_URL => $url,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_SSL_VERIFYPEER => false,
   CURLOPT_SSL_VERIFYHOST => false,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$responseData = json_decode($response, true);  

if ($responseData && isset($responseData['code']) && $responseData['code'] == 1) {  
    $postMax = $responseData['data']['postMax'];    
    $isLogin = $responseData['data']['isLogin'];
    $webinfoTitle = $responseData['data']['webinfoTitle'];
    
    // 输出请求结果信息
}elseif($responseData['msg']=='请输入正确的访问key'){
    echo "<div class='alert alert-danger'>";
    echo "Star后台Config_DB.php文件的ApiKey错误<br>";
    echo "</div>";
}else {
    echo "<div class='alert alert-danger'>";
    echo "API请求失败或返回数据异常<br>";
    echo "错误信息: " . (isset($responseData['msg']) ? $responseData['msg'] : '未知错误') . "<br>";
    echo "状态码: " . (isset($responseData['code']) ? $responseData['code'] : '无状态码') . "<br>";
    echo "返回数据: " . ($response ? $response : '无返回数据')."<br>";
    echo "你配置的API站点：".$api_site."<br>";
    echo "你的后台站点：" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/<br>";
    echo "请确保API站点和后台站点的SSL协议一致！并且API站点后缀以“/”结尾";
    echo "</div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title" style="text-align:center">全局设置</h4>
                <form class="needs-validation" action="settingsPost.php" method="post" onsubmit="return check()" novalidate>
                    <div class="row">
                        <!-- 左侧栏 -->
                        <div class="col-12 col-lg-6">
                            <!-- 基础设置 -->
                            <div class="settings-section mb-4">
                                <h5 class="settings-title mb-3" style="padding: 10px 0; border-bottom: 2px solid #eee;">
                                   基础设置
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="h5DebugSwitch">H5调试模式</label>
                                    <?php
                                    if ($row['h5of']==1) {
                                        echo '<input type="checkbox" name="h5of" id="h5DebugSwitch" value="1" data-switch="success"
                                           onclick="handleH5DebugSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="h5of" id="h5DebugSwitch" value="0" data-switch="success"
                                           onclick="handleH5DebugSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="h5DebugSwitch" data-on-label="开启"
                                           data-off-label="关闭"></label>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="webinfoTitle">站点名称
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        用于邮件发送、消息推送等显示的名称，可以填写网站或APP的名称
                                    </span></label>
                                    <input name="webinfoTitle" class="form-control" type="text" required="" id="webinfoTitle" placeholder="请输入站点名称" value="<?php echo $webinfoTitle;  ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="postMax">每日最大发布数量
                                    <span style="font-size: 0.7rem;color:#acacac;margin-left:10px">
                                        针对帖子，动态等
                                    </span></label>
                                    <input name="postMax" class="form-control" type="text" required="" id="postMax" placeholder="输入每日最大发布数量" value="<?php echo $postMax ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Groupurl">交流群链接</label>
                                    <input name="Groupurl" class="form-control" type="text" required="" id="Groupurl" placeholder="交流群链接" value="<?php echo $row['Groupurl']; ?>">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="Auditurl">审核员链接</label>
                                    <input name="Auditurl" class="form-control" type="text" required="" id="Auditurl" placeholder="审核员链接" value="<?php echo $row['Auditurl']; ?>">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="Waiterurl">客服链接</label>
                                    <input name="Waiterurl" class="form-control" type="text" required="" id="Waiterurl" placeholder="客服链接" value="<?php echo $row['Waiterurl']; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- 右侧栏 -->
                        <div class="col-12 col-lg-6">
                            <!-- 货币配置 -->
                            <div class="settings-section mb-4">
                                <h5 class="settings-title mb-3" style="padding: 10px 0; border-bottom: 2px solid #eee;">
                                  货币配置
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="Assetname">货币名称</label>
                                    <input name="Assetname" class="form-control" type="text" required="" id="Assetname" placeholder="货币名称" value="<?php echo $row['Assetname']; ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="withdrawalPermissions">提现权限</label>
                                    <select class="form-control" id="withdrawalPermissions" name="Withdrawals">
                                        <?php
                                        $options = [
                                            1 => '管理+审核+VIP',
                                            2 => '管理+VIP',
                                            3 => '管理+审核',
                                            4 => '所有用户',
                                            5 => '关闭提现'
                                        ];
                                        foreach ($options as $value => $label) {
                                            $selected = ($row['Withdrawals'] == $value) ? 'selected' : '';
                                            echo "<option value=\"$value\" $selected>$label</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="Threshold">货币提现门槛</label>
                                    <input name="Threshold" class="form-control" type="number" required="" id="Threshold" placeholder="单位：货币" value="<?php echo $row['Threshold']; ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="Premium">提现手续费</label>
                                    <div class="d-flex align-items-center">
                                        <input name="Premium" class="form-control" type="number" required="" id="Premium" placeholder="0~100" style="flex: 1;" value="<?php echo $row['Premium']; ?>">
                                        <span style="margin-left: 5px;">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 三栏配置部分 -->
                    <div class="row">
                        <!-- 帖子配置 -->
                        <div class="col-12 col-lg-4">
                            <div class="settings-section mb-4" >
                                <h5 class="settings-title mb-3" style="padding: 10px 0; border-bottom: 2px solid #eee;">
                                   帖子配置
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="shareSwitch">分享开关</label>
                                    <?php
                                    if ($row['Share']==1) {
                                        echo '<input type="checkbox" name="Share" id="shareSwitch" value="1" data-switch="success"
                                           onclick="handleShareSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="Share" id="shareSwitch" value="0" data-switch="success"
                                           onclick="handleShareSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="shareSwitch" data-on-label="打开"
                                           data-off-label="关闭"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tippingSwitch">打赏开关</label>
                                    <?php
                                    if ($row['Tipping']==1) {
                                        echo '<input type="checkbox" name="Tipping" id="tippingSwitch" value="1" data-switch="success"
                                           onclick="handleTippingSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="Tipping" id="tippingSwitch" value="0" data-switch="success"
                                           onclick="handleTippingSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="tippingSwitch" data-on-label="打开"
                                           data-off-label="关闭"></label>
                                </div>
                            </div>
                        </div>

                        <!-- 支付配置 -->
                        <div class="col-12 col-lg-4">
                            <div class="settings-section mb-4" >
                                <h5 class="settings-title mb-3" style="padding: 10px 0; border-bottom: 2px solid #eee;">
                                   支付配置
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="paymentSwitch">充值开关</label>
                                    <?php
                                    if ($row['Payswith']==1) {
                                        echo '<input type="checkbox" name="Payswith" id="paymentSwitch" value="1" data-switch="success"
                                           onclick="handlePaymentSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="Payswith" id="paymentSwitch" value="0" data-switch="success"
                                           onclick="handlePaymentSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="paymentSwitch" data-on-label="打开"
                                           data-off-label="关闭"></label>
                                </div>
                                <div id="paymentMethodsDiv">
                                    <div class="payment-methods">
                                        <div class="form-group mb-3">
                                            <label for="alipaySwitch">支付宝</label>
                                            <?php
                                            if ($row['Alipay']==1) {
                                                echo '<input type="checkbox" name="Alipay" id="alipaySwitch" value="1" data-switch="success"
                                                   onclick="handleAlipaySwitch(this)" checked>';
                                            }else{
                                                echo '<input type="checkbox" name="Alipay" id="alipaySwitch" value="0" data-switch="success"
                                                   onclick="handleAlipaySwitch(this)">';
                                            }
                                            ?>
                                            <label id="switchLabel" style="display:block;" for="alipaySwitch" data-on-label="显示"
                                                   data-off-label="隐藏"></label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="wechatPaySwitch">微信支付</label>
                                            <?php
                                            if ($row['WePay']==1) {
                                                echo '<input type="checkbox" name="WePay" id="wechatPaySwitch" value="1" data-switch="success"
                                                   onclick="handleWechatPaySwitch(this)" checked>';
                                            }else{
                                                echo '<input type="checkbox" name="WePay" id="wechatPaySwitch" value="0" data-switch="success"
                                                   onclick="handleWechatPaySwitch(this)">';
                                            }
                                            ?>
                                            <label id="switchLabel" style="display:block;" for="wechatPaySwitch" data-on-label="显示"
                                                   data-off-label="隐藏"></label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cardPaySwitch">卡密兑换</label>
                                            <?php
                                            if ($row['Cami']==1) {
                                                echo '<input type="checkbox" name="Cami" id="cardPaySwitch" value="1" data-switch="success"
                                                   onclick="handleCardPaySwitch(this)" checked>';
                                            }else{
                                                echo '<input type="checkbox" name="Cami" id="cardPaySwitch" value="0" data-switch="success"
                                                   onclick="handleCardPaySwitch(this)">';
                                            }
                                            ?>
                                            <label id="switchLabel" style="display:block;" for="cardPaySwitch" data-on-label="显示"
                                                   data-off-label="隐藏"></label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="easyPaySwitch">易支付</label>
                                            <?php
                                            if ($row['Yipay']==1) {
                                                echo '<input type="checkbox" name="Yipay" id="easyPaySwitch" value="1" data-switch="success"
                                                   onclick="handleEasyPaySwitch(this)" checked>';
                                            }else{
                                                echo '<input type="checkbox" name="Yipay" id="easyPaySwitch" value="0" data-switch="success"
                                                   onclick="handleEasyPaySwitch(this)">';
                                            }
                                            ?>
                                            <label id="switchLabel" style="display:block;" for="easyPaySwitch" data-on-label="显示"
                                                   data-off-label="隐藏"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 登录配置 -->
                        <div class="col-12 col-lg-4">
                            <div class="settings-section mb-4" >
                                <h5 class="settings-title mb-3" style="padding: 10px 0; border-bottom: 2px solid #eee;">
                                   登录配置
                                </h5>
                                <div class="form-group mb-3">
                                    <label for="qqLoginSwitch">QQ登录</label>
                                    <?php
                                    if ($row['Qlogin']==1) {
                                        echo '<input type="checkbox" name="Qlogin" id="qqLoginSwitch" value="1" data-switch="success"
                                           onclick="handleQQLoginSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="Qlogin" id="qqLoginSwitch" value="0" data-switch="success"
                                           onclick="handleQQLoginSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="qqLoginSwitch" data-on-label="显示"
                                           data-off-label="隐藏"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="wxLoginSwitch">微信登录</label>
                                    <?php
                                    if ($row['wxlogin']==1) {
                                        echo '<input type="checkbox" name="wxlogin" id="wxLoginSwitch" value="1" data-switch="success"
                                           onclick="handleWxLoginSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="wxlogin" id="wxLoginSwitch" value="0" data-switch="success"
                                           onclick="handleWxLoginSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="wxLoginSwitch" data-on-label="显示"
                                           data-off-label="隐藏"></label>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="wbLoginSwitch">微博登录</label>
                                    <?php
                                    if ($row['wblogin']==1) {
                                        echo '<input type="checkbox" name="wblogin" id="wbLoginSwitch" value="1" data-switch="success"
                                           onclick="handleWbLoginSwitch(this)" checked>';
                                    }else{
                                        echo '<input type="checkbox" name="wblogin" id="wbLoginSwitch" value="0" data-switch="success"
                                           onclick="handleWbLoginSwitch(this)">';
                                    }
                                    ?>
                                    <label id="switchLabel" style="display:block;" for="wbLoginSwitch" data-on-label="显示"
                                           data-off-label="隐藏"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 text-right">
                        <button class="btn btn-success px-4" type="submit" id="settingsPost">
                            <i class="mdi mdi-content-save-outline mr-1"></i> 保存修改
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function check() {
        // 获取表单值并去除空格
        let webinfoTitle = document.getElementsByName('webinfoTitle')[0].value.trim();
        let postMax = document.getElementsByName('postMax')[0].value.trim();
        let Assetname = document.getElementsByName('Assetname')[0].value.trim();
        let Threshold = document.getElementsByName('Threshold')[0].value.trim();
        let Premium = document.getElementsByName('Premium')[0].value.trim();

        if (webinfoTitle.length == 0) {
            alert("站点名称不能为空");
            return false;
        }
        if (postMax.length == 0) {
            alert("每日最大发布数量不能为空");
            return false;
        }
        if (isNaN(postMax) || postMax < 0) {
            alert("每日最大发布数量必须是大于等于0的数字");
            return false;
        }
        if (Assetname.length == 0) {
            alert("货币名称不能为空");
            return false;
        }
        if (Threshold.length == 0) {
            alert("提现门槛不能为空");
            return false;
        }
        if (isNaN(Threshold) || Threshold < 0) {
            alert("提现门槛必须是大于等于0的数字");
            return false;
        }
        if (Premium.length == 0) {
            alert("提现手续费不能为空");
            return false;
        }
        if (isNaN(Premium) || Premium < 0 || Premium > 100) {
            alert("提现手续费必须是0-100之间的数字");
            return false;
        }

        return true;
    }

    function handleH5DebugSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleShareSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleTippingSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handlePaymentSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleAlipaySwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleWechatPaySwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleCardPaySwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleEasyPaySwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleQQLoginSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleWxLoginSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }

    function handleWbLoginSwitch(obj) {
        if (obj.checked) {
            obj.value = "1";
        } else {
            obj.value = "0";
        }
    }
</script>

<?php include_once 'Footer.php'; ?>

</body>
</html>