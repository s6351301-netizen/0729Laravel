<?php
// 加入 CORS 標頭，允許跨網域請求 (如果你用 VS Code Live Server 開網頁，這個很重要)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=utf-8');

// 接收前端傳來的參數 (使用 $_REQUEST 可以同時接收 GET 和 POST 的資料)
$action = $_REQUEST['action'] ?? '';
$keyword = $_REQUEST['keyword'] ?? '';

// 讀取電影基本資料
$json_data = file_get_contents('movies.json');
$movies = json_decode($json_data, true);

// 讀取動態評分資料
$ratings_data = [];
if (file_exists('ratings.json')) {
    $ratings_data = json_decode(file_get_contents('ratings.json'), true) ?? [];
}

if ($action === 'get_movies') {
    $result = [];

    // 將動態評分合併到電影資料中
    foreach ($movies as &$movie) {
        $id = strval($movie['id']);
        if (isset($ratings_data[$id])) {
            $total = $ratings_data[$id]['total_score'];
            $count = $ratings_data[$id]['count'];
            // 計算新的平均分數，四捨五入到小數第一位
            $movie['rating'] = round($total / $count, 1);
            $movie['rating_count'] = $count; // 順便把評分人數傳給前端
        } else {
            $movie['rating_count'] = 0;
        }
    }
    unset($movie); // 斷開參照

    // 如果有輸入關鍵字，就進行簡單的字串比對搜尋
    if (!empty($keyword)) {
        foreach ($movies as $movie) {
            // 在標題或簡介中尋找關鍵字 (不分大小寫)
            if (mb_stripos($movie['title'], $keyword) !== false || 
                mb_stripos($movie['description'], $keyword) !== false) {
                $result[] = $movie;
            }
        }
    } else {
        // 如果沒有關鍵字，回傳所有電影
        $result = $movies;
    }

    // 將結果轉為 JSON 格式回傳給前端
    echo json_encode([
        'status' => 'success',
        'count' => count($result),
        'data' => $result
    ]);
    exit;

} else if ($action === 'rate_movie') {
    $id = strval($_REQUEST['id'] ?? '');
    $rating = floatval($_REQUEST['rating'] ?? 0);
    
    // 檢查參數是否合法
    if($id && $rating >= 1 && $rating <= 10) {
        // 如果該電影還沒有評分記錄，初始化它
        if (!isset($ratings_data[$id])) {
            $ratings_data[$id] = [
                "total_score" => 0,
                "count" => 0
            ];
        }

        // 把新的分數加進去
        $ratings_data[$id]['total_score'] += $rating;
        $ratings_data[$id]['count'] += 1;

        // 將更新後的資料寫回 ratings.json
        file_put_contents('ratings.json', json_encode($ratings_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        echo json_encode([
            'status' => 'success',
            'message' => '評分成功！你給了 ' . $rating . ' 顆星。',
            'new_rating_data' => $ratings_data[$id]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '缺少必要的參數，或是分數不在 1~10 的範圍內'
        ]);
    }
    exit;
}

// 預設回傳錯誤
echo json_encode([
    'status' => 'error',
    'message' => '無效的請求動作'
]);
?>
