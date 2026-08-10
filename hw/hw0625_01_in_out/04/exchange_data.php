<?php
// 接收前端請求
$input = $_GET;

$amount = $input['amount'] ?? 100;
$currency = $input['currency'] ?? 'USD';

// 模擬匯率資料 (實際應用可對接 API)
$rates = [
    'USD' => 32.5,
    'JPY' => 0.21,
    'EUR' => 35.2
];

$rate = $rates[$currency] ?? 1.0;
$result = $amount * $rate;

$data = [
    'amount' => $amount,
    'currency' => $currency,
    'rate' => $rate,
    'result' => $result,
    'timestamp' => date('Y-m-d H:i:s')
];

header('Content-Type: application/json');
echo json_encode($data);