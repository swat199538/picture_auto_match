<?php
/**
 * Created by PhpStorm.
 * User: wangl
 * Date: 2018/9/11
 * Time: 16:26
 */

//描述文本
define('TEXT', [
    0 => '自动消除连连看程序将在倒计时完成后开始, 请手动激活游戏窗口！',
    1 => '开始！',
    2 => '图片未找到!',
    3 => '找到了游戏图片区域！',
    4 => '无法找到游戏区域',
    5 => '游戏结束',
]);

//是否输出调试信息
define('DEBUG', true);
define('FIND_GAME_ARE_INFO', '/findare.txt');


// 开始执行等待时间
define('SUSPEND_TIME', 0);

// 全屏图片保存位置
define('FULL_SCREEN_IMG', '/img/fullScreen.png');

// 游戏区域图片保存位置
define('GAME_ARE_IMG', '/img/gameare.png');
// 查找起始坐标可忽略点,加速查找起始坐标(已经使用了新的定位算法，可以忽略此选项)
define('SKIP_START_COLUMN', 0);//398
define('SKIP_START_ROW', 0);//153

// 游戏区域大小，根据自己的实际游戏窗口大小调整
define('GAME_ARE_WIDTH', 596);//596
define('GAME_ARE_HEIGHT', 392);//396

//游戏窗口误差
define('GAME_ARE_LIMIT', 0);

// 游戏背景颜色RGB，用来查找游戏区域
define('GAME_BACKGROUND_COLOR', [48, 76, 112]);

// 颜色相似误差值，查找游戏区域时使用
define('COLOR_LIMIT', 0);

// 连连看图标大小
define('GAME_ICON_HEIGHT', 35);
define('GAME_ICON_WEIGHT', 31);
//起点坐标与左上角第一个图片X误差值
define('GAME_ICON_WEIGHT_LIMIT', 2);
//起点坐标与左上角第一个图片Y误差值
define('GAME_ICON_HEIGHT_LIMIT', 2);

//游戏图片列间隔
define('GAME_ICON_WEIGHT_INTERVAL', 4);
//游戏图片行间隔
define('GAME_ICON_HEIGHT_INTERVAL', 4);

//有几行游戏图片
define('GAME_ICON_ROW', 11);
//有几列游戏图片
define('GAME_ICON_COLUMN', 19);
