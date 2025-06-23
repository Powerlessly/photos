<?php
// 生成 UUID 函数
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

// 定义图片保存目录
$uploadDir = 'img-one/';

// 检查目录是否存在，如果不存在则创建
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 删除 img-one 文件夹下的所有图片
$files = glob($uploadDir . '*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

// 定义图片命名列表
$imageNames = ['01', '1', '2', '02', '3', '03', '04', '4', '05', '5', '06', '6'];

// 初始化响应数组
$response = [
    'success' => true,
    'message' => ''
];

// 检查是否有文件上传
if (!empty($_FILES['images'])) {
    $fileCount = count($_FILES['images']['tmp_name']);
    for ($i = 0; $i < $fileCount; $i++) {
        if ($i >= count($imageNames)) {
            // 如果上传的文件数量超过命名列表的长度，跳出循环
            break;
        }
        $tmpName = $_FILES['images']['tmp_name'][$i];
        // 生成新的文件名
        $newName = $imageNames[$i] . '.jpg';
        $destination = $uploadDir . $newName;

        // 移动上传的文件到指定目录
        if (move_uploaded_file($tmpName, $destination)) {
            // 文件移动成功
        } else {
            $response['success'] = false;
            $response['message'] = '无法保存文件: ' . $newName;
            break;
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = '没有文件上传';
}

// 返回 JSON 响应
header('Content-Type: application/json');
echo json_encode($response);
?>