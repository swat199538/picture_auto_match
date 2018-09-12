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
     * @var string 起始坐标X点
     */
    protected $startX = false;

    /**
     * @var string 起始坐标Y点
     */
    protected $startY = false;

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

    protected function findGameAreAndSetStartPoint($gameResource):void
    {
        //获取图片宽度
        $fullScreenWidth = Image::width($gameResource);
        //获取图片高度
        $fullScreenHeight = Image::height($gameResource);

        //查找起始坐标点
        //遍历行
        for($row=SKIP_START_ROW; $row < $fullScreenHeight; $row++){
            //连续一行颜色的数量
            $continueColorCount = 0;

            //遍历列
            for ($column=SKIP_START_COLUMN; $column < $fullScreenWidth; $column++){
                // $column是x坐标，$row是y坐标，获取当前坐标颜色
                $lastRgb = Image::colorAt($gameResource, $column, $row);

                // 判断当前颜色是否和游戏背景颜色相似
                if ($result = Image::colorSimilar(GAME_BACKGROUND_COLOR, $lastRgb, COLOR_LIMIT)){

                    $continueColorCount++;

                    //找到了起始坐标点
                    if ($continueColorCount >= GAME_ARE_WIDTH - GAME_ARE_LIMIT){

                        //得到起始X点
                        $startX = $column - GAME_ARE_WIDTH;

                        //裁剪游戏区域
                        $gameAre = Image::crop($gameResource, $startX, $row, GAME_ARE_WIDTH, GAME_ARE_HEIGHT);

                        //保存游戏区域图片
                        Image::savePng($gameAre, $this->currentDirPath . GAME_ARE_IMG);

                        //设置起始X点
                        $this->startX = $startX;

                        //设置起始Y点
                        $this->startY = $row;

                        echo TEXT[3] . PHP_EOL;

                        break 2;
                    }

                } else{

                    //如果剩余宽度小于游戏窗口宽度了不用查找这一行了
                    if ($fullScreenWidth - $column < GAME_ARE_WIDTH){
                        break;
                    }

                    $continueColorCount = 0;
                }

                if (DEBUG){
                    echo $continueColorCount . PHP_EOL;
                    $content = $column.' '. $row.' '.$lastRgb[0].' '.$lastRgb[1].' '.$lastRgb[2].PHP_EOL;
                    file_put_contents($this->currentDirPath.FIND_GAME_ARE_INFO, $content, FILE_APPEND);
                }


            }
        }

        echo "{$this->startX},{$this->startY}".PHP_EOL;

    }

    /**
     * 加载游戏信息
     *
     * @param string $file
     * @throws \Exception
     */
    protected function loadGameInfo(string $file):void
    {
        //判断图片是否存在
        if (!file_exists($file)){
            throw new \Exception(TEXT[2]);
        }

        //获取图片资源
        $fullScreen = Image::createFromPng($file);

        //获取游戏区域并设置起始坐标点

        $start = time();
//        $this->findGameAreAndSetStartPoint($fullScreen);


        $this->fastFindGameAre($fullScreen);
        $end = time();

        $times = $end-$start;

        echo '耗时:'.$times.PHP_EOL;

        echo '233'.PHP_EOL;
        die();

        if ($this->startX===false || $this->startY===false){
            throw new \Exception(T_EXIT[4], 4);
        }

        //将游戏图片信息加载到一个二维数组中去

    }

    /**
     * @param $gameResource
     * @throws \Exception
     * @return bool
     */
    protected function fastFindGameAre($gameResource)
    {
        //获取图片宽度
        $fullScreenWidth = Image::width($gameResource);
        $fullScreenHeight = Image::height($gameResource);

        //需要扫描的列
        $needScanWidth = $fullScreenWidth - SKIP_START_COLUMN;

        //已经无法找到游戏区域了
        if ($needScanWidth < 0){
            throw new \Exception(T_EXIT[4], 4);
        }

        //如果全屏和游戏的区域一样大，直接判断中间点颜色
        if ($needScanWidth == 0){
            return true;
        }

        $keyPoint = (int)($needScanWidth / GAME_ARE_WIDTH);

        echo $needScanWidth.' '.GAME_ARE_WIDTH.' '.$keyPoint . PHP_EOL;

        for ($row=SKIP_START_ROW;$row<$fullScreenHeight;$row++){

            for ($scan=0;$scan<$keyPoint;$scan++){

                $gameMiddle = (int)(GAME_ARE_WIDTH/2);

                $pointX = SKIP_START_COLUMN + ($scan*GAME_ARE_WIDTH) + $gameMiddle;

                $lastRgb = Image::colorAt($gameResource, $pointX, $row);

                echo "{$pointX}, $row".PHP_EOL;

                if (Image::colorSimilar(GAME_BACKGROUND_COLOR, $lastRgb, COLOR_LIMIT)){

                    if ($this->findStartAndEnd($gameResource, $pointX, $row, $fullScreenWidth)){
                        break 2;
                    }

                }

            }
        }

        echo "快速定位完毕".PHP_EOL;
    }

    //查找头尾
    protected function findStartAndEnd($gameResource, $pointX, $y, $width)
    {


        $left = $pointX -1;
        $right = $pointX +1;

        $leftCount = 0;
        $rightCount = 0;

        for ($column=SKIP_START_COLUMN;$column<$width;$column++){

            if ($left > 0){
                $leftColor = Image::colorAt($gameResource, $left, $y);
                $leftColor = Image::colorSimilar(GAME_BACKGROUND_COLOR, $leftColor, COLOR_LIMIT);
            }else{
                $leftColor = false;
            }

            if ($right < $width){
                $rightColor = Image::colorAt($gameResource, $right, $y);
                $rightColor = Image::colorSimilar(GAME_BACKGROUND_COLOR, $rightColor, COLOR_LIMIT);
            }else{
                $rightColor = false;
            }



            if ($leftColor){
                $leftCount++;
                $left--;
            }

            if ($rightColor){
                $rightCount++;
                $right++;
            }

            if (!$leftColor && !$rightColor){
                break;
            }
        }

        $continueCount = $leftCount+$rightCount+GAME_ARE_LIMIT+1;


        if ($continueCount >= GAME_ARE_WIDTH){

            echo "233".PHP_EOL;

            $game = Image::crop($gameResource, $left, $y, GAME_ARE_WIDTH, GAME_ARE_HEIGHT);
            Image::savePng($game, $this->currentDirPath . GAME_ARE_IMG);

            $this->startX = $left;
            $this->startY = $left + GAME_ARE_WIDTH;

            return true;
        }

        return false;

    }

    /**
     * 开始运行
     *
     * @param string $path 当前文件所在文件夹路径
     *
     * @return void
     *
     * @throws \Exception
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

        //加载游戏信息
        $this->loadGameInfo($filePath);

    }



}