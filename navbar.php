<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel='stylesheet' href='assets/css/style.css'>
<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Грузовозофф</a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="feedbacks.php">Отзывы</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="new_request.php">Создать заявку</a></li>
          <li class="nav-item"><a class="nav-link" href="requests.php">Мои заявки</a></li>
          <?php if($_SESSION['is_admin'] ?? false): ?>
            <li class="nav-item"><a class="nav-link" href="admin.php">Админка</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Выход</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
        <?php endif; ?>
      </ul>
  </div>
</nav>
<script src='assets/js/script.js'></script>
