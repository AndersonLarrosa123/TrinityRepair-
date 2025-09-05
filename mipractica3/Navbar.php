<?php session_start(); ?>
<nav class="navbar">
    <div class="logo">
        <a href="index.php">Trinity Repair</a>
    </div>

    <div class="nav-buttons">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <div class="user-profile">
                <img src="<?= $_SESSION['usuario_foto'] ?>" id="profileBtn" class="profile-img" alt="Usuario">
                <div id="profileDropdown" class="dropdown">
                    <div class="dropdown-header">
                        <img src="<?= $_SESSION['usuario_foto'] ?>" alt="Foto Usuario">
                        <div>
                            <p class="name"><?= $_SESSION['usuario_nombre'] ?></p>
                            <p class="email"><?= $_SESSION['usuario_email'] ?></p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <p><strong>Rol:</strong> 
                        <?php
                        switch($_SESSION['rol_id']) {
                            case 1: echo 'Admin'; break;
                            case 2: echo 'Técnico'; break;
                            case 3: echo 'Cliente'; break;
                            case 4: echo 'Supervisor'; break;
                        }
                        ?></p>
                        <a href="index.php?controller=usuario&action=logout" class="logout-btn">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="index.php?controller=usuario&action=mostrarLogin" class="btn">Iniciar sesión</a>
            <a href="index.php?controller=usuario&action=registro" class="btn">Registrarse</a>
        <?php endif; ?>
    </div>
</nav>
