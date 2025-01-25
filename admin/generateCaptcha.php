<?php
session_start();
$captcha = substr(str_shuffle('1345689'), 0, 4);

$_SESSION['captcha'] = $captcha;

?>