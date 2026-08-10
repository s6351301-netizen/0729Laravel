<?php
// 啟動 Session 用來儲存模擬的假資料
session_start();

//=========================
// Login
//=========================
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if (!isset($_SESSION['login'])) {
    $msg = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $acc = trim($_POST['acc'] ?? "");
        $pw = trim($_POST['pw'] ?? "");
        if ($acc !== "" && $pw !== "") {
            $_SESSION['login'] = $acc;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $msg = "帳號及密碼不可空白";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="zh-TW">

    <head>
        <meta charset="UTF-8">
        <title>LOGIN</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                min-width: 700px;
            }

            @media (max-width:768px) {

                .d-grid .btn {
                    width: 100%;
                }

            }
        </style>
    </head>

    <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">LOGIN</h4>
                        </div>
                        <div class="card-body">

                            <?php if ($msg != "") { ?><div class="alert alert-danger"><?= $msg ?></div><?php } ?>
                            <form method="post">
                                <div class="mb-3"><label>帳號</label><input class="form-control" name="acc" placeholder="guest"></div>
                                <div class="mb-3"><label>密碼</label><input type="password" class="form-control" name="pw" placeholder="guest"></div>
                                <div class="d-grid"><button class="btn btn-primary">登入</button></div>
                                <div class="alert alert-info">如無帳號可使用 <b>guest</b></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
    exit;
}


// 1. 偵測當前角色頁面（預設為會員管理 'member'）
$role = $_GET['role'] ?? 'member';
if (!in_array($role, ['owner', 'member'])) {
    $role = 'member';
}

// 2. 初始化假資料（分開建立業主與會員的獨立 Session 假資料）
if (!isset($_SESSION['owner_users'])) {
    $_SESSION['owner_users'] = [
        1 => ['id' => 1, 'name' => '林業主', 'email' => 'boss1@example.com', 'phone' => '0911-111111'],
        2 => ['id' => 2, 'name' => '陳大亨', 'email' => 'boss2@example.com', 'phone' => '0922-222222'],
    ];
    $_SESSION['owner_next_id'] = 3;
}

if (!isset($_SESSION['member_users'])) {
    $_SESSION['member_users'] = [
        1 => ['id' => 1, 'name' => '謝祥國', 'email' => 'ming@example.com', 'phone' => '0912-345678'],
        2 => ['id' => 2, 'name' => '李美玲', 'email' => 'ling@example.com', 'phone' => '0923-456789'],
        3 => ['id' => 3, 'name' => '王大同', 'email' => 'tong@example.com', 'phone' => '0934-567123'],
    ];
    $_SESSION['member_next_id'] = 4;
}

// 動態綁定當前切換角色所使用的 Session 鍵名
$db_key = $role . '_users';
$id_key = $role . '_next_id';

// 3. 處理：新增或修改資料
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($action === 'create') {
        $id = $_SESSION[$id_key]++;
        $_SESSION[$db_key][$id] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
    } elseif ($action === 'update') {
        $id = (int)$_POST['id'];
        if (isset($_SESSION[$db_key][$id])) {
            $_SESSION[$db_key][$id] = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ];
        }
    }
    // 動作完成後重導向，保持在當前角色分頁並防止重新整理重複送出
    header("Location: " . $_SERVER['PHP_SELF'] . "?role=" . $role);
    exit;
}

// 4. 處理：刪除資料
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    unset($_SESSION[$db_key][$id]);
    header("Location: " . $_SERVER['PHP_SELF'] . "?role=" . $role);
    exit;
}

// 5. 處理：取得單筆資料用於編輯
$is_new = isset($_GET['new']);
$edit_user = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $edit_user = $_SESSION[$db_key][$id] ?? null;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + Bootstrap 無資料庫 CRUD 系統</title>
    <!-- 替換成超快、正確版本的 Cloudflare Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- 頂端導覽列 Navbar -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="?role=<?= $role ?>">後台管理系統</a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $role == 'owner' ? 'active fw-bold text-info' : '' ?>"
                        href="?role=owner">
                        🏢 業主管理
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $role == 'member' ? 'active fw-bold text-info' : '' ?>"
                        href="?role=member">
                        👥 會員管理
                    </a>
                </li>
            </ul>

            <span class="navbar-text text-light me-3">
                登入者：
                <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
            </span>

            <a href="?logout=1" class="btn btn-danger btn-sm">
                登出
            </a>

        </div>
    </div>
</nav>

        <?php if ($is_new || $edit_user): ?>
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card shadow-sm">
                    <!-- 根據不同身分變更表單標題顏色 (業主藍色/會員綠色) -->
                    <div class="card-header <?= $role === 'owner' ? 'bg-primary' : 'bg-success' ?> text-white">
                        <h5 class="card-title mb-0">
                            <?= $edit_user ? '✏️ 編輯' : '➕ 新增' ?><?= $role === 'owner' ? '業主' : '會員' ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>?role=<?= $role ?>" method="POST">
                            <input type="hidden" name="action" value="<?= $edit_user ? 'update' : 'create' ?>">
                            <?php if ($edit_user): ?>
                                <input type="hidden" name="id" value="<?= $edit_user['id'] ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">姓名</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($edit_user['name'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">電子郵件</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($edit_user['email'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">電話</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($edit_user['phone'] ?? '') ?>" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn <?= $role === 'owner' ? 'btn-primary' : 'btn-success' ?>">
                                    <?= $edit_user ? '儲存修改' : '確認新增' ?>
                                </button>
                                <?php if ($edit_user): ?>
                                    <a href="?role=<?= $role ?>" class="btn btn-secondary">取消編輯</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- 右側：資料列表區（Read 與 Delete） -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white
d-flex flex-column flex-md-row
justify-content-between
align-items-start align-items-md-center
gap-2">
                    <h5 class="card-title mb-0">📋 <?= $role === 'owner' ? '業主' : '會員' ?>清單</h5>
                    <div><a class="btn btn-success btn-sm me-2" href="?role=<?= $role ?>&new=1">➕ 新增<?= $role === "owner" ? "業主" : "會員" ?></a><span class="badge bg-secondary">總計 <?= count($_SESSION[$db_key]) ?> 筆</span></div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>電話</th>
                                    <th class="text-center">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($_SESSION[$db_key])): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">目前沒有任何資料。</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($_SESSION[$db_key] as $user): ?>
                                        <tr>
                                            <td class="ps-3"><?= $user['id'] ?></td>
                                            <td><?= htmlspecialchars($user['name']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= htmlspecialchars($user['phone']) ?></td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="?role=<?= $role ?>&edit=<?= $user['id'] ?>"
                                                        class="btn btn-warning btn-sm">
                                                        編輯
                                                    </a>

                                                    <a href="?role=<?= $role ?>&delete=<?= $user['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('確定要刪除此資料嗎？')">
                                                        刪除
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <!-- 替換成超快、正確版本的 Cloudflare Bootstrap 5 JS CDN (移至最下方確保網頁優先載入) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>