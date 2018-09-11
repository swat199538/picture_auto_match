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
    public static function width($picture)
    {
        return imagesx($picture);
    }


    /**
     * 获取图片的高度
     * @param $picture
     * @return int
     */
    public static function height($picture)
    {
        return imagesy($picture);
    }

}