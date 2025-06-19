<?php require 'db.php'; require 'navbar.php'; 
if (!($_SESSION['is_admin'] ?? false)) { header('Location: login.php'); exit; }

// Обработка смены статуса
if (isset($_GET['set_status'], $_GET['id'])) {
    $new_status = $_GET['set_status'];
    $req_id = (int)$_GET['id'];
    $allowed = ['new', 'in_progress', 'cancelled'];
    if (in_array($new_status, $allowed)) {
        $stmt = $mysqli->prepare("UPDATE requests SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $new_status, $req_id);
        $stmt->execute();
    }
}

$statusMap = ['new' => 'новая', 'in_progress' => 'в работе', 'cancelled' => 'отменена'];
$result = $mysqli->query("SELECT r.*, u.fio FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.id DESC");
?>
<div class="container">
    <h2>Админка - Все заявки</h2>
    <table class="table table-bordered table-striped mt-3">
        <tr class="table-primary">
            <th>ID</th><th>Пользователь</th><th>Вес</th><th>Тип</th><th>Откуда</th><th>Куда</th><th>Статус</th><th>Отзыв</th><th>Действие</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): 
            $badge = ($row['status'] == 'new') ? 'badge bg-info' :
                     (($row['status'] == 'in_progress') ? 'badge bg-success' : 'badge bg-danger');
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['fio'] ?></td>
            <td><?= $row['weight'] ?></td>
            <td><?= $row['cargo_type'] ?></td>
            <td><?= $row['from_address'] ?></td>
            <td><?= $row['to_address'] ?></td>
            <td><span class="<?= $badge ?>"><?= $statusMap[$row['status']] ?? $row['status'] ?></span></td>
            <td><?= htmlspecialchars($row['feedback'] ?? '') ?></td>
            <td>
                <a class="btn btn-sm btn-info mb-1" href="?id=<?= $row['id'] ?>&set_status=new">Новая</a>
                <a class="btn btn-sm btn-success mb-1" href="?id=<?= $row['id'] ?>&set_status=in_progress">В работе</a>
                <a class="btn btn-sm btn-danger mb-1" href="?id=<?= $row['id'] ?>&set_status=cancelled">Отменена</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
