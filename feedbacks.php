<?php require 'db.php'; require 'navbar.php';
$result = $mysqli->query("SELECT r.feedback, u.fio FROM requests r JOIN users u ON r.user_id = u.id WHERE r.feedback IS NOT NULL AND r.feedback <> '' ORDER BY r.id DESC");
?>
<div class="container">
    <h2>Отзывы клиентов</h2>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['fio']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['feedback'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Пока нет отзывов.</p>
    <?php endif; ?>
</div>
