<?php require 'db.php'; require 'navbar.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = $_POST['weight'] ?? '';
    $dims = $_POST['dimensions'] ?? '';
    $type = $_POST['cargo_type'] ?? '';
    $from = $_POST['from_address'] ?? '';
    $to = $_POST['to_address'] ?? '';

    $stmt = $mysqli->prepare("INSERT INTO requests (user_id, request_date, request_time, weight, dimensions, cargo_type, from_address, to_address)
        VALUES (?, CURDATE(), CURTIME(), ?, ?, ?, ?, ?)");
    $stmt->bind_param('idssss', $_SESSION['user_id'], $weight, $dims, $type, $from, $to);
    $stmt->execute();
    $msg = 'Заявка успешно создана!';
}
?>
<div class="container">
    <h2>Создать заявку</h2>
    <?php if ($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <form method="POST" class="mt-3">
        <input class="form-control mb-2" name="weight" placeholder="Вес груза (кг)" required>
        <input class="form-control mb-2" name="dimensions" placeholder="Габариты (см)">
        <select class="form-control mb-2" name="cargo_type">
            <option value="fragile">Хрупкое</option>
            <option value="perishable">Скоропортящееся</option>
            <option value="refrigerated">Рефрижератор</option>
            <option value="animals">Животные</option>
            <option value="liquid">Жидкость</option>
            <option value="furniture">Мебель</option>
            <option value="trash">Мусор</option>
        </select>
        <input class="form-control mb-2" name="from_address" placeholder="Адрес отправления" required>
        <input class="form-control mb-2" name="to_address" placeholder="Адрес доставки" required>
        <button class="btn btn-primary" type="submit">Отправить заявку</button>
    </form>
</div>
