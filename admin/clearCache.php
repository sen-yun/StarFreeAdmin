<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['loginadmin'])) {
    die("<script>alert('请先登录');window.location.href='".$ADMIN_PATH."/login.php';</script>");
}

include_once 'connect.php';

// 获取缓存设置
$sql = "SELECT * FROM ".$db_prefix."_settings WHERE id = 1";
$result = $connect->query($sql);
$settings = $result->fetch_assoc();

$cache_type = $settings['cache_type'] ?? 'file';
$success = false;

switch ($cache_type) {
    case 'redis':
        try {
            $redis = new Redis();
            $redis->connect($settings['redis_host'] ?? '127.0.0.1', $settings['redis_port'] ?? 6379);
            if (!empty($settings['redis_pass'])) {
                $redis->auth($settings['redis_pass']);
            }
            $redis->select($settings['redis_db'] ?? 0);
            
            // 清除所有以缓存前缀开头的键
            $prefix = $settings['cache_prefix'] ?? 'star_';
            $keys = $redis->keys($prefix . '*');
            if (!empty($keys)) {
                $redis->del($keys);
            }
            
            $redis->close();
            $success = true;
        } catch (Exception $e) {
            die("<script>alert('清除Redis缓存失败: " . $e->getMessage() . "');window.location.href='".$ADMIN_PATH."/setCache.php';</script>");
        }
        break;
        
    case 'memcached':
        if (class_exists('Memcached')) {
            try {
                $memcached = new Memcached();
                $memcached->addServer('127.0.0.1', 11211);
                $memcached->flush();
                $success = true;
            } catch (Exception $e) {
                die("<script>alert('清除Memcached缓存失败: " . $e->getMessage() . "');window.location.href='".$ADMIN_PATH."/setCache.php';</script>");
            }
        } else {
            die("<script>alert('Memcached扩展未安装');window.location.href='".$ADMIN_PATH."/setCache.php';</script>");
        }
        break;
        
    case 'file':
        $cache_dir = dirname(__FILE__) . '/../cache/';
        if (is_dir($cache_dir)) {
            $files = glob($cache_dir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $success = true;
        }
        break;
}

if ($success) {
    echo "<script>alert('缓存清除成功');window.location.href='".$ADMIN_PATH."/setCache.php';</script>";
} else {
    echo "<script>alert('缓存清除失败');window.location.href='".$ADMIN_PATH."/setCache.php';</script>";
}
?> 