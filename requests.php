<?php require 'db.php'; require 'navbar.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$user_id = $_SESSION['user_id'];
// Отправка отзыва
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback'], $_POST['req_id'])) {
    $fb = trim($_POST['feedback']);
    $req_id = (int)$_POST['req_id'];
    $stmt = $mysqli->prepare("UPDATE requests SET feedback=? WHERE id=? AND user_id=?");
    $stmt->bind_param('sii', $fb, $req_id, $user_id);
    $stmt->execute();
}
$statusMap = ['new' => 'новая', 'in_progress' => 'в работе', 'cancelled' => 'отменена'];
$result = $mysqli->query("SELECT * FROM requests WHERE user_id = $user_id ORDER BY id DESC");
?>
<div class="container">
    <h2>Мои заявки</h2>
    <table class="table table-striped mt-3">
        <tr>
            <th>ID</th><th>Вес</th><th>Тип</th><th>Откуда</th><th>Куда</th><th>Статус</th><th>Отзыв</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['weight'] ?></td>
            <td><?= $row['cargo_type'] ?></td>
            <td><?= $row['from_address'] ?></td>
            <td><?= $row['to_address'] ?></td>
            <td><?= $statusMap[$row['status']] ?? $row['status'] ?></td>
            <td>
                <?php if (!empty($row['feedback'])): ?>
                    <?= htmlspecialchars($row['feedback']) ?>
                <?php else: ?>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="req_id" value="<?= $row['id'] ?>">
                        <input class="form-control me-2" name="feedback" placeholder="Ваш отзыв" required>
                        <button class="btn btn-sm btn-primary">OK</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
