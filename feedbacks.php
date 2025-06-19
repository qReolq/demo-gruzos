<?php
require 'db.php';
require 'navbar.php';

// Handle new review submission
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        $stmt = $mysqli->prepare(
            "INSERT INTO service_reviews (user_id, rating, comment) VALUES (?, ?, ?)"
        );
        if ($stmt) {
            $stmt->bind_param('iis', $_SESSION['user_id'], $rating, $comment);
            $stmt->execute();
            $stmt->close();
        } else {
            error_log('DB prepare failed in feedbacks.php: ' . $mysqli->error);
        }
    }
}

$result = $mysqli->query(
    "SELECT s.rating, s.comment, s.created_at, u.fio " .
    "FROM service_reviews s JOIN users u ON s.user_id = u.id ORDER BY s.id DESC"
);
$hasRows = false;
if ($result === false) {
    error_log('DB query failed in feedbacks.php: ' . $mysqli->error);
} else {
    $hasRows = $result->num_rows > 0;
}
?>
<div class="container">
    <h2>Отзывы клиентов</h2>
    <?php if(isset($_SESSION['user_id'])): ?>
        <form method="POST" class="mb-4">
            <div class="mb-2">
                <label class="form-label">Оценка</label>
                <select name="rating" class="form-select" required>
                    <option value="">Выберите</option>
                    <?php for($i=5; $i>=1; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Комментарий</label>
                <textarea name="comment" class="form-control" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Оставить отзыв</button>
        </form>
    <?php endif; ?>

    <?php if ($hasRows): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($row['fio']) ?>
                        <small class="text-muted"><?= htmlspecialchars($row['created_at']) ?></small>
                    </h5>
                    <p class="card-text mb-1">Оценка: <?= (int)$row['rating'] ?>/5</p>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php elseif ($result !== false): ?>
        <p>Пока нет отзывов.</p>
    <?php else: ?>
        <p>Ошибка при загрузке отзывов.</p>
    <?php endif; ?>
</div>
