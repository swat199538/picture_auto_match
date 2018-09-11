<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/11
 * Time: 16:25
 */

namespace AutoMatch;


class App
{

    /**
     * @var string 当前文件夹路径
     */
    protected $currentDirPath = '';

    /**
     *  启动倒计时
     * @return void
     */
    protected function countdown():void
    {
        echo TEXT[0] . PHP_EOL;
        for($i=SUSPEND_TIME; $i > 0 ; $i--){
            echo $i . PHP_EOL;
            sleep(1);
        }
        echo TEXT[1] . PHP_EOL ;
    }


    /**
     * 开始运行
     *
     * @param string $path 当前文件所在文件夹路径
     *
     * @return void
     */
    public function run(string $path):void
    {
        //设置当前文件夹路径
        $this->currentDirPath = $path;

        //图片路径
        $filePath = $this->currentDirPath . FULL_SCREEN_IMG;

        //倒计时
        $this->countdown();

        //截取当前屏幕图像
        SysCall::printScreen($filePath);

        echo '233'.PHP_EOL;
    }



}