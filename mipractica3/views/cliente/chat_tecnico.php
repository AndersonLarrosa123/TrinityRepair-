<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<div class="chat-container">
    <div class="chat-header">
        <h3>Chat con el Técnico</h3>
    </div>
    <div class="chat-mensajes" id="chatMensajes">
        <?php foreach($mensajes as $msg): ?>
            <div class="mensaje <?= $msg['remitente']=='cliente' ? 'cliente' : 'tecnico' ?>">
                <p><?= htmlspecialchars($msg['mensaje']); ?></p>
                <span class="hora"><?= date('H:i', strtotime($msg['fecha'])); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="chat-input">
        <input type="text" id="mensajeInput" placeholder="Escribe tu mensaje...">
        <button id="enviarBtn"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatMensajes = document.getElementById('chatMensajes');
    const enviarBtn = document.getElementById('enviarBtn');
    const mensajeInput = document.getElementById('mensajeInput');
    const id_tecnico = 1; // ID del técnico (ejemplo)

    // Enviar mensaje
    enviarBtn.addEventListener('click', () => {
        const mensaje = mensajeInput.value.trim();
        if(!mensaje) return;
        fetch('index.php?controller=cliente&action=enviarMensaje', {
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`mensaje=${encodeURIComponent(mensaje)}&id_tecnico=${id_tecnico}`
        }).then(r=>r.json()).then(res=>{
            if(res.status==='ok') {
                mensajeInput.value='';
                cargarMensajes();
            }
        });
    });

    // Recargar mensajes cada 2s
    function cargarMensajes() {
        fetch(`index.php?controller=cliente&action=chatTecnico&ajax=1`)
        .then(r=>r.text())
        .then(html=>{
            chatMensajes.innerHTML = html;
            chatMensajes.scrollTop = chatMensajes.scrollHeight;
        });
    }

    setInterval(cargarMensajes, 2000);
    chatMensajes.scrollTop = chatMensajes.scrollHeight;
});
</script>
