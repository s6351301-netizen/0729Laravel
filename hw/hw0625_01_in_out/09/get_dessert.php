<?php
header('Content-Type: application/json; charset=utf-8');

// 1. 模擬讀取 JSON 資料（已清除隱形非法字元）
$jsonData = '{
  "store_info": { "name": "幸福蛋糕專賣店", "address": "台北市大安區幸福路 100 號", "phone": "02-2345-6789" },
  "delivery_info": { "fee": 180, "free_shipping_threshold": 2000, "notice": "黑貓低溫冷凍宅配，滿 2000 免運" },
  "desserts": [
    { "id": 1, "name": "經典法式馬卡龍", "price": 350, "flavor": "覆盆子 / 抹茶 / 巧克力" },
    { "id": 2, "name": "法式草莓千層蛋糕", "price": 950, "flavor": "大湖草莓 / 香草卡士達" },
    { "id": 3, "name": "濃郁微苦熔岩巧克力", "price": 480, "flavor": "72% 比利時黑巧克力" },
    { "id": 4, "name": "盛夏芒果慕斯", "price": 750, "flavor": "愛文芒果 / 百香果凍" },
    { "id": 5, "name": "日式靜岡抹茶捲", "price": 420, "flavor": "靜岡抹茶 / 萬丹紅豆" },
    { "id": 6, "name": "紐約經典重乳酪蛋糕", "price": 600, "flavor": "澳洲乳酪 / 酥脆餅乾底" },
    { "id": 7, "name": "英式伯爵茶戚風", "price": 550, "flavor": "唐寧伯爵茶 / 鮮奶油" },
    { "id": 8, "name": "法式香香檸檬塔", "price": 450, "flavor": "在地青檸 / 酥脆塔皮" },
    { "id": 9, "name": "義式微醺提拉米蘇", "price": 520, "flavor": "馬斯卡彭 / 咖啡利口酒" },
    { "id": 10, "name": "炙燒香草焦糖布丁", "price": 320, "flavor": "大溪地香草莢 / 手作焦糖" }
  ]
}';

$sourceData = json_decode($jsonData, true);
$input = $_GET;

// 2. 接收前端參數（加入 max(1, ...) 確保購買數量至少為 1，避免惡意負數）
$dessertId = isset($input['num1']) ? (int)$input['num1'] : 1;
$quantity  = isset($input['num2']) ? max(1, (int)$input['num2']) : 1;

// 3. 尋找對應的甜點
$targetDessert = null;
foreach ($sourceData['desserts'] as $dessert) {
    if ($dessert['id'] === $dessertId) {
        $targetDessert = $dessert;
        break;
    }
}

// 如果找不到，預設帶第一個商品
if (!$targetDessert) {
    $targetDessert = $sourceData['desserts'][0];
}

// 4. 計算費用邏輯
$subtotal = $targetDessert['price'] * $quantity;

$shippingFee = $sourceData['delivery_info']['fee'];
if ($subtotal >= $sourceData['delivery_info']['free_shipping_threshold']) {
    $shippingFee = 0; // 滿額免運
}

$total = $subtotal + $shippingFee;

// 5. 封裝 JSON 回傳
$response = [
    'store_name'      => $sourceData['store_info']['name'],
    'dessert_name'    => $targetDessert['name'],
    'flavor'          => $targetDessert['flavor'],
    'price'           => $targetDessert['price'],
    'quantity'        => $quantity,
    'subtotal'        => $subtotal,
    'shipping_fee'    => $shippingFee,
    'total_cost'      => $total,
    'delivery_notice' => $sourceData['delivery_info']['notice']
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);