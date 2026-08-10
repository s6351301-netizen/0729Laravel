<?php
// 接收前端的 GET 資料
$input = $_GET;

$data = $input;

// 讀取文字與次數
$text = $data['text'] ?? '';
$count = (int)($data['count'] ?? 0);

// 處理文字重複
$result = str_repeat($text, $count);

// 將結果塞回陣列
$data['result'] = $result;

// 回傳 JSON
echo json_encode($data);
