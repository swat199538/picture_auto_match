<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/12/12
 * Time: 13:21
 */

class testGame
{

    private $chessBorad = [
        [0, 0, 0, 0, 2, 6, 6, 0, 0, 0, 2, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0],
        [0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    ];


    public function start()
    {

        $this->show();

        for ($y=0; $y < 12; $y++){
            for ($x=0; $x < 12; $x++){
                $nowPoint = $this->chessBorad[$y][$x];

                //判断当前坐标点是否是未空为空就继续下用过点
                if ($nowPoint == 0){
                    continue;
                }

                //清除右边
                $result = $this->directRight($x, $y, $nowPoint);
                if (is_array($result)){
                    $this->chessBorad[$y][$x] = 0;
                    echo "{$x},{$y} 清零".PHP_EOL;
                    $this->chessBorad[$result[1]][$result[0]] = 0;
                    echo "{$result[0]},{$result[1]} 清零".PHP_EOL;
                    $this->show();
                    continue;
                }

                //清除左边
                $result = $this->directLeft($x, $y, $nowPoint);
                if (is_array($result)){
                    $this->chessBorad[$y][$x] = 0;
                    echo "{$x},{$y} 清零".PHP_EOL;
                    $this->chessBorad[$result[1]][$result[0]] = 0;
                    echo "{$result[0]},{$result[1]} 清零".PHP_EOL;
                    $this->show();
                    continue;
                }

                //清除下边
                $result = $this->directDown($x, $y, $nowPoint);
                if (is_array($result)){
                    $this->chessBorad[$y][$x] = 0;
                    echo "{$x},{$y} 清零".PHP_EOL;
                    $this->chessBorad[$result[1]][$result[0]] = 0;
                    echo "{$result[0]},{$result[1]} 清零".PHP_EOL;
                    $this->show();
                    continue;
                }

            }
        }

    }

    //右直连
    private function directRight($x, $y, $value)
    {
        //1.往右边移动查看值是否相等
        //2.如果不等，判断右边是否是空，不为空除非是特殊的边线坐标否则不在遍历
        for ($nowX = $x + 1; $nowX < 12; $nowX++){

            //右边一位值
            $nowPointValue = $this->chessBorad[$y][$nowX];

            //判断右边是否为空
            if ($nowPointValue == 0){
                continue;
            }

            //不为空判断是否相等
            if ($nowPointValue == $value){
                echo "值{$value}匹配到相同坐标:{$x},{$y}-{$nowX},{$y}" . PHP_EOL;
                return [$nowX, $y];
            }

            //判断是否上下边界，是继续往右判断，不是终止判断
            if ($y == 0 || $y == 11){
                continue;
            }

            echo "没有 ------" . PHP_EOL;

            return false;
        }

        return false;
    }

    //左直连
    private function directLeft($x, $y, $value)
    {
        for ($nowX = $x - 1; $x < 0; $x--){
            //左边一位值
            $nowPointValue = $this->chessBorad[$y][$nowX];

            //为空
            if ($nowPointValue == 0){
                continue;
            }

            //不为空判断是否相等
            if ($nowPointValue == $value){
                echo "值{$value}匹配到相同坐标:{$x},{$y}-{$nowX},{$y}" . PHP_EOL;
                return [$nowX, $y];
            }

            //判断是否上下边界，是继续往右判断，不是终止判断
            if ($y == 0 || $y == 11){
                continue;
            }

            echo "没有 ------" . PHP_EOL;

            return false;

        }
        return false;
    }

    //下直连
    private function directDown($x, $y, $value)
    {
        for ($nowY = $y+1; $nowY < 12; $nowY++){

        }
    }


    //匹配相同字符并显示
    private function show()
    {
        for ($y =0; $y < 12; $y ++){
            $str = '';
            for ($x =0; $x < 12; $x++){
                $str .= $this->chessBorad[$y][$x] . ' ';
            }
            echo $str . PHP_EOL;
        }

        echo PHP_EOL . PHP_EOL;
    }


}

(new testGame())->start();