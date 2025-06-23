<?php
// 定义图片文件夹路径
$imageDir = 'img-one/';

// 获取该文件夹下所有指定格式的图片文件
$files = glob($imageDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

$minliData = [];
$maxliData = [];

// 为小盒子和大盒子分别准备数据
foreach ($files as $index => $file) {
    if ($index < 6) {
        $minliData[] = ['url' => $file];
    } elseif ($index < 12) {
        $maxliData[] = ['url' => $file];
    } else {
        break;
    }
}

// 构建响应数据
$response = [
    'minliData' => $minliData,
    'maxliData' => $maxliData
];

// 设置响应头并返回 JSON 数据
header('Content-Type: application/json');
echo json_encode($response);
?>