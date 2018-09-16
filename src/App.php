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

    protected $gameArray = [];

    protected $doubleImage = 0;

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
     * @throws \Exception
     */
    protected function createGameModel()
    {
        $filename = $this->currentDirPath . GAME_ARE_IMG;

        if (!file_exists($filename)){
            throw new \Exception(TEXT[2],  2);
        }

        $game = Image::createFromPng($filename);

        //切割图片，别存储到一个二维数组中
        for($row=0; $row < GAME_ICON_ROW; $row++){
            for ($column=0; $column < GAME_ICON_COLUMN; $column++){

                $x = $column * GAME_ICON_WEIGHT + GAME_ICON_WEIGHT_INTERVAL;

                if ($column == 0){
                    $x += GAME_ICON_WEIGHT_LIMIT;
                }

                $y = $row * GAME_ICON_HEIGHT + GAME_ICON_HEIGHT_INTERVAL;

                if ($row == 0){
                    $y += GAME_ICON_HEIGHT_LIMIT;
                }

                $icon = Image::crop($game, $x, $y, GAME_ICON_WEIGHT, GAME_ICON_HEIGHT);

                //判断是否是空白图，判断方法，只要中心点是背景颜色(此实现图片过会有BUG)
                $iconWidth = Image::width($icon);
                $iconHeight = Image::height($icon);

                $rgb = Image::colorAt($icon, (int)($iconWidth/2), (int)($iconHeight/2));

                $rgb2 = Image::colorAt($icon, (int)($iconWidth/2 - IS_EMPTY_COLOR), (int)($iconHeight/2 - IS_EMPTY_COLOR));

                if (Image::colorSimilar(GAME_BACKGROUND_COLOR, $rgb) && Image::colorSimilar(GAME_BACKGROUND_COLOR, $rgb2)){

                    $this->gameArray[$row][$column] = [
                        'x'=>$x,
                        'y'=>$y,
                        'color'=>'',
                        'icon'=>$icon
                    ];
                } else{

                    $this->doubleImage++;

                    $filename = $this->currentDirPath . '/img/'.$this->doubleImage.'.png';

                    Image::savePng($icon, $filename);

                    $this->gameArray[$row][$column] = [
                        'x'=>$x,
                        'y'=>$y,
                        'color'=>Image::getData($icon),
                        'icon'=>$icon
                    ];

                }

            }
        }


        $coupleCount = $this->doubleImage % 2;

        $this->doubleImage = $this->doubleImage / 2 ;

        if ($coupleCount != 0){
            echo TEXT[6] . $this->doubleImage . PHP_EOL;
        }

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
        $this->fastFindGameAre($fullScreen);

        if ($this->startX===false || $this->startY===false){
            throw new \Exception(T_EXIT[4], 4);
        }

    }

    /**
     * @param $gameResource
     * @throws \Exception
     * @return void
     */
    protected function fastFindGameAre($gameResource):void
    {
        //获取图片宽度
        $fullScreenWidth = Image::width($gameResource);
        $fullScreenHeight = Image::height($gameResource);

        //需要扫描的列
        $needScanWidth = $fullScreenWidth - SKIP_START_COLUMN;

        //已经无法找到游戏区域了
        if ($needScanWidth < GAME_ARE_WIDTH){
            throw new \Exception(T_EXIT[4], 4);
        }

        //如果全屏和游戏的区域一样大，直接判断中间点颜色
//        if ($needScanWidth == 0){
//            //todo:实现中间点查找，基本不会出现这种情况，但还是要做。
//        }

        //计算出存在的几个关键列
        $keyPoint = (int)($needScanWidth / GAME_ARE_WIDTH);

        //循环行
        for ($row=SKIP_START_ROW;$row<$fullScreenHeight;$row++){

            //循环关键列
            for ($scan=0;$scan<$keyPoint;$scan++){

                //计算关键点在屏幕的X坐标
                $gameMiddle = (int)(GAME_ARE_WIDTH/2);
                $pointX = SKIP_START_COLUMN + ($scan*GAME_ARE_WIDTH) + $gameMiddle;

                //获取关键点坐标的颜色
                $lastRgb = Image::colorAt($gameResource, $pointX, $row);

                //判断关键点颜色是否和背景色相同
                if (Image::colorSimilar(GAME_BACKGROUND_COLOR, $lastRgb, COLOR_LIMIT)){

                    //从关键点同时往左右两端查找相同颜色，如果宽度和游戏区域宽度相同，即找到游戏区域
                    if ($this->findStartAndEnd($gameResource, $pointX, $row, $fullScreenWidth)){
                        break 2;
                    }

                }

            }
        }
    }


    /**
     * 查找头尾,如过找到游戏区域设置起始坐标
     * @param $gameResource
     * @param $pointX
     * @param $y
     * @param $width
     * @return bool
     */
    protected function findStartAndEnd($gameResource, $pointX, $y, $width):bool
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

            $game = Image::crop($gameResource, $left, $y, GAME_ARE_WIDTH, GAME_ARE_HEIGHT);
            Image::savePng($game, $this->currentDirPath . GAME_ARE_IMG);

            $this->startX = $left;
            $this->startY = $y;

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

        //创建游戏二维数组模型
        $this->createGameModel();

        //自动匹配图片
        $match = new Match($this->gameArray);
        $match->setStartCoordinate($this->startX, $this->startY)
            ->setCoupleCount($this->doubleImage)
            ->clean();

        echo TEXT[5] . PHP_EOL;
    }



}