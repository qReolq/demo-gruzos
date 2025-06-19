<?php require 'db.php'; require 'navbar.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req_date = $_POST['request_date'] ?? '';
    $req_time = $_POST['request_time'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $dims = $_POST['dimensions'] ?? '';
    $type = $_POST['cargo_type'] ?? '';
    $from = $_POST['from_address'] ?? '';
    $to = $_POST['to_address'] ?? '';

    $stmt = $mysqli->prepare(
        "INSERT INTO requests (user_id, request_date, request_time, weight, dimensions, cargo_type, from_address, to_address)" .
        " VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    if ($stmt) {
        $weight = (float) $weight;
        $stmt->bind_param('issdssss', $_SESSION['user_id'], $req_date, $req_time, $weight, $dims, $type, $from, $to);
        if ($stmt->execute()) {
            $msg = 'Заявка успешно создана!';
        } else {
            $msg = 'Ошибка при сохранении заявки: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = 'Ошибка подготовки запроса: ' . $mysqli->error;
    }
}
?>
<div class="container">
    <h2>Создать заявку</h2>
    <?php if ($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <form method="POST" class="mt-3">
        <input class="form-control mb-2" type="date" name="request_date" required>
        <input class="form-control mb-2" type="time" name="request_time" required>
        <input class="form-control mb-2" name="weight" placeholder="Вес груза (кг)" required>
        <input class="form-control mb-2" name="dimensions" placeholder="Габариты (см)">
        <select class="form-control mb-2" name="cargo_type">
            <option value="fragile">Хрупкое</option>
            <option value="perishable">Скоропортящееся</option>
            <option value="refrigerated">Требует рефрижератора</option>
            <option value="animals">Животные</option>
            <option value="furniture">Мебель</option>
            <option value="trash">Мусор</option>
        </select>
        <input class="form-control mb-2" name="from_address" placeholder="Адрес отправления" required>
        <input class="form-control mb-2" name="to_address" placeholder="Адрес доставки" required>
        <button class="btn btn-primary" type="submit">Отправить заявку</button>
    </form>
</div>
