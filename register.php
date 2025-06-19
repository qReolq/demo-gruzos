<?php require 'db.php'; require 'navbar.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = trim($_POST['fio']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    if (!preg_match('/^[А-Яа-яЁё\\s]{2,}$/u', $fio)) $errors[] = 'ФИО некорректно';
    if (!preg_match('/^\\+7\\(\\d{3}\\)-\\d{3}-\\d{2}-\\d{2}$/', $phone)) $errors[] = 'Телефон некорректный';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email некорректный';
    if (mb_strlen($login) < 6) $errors[] = 'Логин должен быть не менее 6 символов';
    if (mb_strlen($password) < 6) $errors[] = 'Пароль должен быть не менее 6 символов';
    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO users (fio, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('sssss', $fio, $phone, $email, $login, $passwordHash);
        if ($stmt->execute()) header('Location: login.php');
        else $errors[] = 'Логин уже существует';
    }
}
?>
<div class="container"><h2>Регистрация</h2>
<form method="POST" class="mt-3">
    <input class="form-control mb-2" name="fio" placeholder="ФИО" required>
    <input class="form-control mb-2" name="phone" placeholder="+7(XXX)-XXX-XX-XX" required>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
    <input class="form-control mb-2" name="login" placeholder="Логин" required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Пароль" required>
    <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
</form>
<?php foreach ($errors as $e) echo "<div class='text-danger'>$e</div>"; ?>
</div>
