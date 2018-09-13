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

    public function __construct(array $gameArray)
    {
        $this->gameArray = new $gameArray;
    }

    public function clean()
    {
        foreach ($this->gameArray as $row => $columnInfo){
            foreach ($columnInfo as $column => $pictureInfo){

            }
        }
    }


    protected function rightLine()
    {

    }

    protected function lefLine()
    {

    }

    protected function underVertical(){}

    protected function upVertical(){}

}