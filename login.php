<?php require 'db.php'; require 'navbar.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $stmt = $mysqli->prepare("SELECT id, password, is_admin FROM users WHERE login = ?");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $stmt->bind_result($id, $passHash, $isAdmin);
    if ($stmt->fetch()) {
        if (password_verify($password, $passHash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['is_admin'] = ($isAdmin == 1);
            header('Location: dashboard.php');
            exit;
        } else $error = 'Неверный пароль';
    } else $error = 'Пользователь не найден';
}
?>
<div class="container"><h2>Вход</h2>
<form method="POST" class="mt-3">
    <input class="form-control mb-2" name="login" placeholder="Логин" required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Пароль" required>
    <button class="btn btn-primary" type="submit">Войти</button>
</form>
<?php if ($error) echo "<div class='text-danger mt-2'>$error</div>"; ?>
</div>
