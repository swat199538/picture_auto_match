<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/11
 * Time: 15:38
 */

require './vendor/autoload.php';

try{
    (new \AutoMatch\App())->run(__DIR__);
} catch (\Exception $e){
    echo $e->getMessage() . PHP_EOL;
}
//
//use Jenssegers\ImageHash\ImageHash;
//use Jenssegers\ImageHash\Implementations\AverageHash;
//use Jenssegers\ImageHash\Implementations\DifferenceHash;
//use AutoMatch\Image;
//
//$colorHasher = new ImageHash(new AverageHash());
//$diffHasher = new ImageHash(new DifferenceHash());
//
//$r1 = Image::createFromPng('./img/128.png');
//$r2 = Image::createFromPng('./img/129.png');
//
//$hash1 = $colorHasher ->hash($r1);
//$hash2 = $colorHasher ->hash($r2);
//
//$hash11 = $diffHasher->hash($r1);
//$hash22 = $diffHasher->hash($r2);
//
//echo $colorHasher->distance($hash1, $hash2).PHP_EOL;
//echo $diffHasher->distance($hash1, $hash2).PHP_EOL;