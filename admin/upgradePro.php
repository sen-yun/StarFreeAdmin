<?php
session_start();
include_once 'Menu.php';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">升级到 Pro 版本</h4>

                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">当前程序: StarFree</h4>
                    <p class="mb-0">升级到Pro版本以解锁更多高级功能!</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-body">
                                <h3 class="card-title">Free 版本</h3>
                                <h6 class="card-subtitle text-muted">当前版本</h6>
                                <style>
                                    .text-success {
                                        color: #0cb300 !important;
                                    }
                                </style>
                                <ul class="list-unstyled mt-3">
                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">免费功能</h6>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Free版简约UI</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Free版强大后台</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Free版插件模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 论坛帖子模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 社交动态模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 知识付费模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 会员充值模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 可打包安卓/H5</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 缓慢持续更新</li>

                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">待解锁功能</h6>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 丰富的自定义UI排版</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 更强大的软件库</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 圈子体系模块</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 版主权限体系</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 智能AI模块</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 用户邀请码拉新</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 视频激励广告</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 文章资讯模块</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 每日任务模块</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 视频封面支持</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 带图评论支持</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 用户性别、实名、蓝V认证</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 自定义等级会员图标</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> Pro版插件、主题商城</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 免费解锁所有官方插件、主题</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 打包IOS/微信小程序</li>
                                    <li class="mb-2"><i class="mdi mdi-close-circle text-danger mr-2"></i> 作者售后服务支持</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border border-primary">
                            <div class="card-body">
                                <h3 class="card-title text-primary">Pro 版本</h3>
                                <h6 class="card-subtitle text-muted">推荐升级</h6>
                                
                                <ul class="list-unstyled mt-3">
                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">特色功能</h6>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Pro版专属唯美UI</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> Pro版高级独立后台</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 丰富的自定义UI排版</li>
                                    
                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">核心功能</h6>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 强大的软件库模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 强大的圈子帖子模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 完整的版主权限体系</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 强悍的智能AI模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 用户拉新激励模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 新增文章资讯模块</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 新增每日任务模块</li>
                                    
                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">增强功能</h6>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 新增视频封面、带图评论</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 用户新增性别、实名、蓝V认证</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 支持自定义等级会员图标</li>
                                    
                                    <h6 class="mt-4 mb-3 text-primary" style="color: #6c757d !important;">更多介绍</h6>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 更多的主题、插件</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 所有官方插件、主题免费</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> IOS/安卓/H5/微信小程序</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 后续永久免费包更新</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success mr-2"></i> 作者售后服务支持</li>

                                <div class="text-center mt-4">
                                    <div class="row">
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <a href="https://starpro.qxzhi.cn" target="_blank" class="btn btn-success w-100">了解更多</a>
                                        </div>
                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <a href="https://starpro.qxzhi.cn#demo" target="_blank" class="btn btn-success w-100">演示站</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="https://qm.qq.com/q/aqAwk2jTYQ" target="_blank" class="btn btn-success w-100">加官方群</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success mt-4" role="alert">
                    <h4 class="alert-heading">升级说明</h4>
                    <p>1. 升级可继承StarFree现有数据（包括官方的软件库插件）</p>
                    <p>2. 升级后解锁所有Pro高级功能</p>
                    <p>3. 升级后拥有售后服务支持</p>
                    <p>4. 升级后永久免费包更新</p>
                    <hr>
                    <p class="mb-0">如有疑问，请加入Star产品官方群了解更多，QQ群号：752454468【联系管理员-森云】</p>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
include_once 'Footer.php';
?> 