<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/11
 * Time: 17:21
 */

namespace AutoMatch;


class Image
{
    /**
     * 根据知道图片获取图片资源
     *
     * @param $file
     * @return resource
     */
    public static function createFromPng($file)
    {
        return imagecreatefrompng($file);
    }


    /**
     * 获取图片的宽度
     * @param $picture
     * @return int
     */
    public static function width($picture):int
    {
        return imagesx($picture);
    }


    /**
     * 获取图片的高度
     * @param $picture
     * @return int
     */
    public static function height($picture):int
    {
        return imagesy($picture);
    }


    /**
     * 获取颜色rgb值数组
     * @param $image
     * @param $x
     * @param $y
     * @return array
     */
    public static function colorAt($image, $x, $y):array
    {
        $rgb = imagecolorat($image, $x, $y);

        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        return [$r, $g, $b];
    }

    /**
     * 判断颜色是否相近
     * @param array $color1
     * @param array $color2
     * @param int $limit
     * @return bool
     */
    public static function colorSimilar(array $color1, array $color2, int $limit=0):bool
    {
        if (empty($color1) || empty($color2)){
            return false;
        }

        //比较思路， 颜色1的r减去颜色2的r的差值小于误差并且颜色1的g减去颜色2的g的差值小于误差
        //颜色1的b减去颜色2的b的差值小于误差即为相似，否则不相似
        if (abs($color2[0]-$color1[0])<=$limit && abs($color2[0]-$color1[0])<=$limit && abs($color2[0]-$color1[0])<=$limit){
            return  true;
        }

        return false;
    }

    /**
     * 裁剪图片
     * @param $img
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return bool|resource
     */
    public static function crop($img, $x, $y, $width, $height)
    {
        return imagecrop($img, ['x'=>$x, 'y'=>$y, 'width'=>$width, 'height'=>$height]);
    }

    /**
     * 讲图片保存为PNG
     * @param $img
     * @param $filename
     * @return bool
     */
    public static function savePng($img, $filename)
    {
        return imagepng($img, $filename);
    }


}