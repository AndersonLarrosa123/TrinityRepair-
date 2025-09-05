<?php
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    foreach ($mensajes as $m) {
        echo '<div class="mensaje '.($m['remitente_id'] == $_SESSION['usuario_id'] ? 'tecnico' : 'cliente').'">';
        echo nl2br(htmlspecialchars($m['mensaje']));
        echo '<span>'.htmlspecialchars($m['remitente_nombre']).' - '.date('d/m/Y H:i', strtotime($m['fecha'])).'</span>';
        echo '</div>';
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Chat Ticket #<?= $ticket['id'] ?></title>
<style>
.chat-container { max-width: 600px; margin: 0 auto; }
.mensaje { padding: 10px; margin: 5px 0; border-radius: 8px; }
.mensaje.cliente { background: #d1ecf1; text-align: left; }
.mensaje.tecnico { background: #c3e6cb; text-align: right; }
.mensaje span { display: block; font-size: 0.8em; color: #555; }
</style>
</head>
<body>

<div class="chat-container">
    <h3>Chat Ticket #<?= $ticket['id'] ?></h3>

    <div id="mensajes">
        <?php foreach ($mensajes as $m): ?>
            <div class="mensaje <?= $m['remitente_id'] == $_SESSION['usuario_id'] ? 'tecnico' : 'cliente' ?>">
                <?= nl2br(htmlspecialchars($m['mensaje'])) ?>
                <span><?= htmlspecialchars($m['remitente_nombre']) ?> - <?= date('d/m/Y H:i', strtotime($m['fecha'])) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <form id="formChat" method="POST">
        <input type="text" name="mensaje" id="mensaje" required placeholder="Escribí tu mensaje..." style="width:80%;">
        <button type="submit">Enviar</button>
    </form>
</div>

<script>
// Refrescar mensajes cada 3 segundos
setInterval(() => {
    fetch("index.php?controller=<?= $this instanceof TicketController ? 'ticket' : 'tecnico' ?>&action=chat&ticket_id=<?= $ticket['id'] ?>&ajax=1")
    .then(res => res.text())
    .then(html => {
        document.getElementById("mensajes").innerHTML = html;
    });
}, 3000);
</script>

</body>
</html>
