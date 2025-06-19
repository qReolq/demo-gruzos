<?php require 'db.php'; require 'navbar.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = trim($_POST['fio']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (!preg_match('/^[А-Яа-яЁё\\s]{2,}$/u', $fio)) {
        $errors[] = 'ФИО некорректно';
    }

    if (!preg_match('/^\\+7\\(\\d{3}\\)-\\d{3}-\\d{2}-\\d{2}$/', $phone)) {
        $errors[] = 'Телефон некорректный (формат +7(XXX)-XXX-XX-XX)';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email некорректный';
    }

    if (!preg_match('/^[А-Яа-яЁё]{6,}$/u', $login)) {
        $errors[] = 'Логин должен быть кириллицей и не менее 6 символов';
    }

    if (mb_strlen($password) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов';
    }

    if (empty($errors)) {
        // Проверим нет ли такого логина
        $check = $mysqli->prepare("SELECT id FROM users WHERE login = ?");
        $check->bind_param('s', $login);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errors[] = 'Логин уже существует';
        } else {
            // Записываем нового пользователя
            $stmt = $mysqli->prepare("INSERT INTO users (fio, phone, email, login, password, is_admin) VALUES (?, ?, ?, ?, ?, 0)");
            $stmt->bind_param('sssss', $fio, $phone, $email, $login, $password);
            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Ошибка при регистрации';
            }
        }
    }
}
?>

<div class="container">
    <h2 class="mt-4">Регистрация</h2>
    <form method="POST" class="card p-4 mt-3">
        <div class="mb-3">
            <label class="form-label">ФИО</label>
            <input type="text" name="fio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" placeholder="+7(XXX)-XXX-XX-XX" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Логин</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="mt-3">
            <?php foreach ($errors as $e): ?>
                <div class="text-danger"><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
