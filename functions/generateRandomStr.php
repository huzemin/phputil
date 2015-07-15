<?php
/**
 * 1. 实现随机各式各样的字符串
 * 2. 纯数字随机
 * 3. 纯字母随机
 * 4. 数字字母混合随机
 * 5. 自定数据集合随机
 *
 * 随机函数使用 mt_rand();
 */

 // PHP的rand() 于mt_rnad() 性能测试
 // $time = microtime(true);
 //     for ($i=0; $i < 100000; $i++) {
 //         rand();
 //     }
 // $time2 = microtime(true);
 //
 //     for ($i=0; $i < 100000; $i++) {
 //         mt_rand();
 //     }
 //
 // $time3 = microtime(true);
 //
 //
 // echo $time2 - $time . "<br />";
 //
 // echo $time3 - $time2 ."<br />";
 //
 // --------------------------------
 // mt_rand() 性能差不多要比rand()快一倍以上


function generateRandomStr($length = 8, $type="mix", $extend_source = null, $custom_data_source = null) {

    $number_source = "0123456789";
    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    if($type == "mix") {
        $source = $number_source . $alphabet;
    }
    if($type == "num") {
        $source = $number_source;
    }
    if($type == "alp") {
        $source = $alphabet;
    }

    if($type == "custom") {
        $source = $custom_data_source;
    }
    if(isset($extend_source)) {
        $source .= $extend_source;
    }

    $max = strlen($source) - 1;
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $pos = mt_rand(0, $max);
        $result .= $source[$pos];
    }

    return $result;
}

function generate_password($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKL"
        ."MNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|";
    $password = "";
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password.= $chars[mt_rand(0, $max) ];
    }
    return $password;
}

//=============================

$time = microtime(true);
for ($i=0; $i < 100000; $i++) {
    generateRandomStr(8, 'mix', '!@#$%^&*()-_ []{}<>~`+=,.;:/?|');
}
$time2 = microtime(true);
for ($i=0; $i < 100000; $i++) {
    generate_password(8);
}
$time3 = microtime(true);


echo $time2 - $time . "<br />";

echo $time3 - $time2 ."<br />";

/*==========================
 * 2.5009999275208
 * 2.3229999542236
 *=========================*/
?>
