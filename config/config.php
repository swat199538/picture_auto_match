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
]);

// 开始执行等待使劲按
define('SUSPEND_TIME', 3);
// 全屏图片保存位置
define('FULL_SCREEN_IMG', '/img/fullScreen.png');
// 查找起始坐标跳过点,加速查找起始坐标
define('SKIP_START_X', 0);
define('SKIP_START_Y', 0);