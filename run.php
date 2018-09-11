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