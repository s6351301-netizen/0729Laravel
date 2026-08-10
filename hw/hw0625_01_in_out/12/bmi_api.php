<?php
// 1. 接收前端透過 POST 傳來的資料
$h = $_POST['h'] ?? 0;
$w = $_POST['w'] ?? 0;

// 2. 進行簡單的邏輯判斷
if ($h > 0 && $w > 0) {
    $meters = $h / 100;
    $bmi = round($w / ($meters * $meters), 2);

    if ($bmi < 18.5) {
        $status = "體重過輕";
    } elseif ($bmi < 24) {
        $status = "正常範圍";
    } else {
        $status = "體重過重";
    }
} else {
    $bmi = 0;
    $status = "請輸入正確數值";
}

// 3. 將結果包裝成陣列，並轉成 JSON 回傳給前端
$result = [
    'bmi' => $bmi,
    'status' => $status
];

echo json_encode($result);
?>