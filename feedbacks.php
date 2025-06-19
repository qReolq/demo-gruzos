<?php require 'db.php'; require 'navbar.php';
$result = $mysqli->query("SELECT r.feedback, u.fio FROM requests r JOIN users u ON r.user_id = u.id WHERE r.feedback IS NOT NULL AND r.feedback <> '' ORDER BY r.id DESC");
$hasRows = false;
if ($result === false) {
    error_log('DB query failed in feedbacks.php: ' . $mysqli->error);
} else {
    $hasRows = $result->num_rows > 0;
}
?>
<div class="container">
    <h2>Отзывы клиентов</h2>
    <?php if ($hasRows): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['fio']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['feedback'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php elseif ($result !== false): ?>
        <p>Пока нет отзывов.</p>
    <?php else: ?>
        <p>Ошибка при загрузке отзывов.</p>
    <?php endif; ?>
</div>
