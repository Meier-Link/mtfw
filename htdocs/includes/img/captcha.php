<?php

session_start();

(isset($_GET['w'])) ? $w = $_GET['w'] : $w = 215;

$h       = $w / 2.2;
$charset = 'ABCDEFGHKLMNPRSTUVWYZabcdefhkmnprstuvwyz2345678';

if(is_null($_SESSION['captcha']))
{
  $captcha = "";
  for ($i = 0; $i < 6; $i++)
  {
    $char_pos = rand(0, strlen($charset) - 1);
    $captcha .= $charset[$char_pos];
  }
  $_SESSION['captcha'] = $captcha;
}
else
{
  $captcha = $_SESSION['captcha'];
}

  $image   = imagecreate($w, $h);
//$font = rand(1, 5);

$bg    = imageColorAllocate($image,40,40,40);
/*
$fg    = imageColorAllocate($image,45,45,90);
$blanc = imageColorAllocate($image,255,255,255);
$bleu  = imageColorAllocate($image,0,0,255);
$noir  = imageColorAllocate($image,0,0,0);
$vert  = imageColorAllocate($image,0,157,160);
$jaune = imageColorAllocate($image,220,232,29);
*/

/*
$fg[0] = imageColorAllocate($image,45,45,90);
$fg[1] = imageColorAllocate($image,0,0,255);
$fg[2] = imageColorAllocate($image,117,77,29);
$fg[3] = imageColorAllocate($image,45,45,125);
$fg[4] = imageColorAllocate($image,0,0,90);
$fg[5] = imageColorAllocate($image,10,10,10);
$fg[6] = imageColorAllocate($image,0,157,160);
*/
$fg[0] = imageColorAllocate($image,30,30,0);
$fg[1] = imageColorAllocate($image,30,0,30);
$fg[2] = imageColorAllocate($image,0,30,30);
$fg[3] = imageColorAllocate($image,0,0,30);
$fg[4] = imageColorAllocate($image,0,30,0);
$fg[5] = imageColorAllocate($image,30,0,0);
$fg[6] = imageColorAllocate($image,45,45,90);

for ($i = 0; $i < 7; $i++)
{
  $c = rand(0, 6);
  imageline($image,
    rand(0, $w), rand(0, $h),
    rand(0, $w), rand(0, $h),
    $fg[$c]
  );
}

$space = 0;
for ($i = 0; $i < strlen($_SESSION['captcha']); $i++)
{
  $c = rand(0, 6);
  imagettftext($image, rand(18, 22), 0, 10 + $space, $h - $h / 3, $fg[$c], '../AHGBold.ttf', $captcha[$i]);
  (preg_match('/[a-z]/', $_SESSION['captcha'][$i])) ? $space += 20 : $space += 22;
}

imageJpeg($image);
imageDestroy($image);
