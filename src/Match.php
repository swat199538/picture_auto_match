<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/13
 * Time: 17:40
 */

namespace AutoMatch;


use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\AverageHash;
use Jenssegers\ImageHash\Implementations\PerceptualHash;

class Match
{

    private $hasher;

    protected $gameArray;

    private $startX = 0;

    private $startY = 0;

    private $coupleCount = 0;

    private $row = 0;

    private $column = 0;

    private $rightPoint = [];

    public function __construct(array $gameArray)
    {
        $this->hasher = new ImageHash(new PerceptualHash());
        $this->gameArray = $gameArray;
    }

    public function clean()
    {
        $a = [];
        foreach ($this->gameArray as $row => $columnInfo){
            foreach ($columnInfo as $column => $pictureInfo){
                if ($this->gameArray[$row][$column]['color'] != ''){
                    $result = $this->rightScan($row, $column);
                    $a[] = $result;
                }
            }

        }
        var_dump($this->rightPoint);
//        var_dump($a);
        echo '结束了';
    }

    //扫描右侧
    public function rightScan($row, $column)
    {
        $aa = rand(0, 2000);

        $aa .= time();

        $colorHash = $this->hasher->hash( $this->gameArray[$row][$column]['icon']);

        $needScan = $this->column - $column;
        for ($i=$column+1; $i<$needScan; $i++){

            if ($this->gameArray[$row][$i]['color'] == ''){
                $this->rightPoint[] = [$row, $i];
                continue;
            }

            $thisHash = $this->hasher->hash($this->gameArray[$row][$i]['icon']);
            $diff = $this->hasher->distance($colorHash, $thisHash);

            if ($diff <= PICTURE_SIMILAR){

                Image::savePng($this->gameArray[$row][$column]['icon'], "./{$aa}-{$row}---{$column}.png");
                Image::savePng($this->gameArray[$row][$i]['icon'], "./{$aa}-{$row}---{$i}.png");

                echo "误差:{$diff},标识【{$aa}】,行{$row},列{$column}".PHP_EOL;
            }


            if ($row==0 || $row==$this->column){
                continue;
            }

            break;

        }

        return false;
    }

    /**
     * 设置游戏区域起始坐标点
     * @param $x
     * @param $y
     * @return $this
     */
    public function setStartCoordinate($x, $y)
    {
        $this->startX = $x;
        $this->startY = $y;
        return $this;
    }

    /**
     * 设置图片对数
     * @param $number
     * @return $this
     */
    public function setCoupleCount($number)
    {
        $this->coupleCount = $number;

        return $this;
    }

    /**
     * 设置游戏二维数组大小
     * @param $row
     * @param $column
     * @return $this
     */
    public function setGameSize($row, $column)
    {
        $this->row = $row;
        $this->column = $column;
        return $this;
    }

}