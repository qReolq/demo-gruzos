<?php require 'db.php'; require 'navbar.php';
if (!isset($_SESSION['user_id'])) { header('Locatio n: login.php'); exit; }

$user_id = $_SESSION['user_id'];
$result = $mysqli->query("SELECT * FROM requests WHERE user_id = $user_id ORDER BY id DESC");
?>
<div class="container">
    <h2>Мои заявки</h2>
    <table class="table table-striped mt-3">
        <tr>
            <th>ID</th><th>Вес</th><th>Тип</th><th>Откуда</th><th>Куда</th><th>Статус</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['weight'] ?></td>
            <td><?= $row['cargo_type'] ?></td>
            <td><?= $row['from_address'] ?></td>
            <td><?= $row['to_address'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
