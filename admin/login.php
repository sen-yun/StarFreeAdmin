<?php
session_start();
include_once '../Config_DB.php';

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <title>StarFree后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $ADMIN_PATH;?>/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
    
    <style>
        .card {
            border-radius: 15px;
        }
        .card-header.pt-4.pb-4.text-center.bg-primary {
            border-radius: 15px 15px 0 0;
        }
        .btn-success {
            padding: 10px 25px;
            border-radius: 20px;
        }
        .anchor span {
            background: linear-gradient(90deg, rgba(247,174,223,1) 0%, rgba(237,180,233,1) 24%, rgba(250,212,223,1) 94%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }
        .btn-success {
            box-shadow: 0 2px 6px 0 #ffb1d959;
            color: #fff;
            width: 100%;
            background-color: #f6afec;
            border-color: #ce82c4;
        }
        .btn-success:hover {
            box-shadow: 0 2px 6px 0 #ffa3e12b;
            color: #fff;
            width: 100%;
            background-color: #ffa3e1;
            border-color: #ffa3e1;
        }
        .custom-control-input:checked~.custom-control-label::before {
            color: #ce82c4;
            border-color: #ce82c4;
            background-color: #f6afec;
        }
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .input-group-text {
            cursor: pointer;
        }
        #captcha-img {
            cursor: pointer;
            height: 38px;
        }
    </style>
</head>

<body>
<div class="account-pages mt-5 mb-5" style="margin-top:7.5rem!important">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <h1><a class="anchor"><span>StarFree</span></a></h1>
                        </div>
                        <br>
                        <form id="loginForm" action="loginPost.php" method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="adminName">账号</label>
                                <input name="adminName" class="form-control" type="text" id="adminName" 
                                       placeholder="请输入管理员账号" maxlength="16">
                                <div id="adminName-error" class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label for="password">密码</label>
                                <div class="input-group">
                                    <input name="pw" class="form-control" type="password" id="password" 
                                           placeholder="请输入管理员密码" maxlength="20">
                                </div>
                                <div id="password-error" class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label for="captcha">验证码</label>
                                <div class="form-inline" style="justify-content: space-between;flex-flow: initial;">
                                    <input name="captcha" class="form-control" style="width: 60%;" type="text" 
                                           id="captcha" placeholder="请输入验证码" maxlength="4">
                                    <img id="captcha-img" src="captcha.php" onclick="refreshCaptcha()" alt="验证码">
                                </div>
                                <div id="captcha-error" class="error-message"></div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">记住密码</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success" type="submit">立即登录</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer footer-alt" style="text-align: center;">
    Copyright © 2025 <a href="https://starfree.qxzhi.cn" target="_blank">StarFree</a> Powered by 森云 
</footer>

<script src="<?php echo $ADMIN_PATH;?>/assets/js/app.min.js"></script>
<script src="../Style/jquery/jquery.min.js"></script>

<script>
function validateForm() {
    let isValid = true;
    const adminName = document.getElementById('adminName').value.trim();
    const password = document.getElementById('password').value.trim();
    const captcha = document.getElementById('captcha').value.trim();
    
    // 重置错误信息
    document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
    
    // 验证用户名
    if (!adminName) {
        showError('adminName', '用户名不能为空');
        isValid = false;
    } else if (!/^[a-zA-Z0-9_]{3,16}$/.test(adminName)) {
        showError('adminName', '用户名只能包含3-16位字母、数字和下划线');
        isValid = false;
    }
    
    // 验证密码
    if (!password) {
        showError('password', '密码不能为空');
        isValid = false;
    } else if (password.length < 5 || password.length > 20) {
        showError('password', '密码长度必须在5-20位之间');
        isValid = false;
    }
    
    // 验证验证码
    if (!captcha) {
        showError('captcha', '验证码不能为空');
        isValid = false;
    } else if (!/^[A-Za-z0-9]{4}$/.test(captcha)) {
        showError('captcha', '请输入4位验证码');
        isValid = false;
    }
    
    return isValid;
}

function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + '-error');
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

function refreshCaptcha() {
    document.getElementById('captcha-img').src = 'captcha.php?' + new Date().getTime();
}

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassword');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// 验证用户名
document.getElementById('adminName').addEventListener('input', function(e) {
    const value = e.target.value.trim();
    if (value && !/^[a-zA-Z0-9_]{3,16}$/.test(value)) {
        showError('adminName', '用户名只能包含3-16位字母、数字和下划线');
    } else {
        document.getElementById('adminName-error').style.display = 'none';
    }
});

// 防抖
document.getElementById('loginForm').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    setTimeout(() => {
        submitBtn.disabled = false;
    }, 2000);
});
/*
    * ###################################
    * ###本开源项目遵循MIT License协议###
    * ###您可以将项目用于合法的商业项目##
    * ###################################
    * ###为了项目后续更换的维护与更新####
    * ###请您保留原项目、作者版权信息####
    * ###################################
    */
    window.addEventListener('load', function() {
            console.log(
                '%c' +
                '   _____ __             ______              \n' +
                '  / ___// /_____ ______/ ____/_____  _____ \n' +
                '  \\__ \\/ __/ __ `/ ___/ /_  / ___/ _ \\/ _ \\\n' +
                ' ___/ / /_/ /_/ / /  / __/ / /  /  __/  __/\n' +
                '/____/\\__/\\__,_/_/  /_/   /_/   \\___/\\___/ \n',
                'color: #f6afe0; font-weight: bold;'
            );
            console.log(
                '%cStarFree <?php echo $currentVersion; ?>%c' + 
                ' 一款开源的唯美论坛博客系统',
                'background: linear-gradient(to right, #f7aed5, #f6afec); color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;',
                'color: #666; font-size: 14px;'
            );
            console.group('%c🌟 项目信息', 'color: #f6afec; font-size: 14px; font-weight: bold;');
            console.log(
                '%c官方文档%c https://www.yuque.com/senyun-ev0j3/starfree\n' +
                '%c开源地址%c https://starfree.qxzhi.cn\n' +
                '%c用户交流群%c 1021506674\n' +
                '%c作者QQ%c 2504531378\n' +
                '%c开源协议%c MIT License',
                'color: #f6afe0;', 'color: #666;',
                'color: #f6afe0;', 'color: #666;',
                'color: #f6afe0;', 'color: #666;',
                'color: #f6afe0;', 'color: #666;',
                'color: #f6afe0;', 'color: #666;'
            );
            console.groupEnd();
            console.groupCollapsed('%c💫 版本信息', 'color: #f6afec; font-size: 14px; font-weight: bold;');
            console.log(
                '%c当前版本%c <?php echo $currentVersion; ?>\n' +
                '%c最新版本%c <?php echo $latestVersion; ?>',
                'color: #f6afe0;', 'color: #666;',
                'color: #f6afe0;', 'color: #666;'
            );
            console.groupEnd();
            console.log(
                '%c如果觉得不错的话，就给个star⭐支持一下吧！',
                'color: #666; font-style: italic;'
            );
       });
     /*
    * ###################################
    * ###本开源项目遵循MIT License协议###
    * ###您可以将项目用于合法的商业项目##
    * ###################################
    * ###为了项目后续更换的维护与更新####
    * ###请您保留原项目、作者版权信息####
    * ###################################
    */
</script>

</body>
</html>
