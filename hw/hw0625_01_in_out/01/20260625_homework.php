<?php

$foods = [
    '牛肉麵',
    '火鍋',
    '滷肉飯',
    '鹽酥雞',
    '義大利麵',
    '壽司',
    '麥當勞',
    '炒飯',
    '咖哩飯',
    '拉麵',
    '韓式炸雞',
    '肯德基',
    '丼飯',
    '生魚片',
    '涼麵',
    '鹹水雞',
    '便當',
    '摩斯',
    '乾麵',
    '早午餐'
];

$randomIndex = array_rand($foods);

$chosenFood = $foods[$randomIndex];

$result = [
    'food' => $chosenFood
];

echo json_encode($result);