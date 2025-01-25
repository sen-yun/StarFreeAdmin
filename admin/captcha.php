<?php
session_start();

function generateCaptcha($length = 4) {
    $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $captcha;
}

// 清理过期的验证码
if (isset($_SESSION['captcha_time']) && (time() - $_SESSION['captcha_time'] > 300)) {
    unset($_SESSION['captcha']);
    unset($_SESSION['captcha_time']);
}

$captcha = generateCaptcha();
$_SESSION['captcha'] = $captcha;
$_SESSION['captcha_time'] = time();
$image = imagecreatetruecolor(120, 40);
$bg_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);

for ($i = 0; $i < 3; $i++) {
    $line_color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
    imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
}

for ($i = 0; $i < 30; $i++) {
    $point_color = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
    imagesetpixel($image, rand(0, 120), rand(0, 40), $point_color);
}
$text_color = imagecolorallocate($image, 51, 51, 51);

$font_size = 20;
$x = 20;
for($i = 0; $i < strlen($captcha); $i++) {
    $y = rand(25, 30);
    $angle = rand(-15, 15);
    imagechar($image, 5, $x + ($i * 25), $y - 15, $captcha[$i], $text_color);
}

header('Content-type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
imagepng($image);
imagedestroy($image);
?>
