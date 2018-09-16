<?php
require './vendor/autoload.php';

use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\AverageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;
use Jenssegers\ImageHash\Implementations\PerceptualHash;
use AutoMatch\Image;

$colorHasher = new ImageHash(new AverageHash());
$diffHasher = new ImageHash(new DifferenceHash());
$preHasher = new ImageHash(new PerceptualHash());

$r1 = Image::createFromPng('./18351537107077-6---6.png');
$r2 = Image::createFromPng('./18351537107077-6---7.png');

$hash1 = $colorHasher ->hash($r1);
$hash2 = $colorHasher ->hash($r2);

$hash11 = $diffHasher->hash($r1);
$hash22 = $diffHasher->hash($r2);

$hash111 = $preHasher->hash($r1);
$hash222 = $preHasher->hash($r2);

echo $colorHasher->distance($hash1, $hash2).PHP_EOL;
echo $diffHasher->distance($hash1, $hash2).PHP_EOL;
echo $preHasher->distance($hash111, $hash222).PHP_EOL;