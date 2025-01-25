<?php
session_start();
include_once 'Menu.php';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">关于作者</h4>

                <div class="text-center">
                    <img src="<?php echo $ADMIN_PATH;?>/assets/images/avatar.jpg" class="rounded-circle avatar-lg img-thumbnail mb-4" alt="profile-image">
                    <h4 class="mb-0">StarDM Team</h4>
                    <p class="text-muted">Full Stack Developer</p>
                </div>

                <div class="mt-4">
                    <h5 class="font-weight-bold">项目介绍</h5>
                    <p class="text-muted mb-4">
                        StarDM是一个功能强大的社交媒体管理系统，致力于为用户提供最佳的社交媒体运营解决方案。我们的团队持续不断地进行优化和更新，以确保系统的稳定性和安全性。
                    </p>

                    <h5 class="font-weight-bold">技术栈</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <i class="mdi mdi-language-php font-24 text-primary"></i>
                                    <h5 class="mt-2">后端</h5>
                                    <p class="text-muted mb-0">PHP + MySQL</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <i class="mdi mdi-vuejs font-24 text-success"></i>
                                    <h5 class="mt-2">前端</h5>
                                    <p class="text-muted mb-0">Vue + uniapp</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <i class="mdi mdi-cloud font-24 text-info"></i>
                                    <h5 class="mt-2">云服务</h5>
                                    <p class="text-muted mb-0">多云存储支持</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="font-weight-bold">联系方式</h5>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <p><i class="mdi mdi-web mr-1"></i> 官网：<a href="https://www.stardm.cn" target="_blank">www.stardm.cn</a></p>
                            <p><i class="mdi mdi-email mr-1"></i> 邮箱：support@stardm.cn</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="mdi mdi-qqchat mr-1"></i> QQ群：123456789</p>
                            <p><i class="mdi mdi-wechat mr-1"></i> 微信：StarDM_Support</p>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4" role="alert">
                        <h4 class="alert-heading">特别说明</h4>
                        <p>1. 本系统仅用于正常商业用途</p>
                        <p>2. 请勿用于违法用途，否则后果自负</p>
                        <p>3. 如有问题欢迎通过以上方式联系我们</p>
                        <hr>
                        <p class="mb-0">感谢您的支持与信任！</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'Footer.php';
?> 