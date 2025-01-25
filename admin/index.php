<?php
include_once 'Menu.php';

if (isset($_GET['action']) && $_GET['action'] === 'getRegistrationData') {
    header('Content-Type: application/json');
    
    try {
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $days = min(max($days, 1), 180); 
        
        $data = array(
            'dates' => array(),
            'counts' => array()
        );
        
        for ($i = ($days - 1); $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $data['dates'][] = date('m-d', strtotime("-$i days"));
            
            $query = "SELECT COUNT(*) as count FROM ".$db_prefix."_users WHERE DATE(FROM_UNIXTIME(created)) = ?";
            $stmt = $connect->prepare($query);
            if (!$stmt) {
                throw new Exception('准备语句失败: ' . $connect->error);
            }
            
            $stmt->bind_param("s", $date);
            if (!$stmt->execute()) {
                throw new Exception('执行查询失败: ' . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $data['counts'][] = intval($row['count']);
            $stmt->close();
        }
        
        echo json_encode($data);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// 签到统计
$today = date('Y-m-d');
$signCountQuery = "SELECT COUNT(*) AS signCount FROM ".$db_prefix."_admin_Signinlog WHERE DATE(time) = ?";
$stmt = $connect->prepare($signCountQuery);
if (!$stmt) {
    die("准备语句失败: " . $connect->error);
}
$stmt->bind_param("s", $today);
$stmt->execute();
$signResult = $stmt->get_result();
if (!$signResult) {
    die("获取结果失败: " . $stmt->error);
}
$signRow = $signResult->fetch_assoc();
$totalSignCount = $signRow['signCount'];

// 评论统计
$commentCountQuery = "SELECT COUNT(*) AS commentCount FROM ".$db_prefix."_comments WHERE DATE(FROM_UNIXTIME(created)) = ?";
$stmt = $connect->prepare($commentCountQuery);
if (!$stmt) {
    die("准备语句失败: " . $connect->error);
}
$stmt->bind_param("s", $today);
$stmt->execute();
$commentResult = $stmt->get_result();
if (!$commentResult) {
    die("获取结果失败: " . $stmt->error);
}
$commentRow = $commentResult->fetch_assoc();
$totalCommentCount = $commentRow['commentCount'];

// 格式化签到统计结果
if ($totalSignCount >= 1000 && $totalSignCount < 10000) {
    $totalSignCount = number_format($totalSignCount / 1000, 1) . 'k';
} elseif ($totalSignCount >= 10000) {
    $totalSignCount = number_format($totalSignCount / 10000, 1) . 'w';
}

// 格式化评论统计结果
if ($totalCommentCount >= 1000 && $totalCommentCount < 10000) {
    $totalCommentCount = number_format($totalCommentCount / 1000, 1) . 'k';
} elseif ($totalCommentCount >= 10000) {
    $totalCommentCount = number_format($totalCommentCount / 10000, 1) . 'w';
}


// 用户总数统计
$totalUsersQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_users";
$result = mysqli_query($connect, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($result)['total'];

// 帖子总数统计
$totalPostsQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_contents";
$result = mysqli_query($connect, $totalPostsQuery);
$totalPosts = mysqli_fetch_assoc($result)['total'];

// 评论总数统计
$totalCommentsQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_comments";
$result = mysqli_query($connect, $totalCommentsQuery);
$totalComments = mysqli_fetch_assoc($result)['total'];

// 获取近7天的新增数据
$sevenDaysUsersQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_users WHERE created >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))";
$result = mysqli_query($connect, $sevenDaysUsersQuery);
$sevenDaysUsers = mysqli_fetch_assoc($result)['total'];

$sevenDaysPostsQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_contents WHERE created >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))";
$result = mysqli_query($connect, $sevenDaysPostsQuery);
$sevenDaysPosts = mysqli_fetch_assoc($result)['total'];

$sevenDaysCommentsQuery = "SELECT COUNT(*) AS total FROM ".$db_prefix."_comments WHERE created >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))";
$result = mysqli_query($connect, $sevenDaysCommentsQuery);
$sevenDaysComments = mysqli_fetch_assoc($result)['total'];

// 格式化大数字
function formatNumber($num) {
    if ($num >= 10000) {
        return number_format($num / 10000, 1) . 'w';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 1) . 'k';
    }
    return $num;
}

$totalUsers = formatNumber($totalUsers);
$totalPosts = formatNumber($totalPosts);
$totalComments = formatNumber($totalComments);
$sevenDaysUsers = formatNumber($sevenDaysUsers);
$sevenDaysPosts = formatNumber($sevenDaysPosts);
$sevenDaysComments = formatNumber($sevenDaysComments);

// 获取近7天的数据趋势
function getLastSevenDaysData($connect, $db_prefix, $type) {
    $data = array();
    $total = 0; 
    
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        
        switch($type) {
            case 'signin':
                $query = "SELECT COUNT(*) as count FROM ".$db_prefix."_admin_Signinlog WHERE DATE(time) = ?";
                break;
            case 'comment':
                $query = "SELECT COUNT(*) as count FROM ".$db_prefix."_comments WHERE DATE(FROM_UNIXTIME(created)) = ?";
                break;
            case 'post':
                $query = "SELECT COUNT(*) as count FROM ".$db_prefix."_contents WHERE DATE(FROM_UNIXTIME(created)) = ?";
                break;
            case 'user':
                $query = "SELECT COUNT(*) as count FROM ".$db_prefix."_users WHERE DATE(FROM_UNIXTIME(created)) = ?";
                break;
        }
        
        $stmt = $connect->prepare($query);
        if (!$stmt) {
            die("准备语句失败: " . $connect->error);
        }
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = intval($row['count']);
        $data[] = $count;
        $total += $count;
    }
    
    return array(
        'trend' => $data,
        'total' => $total
    );
}

// 获取各类型的7天趋势数据
$userData = getLastSevenDaysData($connect, $db_prefix, 'user');
$signinData = getLastSevenDaysData($connect, $db_prefix, 'signin');
$commentData = getLastSevenDaysData($connect, $db_prefix, 'comment');
$postData = getLastSevenDaysData($connect, $db_prefix, 'post');

// 获取今日活跃用户数
$todayActiveUsersQuery = "SELECT COUNT(*) AS active_users 
                         FROM ".$db_prefix."_users 
                         WHERE DATE(FROM_UNIXTIME(posttime)) = CURDATE()";
$result = mysqli_query($connect, $todayActiveUsersQuery);
$activeUsersRow = mysqli_fetch_assoc($result);
$todayActiveUsers = formatNumber($activeUsersRow['active_users']);

// 获取近7天活跃用户趋势
function getActiveUsersTrend($connect, $db_prefix) {
    $data = array();
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $query = "SELECT COUNT(*) as count 
                 FROM ".$db_prefix."_users 
                 WHERE DATE(FROM_UNIXTIME(posttime)) = ?";
        
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $data[] = intval($row['count']);
    }
    return $data;
}

$activeUsersTrend = getActiveUsersTrend($connect, $db_prefix);


?>


<!-- 今日数据统计卡片 -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">今日数据概览</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon signin-icon">
                                    <i class="dripicons-calendar"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $totalSignCount; ?></h3>
                                    <p class="stats-label">今日签到</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="today-signin-chart"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon today-active-icon">
                                    <i class="dripicons-pulse"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $todayActiveUsers; ?></h3>
                                    <p class="stats-label">今日活跃</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="today-active-chart"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon today-comments-icon">
                                    <i class="dripicons-message"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $totalCommentCount; ?></h3>
                                    <p class="stats-label">今日评论</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="today-comments-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 总体数据统计卡片 -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">网站数据概览</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon users-icon">
                                    <i class="dripicons-user-group"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $totalUsers; ?></h3>
                                    <p class="stats-label">总用户数</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="total-users-chart"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon posts-icon">
                                    <i class="dripicons-document-remove"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $totalPosts; ?></h3>
                                    <p class="stats-label">总帖子数</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="total-posts-chart"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box">
                            <div class="stats-content">
                                <div class="stats-icon comments-icon">
                                    <i class="dripicons-conversation"></i>
                                </div>
                                <div class="stats-data">
                                    <h3 class="stats-number"><?php echo $totalComments; ?></h3>
                                    <p class="stats-label">总评论数</p>
                                </div>
                            </div>
                            <p class="stats-subtext">近7天趋势</p>
                            <div class="stats-chart" id="total-comments-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 用户注册统计图表 -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="header-title">用户注册统计</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-soft-primary btn-sm active" onclick="updateChart(7)">近7天</button>
                        <button type="button" class="btn btn-soft-primary btn-sm" onclick="updateChart(30)">近30天</button>
                        <button type="button" class="btn btn-soft-primary btn-sm" onclick="updateChart(180)">近6个月</button>
                    </div>
                </div>
                <div id="user-registration-chart" style="height: 350px;"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $ADMIN_PATH;?>/assets/js/vendor/apexcharts.min.js"></script>

<script>
var userChart;
var sparklineOptions = {
    chart: {
        type: 'area',
        height: 50,
        sparkline: {
            enabled: true
        },
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    fill: {
        opacity: 0.3,
    },
    tooltip: {
        fixed: {
            enabled: false
        },
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return '';
                }
            }
        },
        marker: {
            show: false
        }
    }
};

var userChartOptions = {
    series: [{
        name: '新注册用户',
        data: <?php echo json_encode($userData['trend']); ?>
    }],
    chart: {
        type: 'line',
        height: 350,
        toolbar: {
            show: false
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    xaxis: {
        categories: <?php echo json_encode(array_map(function($i) { 
            return date('m-d', strtotime("-$i days")); 
        }, range(6, 0, -1))); ?>,
        labels: {
            style: {
                fontSize: '10px'
            },
            rotate: -45,
            rotateAlways: false,
            hideOverlappingLabels: true,
            maxHeight: 100
        }
    },
    yaxis: {
        min: 0,
        tickAmount: 5,
        labels: {
            formatter: function(val) {
                return Math.floor(val);
            }
        }
    },
    colors: ['#727cf5'],
    dataLabels: {
        enabled: false
    },
    grid: {
        padding: {
            left: 0,
            right: 0
        },
        borderColor: '#f1f3fa'
    },
    tooltip: {
        y: {
            formatter: function(val) {
                return Math.floor(val) + " 人";
            }
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    try {
        const chartElement = document.querySelector("#user-registration-chart");
        if (chartElement) {
            userChart = new ApexCharts(chartElement, userChartOptions);
            userChart.render();
            
            updateChart(7);
        } else {
            console.error('找不到用户注册图表容器');
        }

        const chartConfigs = [
            {
                id: 'total-users-chart',
                data: <?php echo json_encode($userData['trend']); ?>,
                color: '#727cf5'
            },
            {
                id: 'total-posts-chart',
                data: <?php echo json_encode($postData['trend']); ?>,
                color: '#0acf97'
            },
            {
                id: 'total-comments-chart',
                data: <?php echo json_encode($commentData['trend']); ?>,
                color: '#fa5c7c'
            },
            {
                id: 'today-signin-chart',
                data: <?php echo json_encode($signinData['trend']); ?>,
                color: '#ff6b6b'
            },
            {
                id: 'today-active-chart',
                data: <?php echo json_encode($activeUsersTrend); ?>,
                color: '#ffd93d'
            },
            {
                id: 'today-comments-chart',
                data: <?php echo json_encode($commentData['trend']); ?>,
                color: '#4ecdc4'
            }
        ];

        chartConfigs.forEach(config => {
            const element = document.querySelector(`#${config.id}`);
            if (element) {
                new ApexCharts(element, {
                    ...sparklineOptions,
                    colors: [config.color],
                    series: [{
                        data: config.data
                    }]
                }).render();
            }
        });

        console.log('所有图表初始化完成');
    } catch (error) {
        console.error('图表初始化错误:', error);
    }
});

function updateChart(days) {
    if (!userChart) {
        console.error('图表未初始化');
        return;
    }

    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.textContent.includes(days)) {
            btn.classList.add('active');
        }
    });
    
    userChart.updateOptions({
        chart: {
            animations: {
                enabled: false
            }
        }
    });
    
    fetch('<?php echo $ADMIN_PATH;?>/getSignIns.php?dataType=registrations&days=' + days)
        .then(response => {
            if (!response.ok) {
                throw new Error('网络响应错误');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            
            userChart.updateOptions({
                xaxis: {
                    categories: data.dates,
                    labels: {
                        style: {
                            fontSize: '10px'
                        },
                        rotate: -45,
                        rotateAlways: false,
                        hideOverlappingLabels: true,
                        maxHeight: 100
                    }
                },
                chart: {
                    animations: {
                        enabled: true
                    }
                }
            });
            userChart.updateSeries([{
                name: '新注册用户',
                data: data.counts
            }]);
        })
        .catch(error => {
            console.error('更新图表数据失败:', error);
            if (error.message) {
                alert('获取数据失败: ' + error.message);
            } else {
                alert('获取数据失败，请稍后重试');
            }
        });
}
</script>

<style>
h3{
    margin: 3px 0;
}
.btn-group {
    background-color: #f5f6f8;
    border-radius: 4px;
    padding: 3px;
}

.btn-group .btn {
    border: none;
    padding: 0.3rem 1rem;
    font-size: 0.875rem;
    margin: 0 2px;
    border-radius: 4px;
    transition: all 0.2s;
}

.btn-soft-primary {
    color: #727cf5;
    background-color: transparent;
}

.btn-soft-primary:hover {
    color: #fff;
    background-color: #727cf5;
}

.btn-soft-primary.active {
    color: #fff;
    background-color: #727cf5;
}

.header-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
}

@media (max-width: 768px) {
    .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .card {
        margin-bottom: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    h3 {
        font-size: 1.5rem;
        
    }
    
    h5 {
        font-size: 0.9rem;
    }
}

.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    border: none;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.text-muted {
    color: #98a6ad !important;
}

h3 i {
    font-style: normal;
    font-size: 1rem;
    color: #98a6ad;
    margin-left: 0.3rem;
    
}

.stats-box {
    position: relative;
    padding: 1.5rem;
    border-radius: 0.5rem;
    background: linear-gradient(145deg, #ffffff, #f5f7fa);
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.stats-box:hover {
    transform: translateY(-5px);
}

.stats-content {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.stats-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.users-icon {
    background: linear-gradient(45deg, #727cf5, #8f94fb);
}

.posts-icon {
    background: linear-gradient(45deg, #0acf97, #2af598);
}

.comments-icon {
    background: linear-gradient(45deg, #fa5c7c, #ff8a9b);
}

.signin-icon {
    background: linear-gradient(45deg, #ff6b6b, #ff8787);
}

.today-posts-icon {
    background: linear-gradient(45deg, #ffd93d, #ffe066);
}

.today-comments-icon {
    background: linear-gradient(45deg, #4ecdc4, #6be5db);
}

.today-active-icon {
    background: linear-gradient(45deg, #ffd93d, #ffe066);
}

.stats-label {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.stats-chart {
    margin-top: 1rem;
    opacity: 0.7;
}

@media (max-width: 768px) {
    .stats-box {
        padding: 1rem;
    }
    
    .stats-icon {
        width: 40px;
        height: 40px;
    }
    
    .stats-icon i {
        font-size: 1.25rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
}

.stats-subtext {
    color: #98a6ad;
    font-size: 0.8rem;
    margin: 0;
}
</style>


<?php
include_once 'Footer.php';
?>

</body>
</html>