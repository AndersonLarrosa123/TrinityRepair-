<?php 
if(session_status() === PHP_SESSION_NONE) session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chequeo de Tickets - Trinity Repair</title>
    <link rel="stylesheet" href="public/css/chequeo.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity">
            <div class="logo-text">Trinity Repair</div>
        </div>
        <div class="menu">
            <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="index.php?controller=cliente&action=servicios"><i class="fa-solid fa-screwdriver-wrench"></i> Arreglos 360°</a>
            <a href="index.php?controller=cliente&action=chequeo" class="active"><i class="fa-solid fa-magnifying-glass"></i> Mi Reparación</a>
            <a href="index.php?controller=cliente&action=consulta"><i class="fa-solid fa-comments"></i> Tu Consulta Aquí</a>
            <a href="index.php?controller=cliente&action=locales"><i class="fa-solid fa-map-location-dot"></i> Visítanos</a>
            <a href="index.php?controller=cliente&action=clientes"><i class="fa-solid fa-users"></i> Confían en Nosotros</a>
        </div>
    </nav>

    <main class="ticket-container">
        <h1>Mis reparaciones</h1>

        <?php 
        require_once "models/Ticket.php";
        $ticketModel = new Ticket();
        $id_cliente = $_SESSION['usuario_id'];
        $tickets = $ticketModel->listar($id_cliente);

        // Filtrar tickets cancelados
        $tickets = array_filter($tickets, fn($t) => $t['estado'] !== 'Cancelado');

        // Manejo de acciones POST para cancelar o aprobar ticket
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['cancel_ticket'])) {
                $ticketModel->cambiarEstado($_POST['cancel_ticket'], 'Cancelado');
                header("Location: index.php?controller=cliente&action=chequeo");
                exit;
            }
            if (isset($_POST['aprobar_ticket'])) {
                $ticketModel->cambiarEstado($_POST['aprobar_ticket'], 'En Reparación', $_POST['presupuesto'], 1);
                header("Location: index.php?controller=cliente&action=chequeo");
                exit;
            }
        }

        $estados = ['Pendiente','Diagnóstico','Presupuesto','En Reparación','Finalizado'];
        ?>

        <?php if(!empty($tickets)): ?>
        <div class="ticket-row">
            <?php foreach($tickets as $ticket): ?>
                <div class="ticket-card">
                    <h2>Ticket #<?= $ticket['id']; ?></h2>

                    <div class="estado-barra">
                        <?php 
                        $indice_ticket = array_search($ticket['estado'], $estados);
                        if ($indice_ticket === false) $indice_ticket = 0;
                        ?>

                        <?php foreach($estados as $indice => $e): 
                            $clase = '';
                            $showInfo = false;
                            if ($indice < $indice_ticket) $clase = 'completo';
                            elseif ($indice === $indice_ticket) $clase = 'activo';
                            if ($clase === 'activo' || $clase === 'completo') $showInfo = true;
                        ?>
                            <div class="estado-step <?= $clase ?>">
                                <?= $e ?>
                                <?php if($showInfo): ?>
                                    <div class="info-estado">
                                        <?php if($e === 'Pendiente'): ?>
                                            <div><strong>Descripción:</strong> <?= htmlspecialchars($ticket['descripcion']); ?></div>
                                        <?php elseif($e === 'Diagnóstico'): ?>
                                            <div><strong>Técnico:</strong> <?= htmlspecialchars($ticket['tecnico_nombre'] ?? 'No asignado'); ?></div>
                                        <?php elseif($e === 'Presupuesto'): ?>
                                            <div><strong>Presupuesto:</strong> $<?= number_format($ticket['presupuesto'] ?? 0,2); ?></div>
                                        <?php elseif($e === 'En Reparación'): ?>
                                            <div><strong>Creado por:</strong> <?= htmlspecialchars($ticket['creador'] ?? 'Admin'); ?></div>
                                        <?php elseif($e === 'Finalizado'): ?>
                                            <div><em>Reparación completada</em></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="acciones-tickets" style="margin-top:10px;">
                        <?php if($ticket['estado'] === 'Presupuesto'): ?>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="aprobar_ticket" value="<?= $ticket['id']; ?>">
                                <input type="hidden" name="presupuesto" value="<?= $ticket['presupuesto']; ?>">
                                <button type="submit" class="approve-btn">Continuar Reparación</button>
                            </form>

                            <form method="POST" class="d-inline">
                                <input type="hidden" name="cancel_ticket" value="<?= $ticket['id']; ?>">
                                <button type="submit" class="cancel-btn">Cancelar</button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p class="no-tickets">No tienes tickets activos.</p>
        <?php endif; ?>
    </main>
</body>
</html>
