<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Грузовозофф</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav ms-auto">
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
  </div>
</nav>
<br><br><br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
