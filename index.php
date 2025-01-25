<?php
include_once 'Config_DB.php';
$versionIni = parse_ini_file(__DIR__ . '/version.ini');
$currentVersion = $versionIni['version'] ?? '未知';
// 获取最新版本
function getLatestVersion() {
    global $API_NEW_VERSION;
    $url = $API_NEW_VERSION;
    
    $opts = [
        'http' => [
            'method' => 'GET',
            'timeout' => 3,
            'header' => "User-Agent: PHP\r\n"
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
        
    $context = stream_context_create($opts);
    
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        $error = error_get_last();
        return '获取失败';
    }
    
    $data = json_decode($result, true);
    
    if ($data['code'] == 1) {
        $newVersion = $data['data']['freeapiVersion'];
        return $newVersion;
    } else {
        return '获取失败';
    }
}

$latestVersion = getLatestVersion();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>StarFree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .cover {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #fff;
        }
        .cover-main {
            text-align: center;
        }
        h1 {
            margin-bottom: 2rem;
            font-size: 3.5rem;
        }
        .gradient-text {
            background: linear-gradient(90deg, rgba(247,174,223,1) 0%, rgba(237,180,233,1) 24%, rgba(250,212,223,1) 94%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            margin: 0.5rem;
            padding: 0.75em 2em;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        .btn-outline {
            border: 1px solid #f6afe0;
            color: #f6afe0;
        }
        .btn-primary {
            background-color: #f6afec;
            color: #fff;
            border: 1px solid #f4b0e2;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .version-info {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .protocol {
            margin-top: 1rem;
        }
        
        .protocol a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .protocol a:hover {
            color: #f6afe0;
        }
    </style>
</head>
<body>
    <section class="cover">
        <div class="cover-main">
            <h1><span class="gradient-text">StarFree</span></h1>
            <p>
                <a class="btn btn-outline" href="https://starpro.qxzhi.cn/" target="_blank">开源地址</a>
                <a class="btn btn-primary" href="https://www.yuque.com/senyun-ev0j3/starfree" target="_blank">官方文档</a>
            </p>
            <div class="version-info">
                当前版本：<?php echo htmlspecialchars($currentVersion); ?> | 最新版本：<?php echo htmlspecialchars($latestVersion); ?>
            </div>
            <div class="protocol">
                <a href="https://www.yuque.com/senyun-ev0j3/starfree/ncviwpghmmspvywe" target="_blank">许可协议 / 免责申明</a>
            </div>
        </div>
    </section>
    <script>
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