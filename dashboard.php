<?php require 'db.php'; require 'navbar.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$uid = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT fio FROM users WHERE id = ?");
$stmt->bind_param('i', $uid);
$stmt->execute();
$stmt->bind_result($fio);
$stmt->fetch();
$stmt->close();
?>
<div class="container">
    <h2 class="mt-4">Добро пожаловать, <?= htmlspecialchars($fio) ?>!</h2>
    <p class="lead mt-2">Вы можете:</p>
    <ul class="list-group mt-3">
        <li class="list-group-item"><a href="new_request.php">📦 Оформить новую заявку</a></li>
        <li class="list-group-item"><a href="requests.php">📋 Просмотреть мои заявки</a></li>
        <?php if ($_SESSION['is_admin'] ?? false): ?>
            <li class="list-group-item"><a href="admin.php">🛠 Перейти в админку</a></li>
        <?php endif; ?>
        <li class="list-group-item"><a href="logout.php">🚪 Выйти из системы</a></li>
    </ul>
</div>
