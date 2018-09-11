<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/11
 * Time: 15:32
 */
namespace AutoMatch;

class SysCall
{
    public static function printScreen($path)
    {
        exec('python ./bin/printScreen.py '.$path, $output, $return);
    }

    public static function clickScreen($x, $y)
    {

    }
}