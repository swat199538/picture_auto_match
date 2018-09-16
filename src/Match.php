<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/13
 * Time: 17:40
 */

namespace AutoMatch;


class Match
{

    protected $gameArray;

    private $startX = 0;

    private $startY = 0;

    private $coupleCount = 0;

    protected $matchOne = [
        'x'=>'',
        'y'=>''
    ];

    protected $matchTwo = [
        'x'=>'',
        'y'=>''
    ];

    public function __construct(array $gameArray)
    {
        $this->gameArray = $gameArray;
    }

    public function clean()
    {
        var_dump($this->coupleCount);
        die();
        foreach ($this->gameArray as $row => $columnInfo){
            foreach ($columnInfo as $column => $pictureInfo){

                $color = $this->gameArray[$row][$column]['color'];

                if ($color == ''){
                    continue;
                }

            }
        }
        echo '结束了';
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

}