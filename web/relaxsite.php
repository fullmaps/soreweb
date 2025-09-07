<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php"); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../design/chillsite.css">
    <title>SoreWeb</title>
    <script src="../js/relaxsite.js" defer></script>
</head>
<body>
    <audio id="miAudio" src="../resources/findher.mp3" loop></audio>
    <audio id="transition-sound" src="../resources/whitenoise.mp3"></audio>

    <!-- Overlay invisible hasta que se active -->
    <div id="transition-overlay"></div>

    <main class="grandcontainer">
        <div class="containerwebsite">
            <a href="website.php" class="transition-link">¿Te sientes peor?</a> 
        </div>
    </main>

    <!-- Video oculto al inicio -->
    <video id="transition-video" src="../resources/wearedeltarune.mp4"></video>
</body>
</html>

<script>
    window.addEventListener("DOMContentLoaded", () => {
    const miAudio = document.getElementById("miAudio");
    const sound = document.getElementById("transition-sound");
    const overlay = document.getElementById("transition-overlay");
    const video = document.getElementById("transition-video");

    // Reproducir música de fondo
    miAudio.play().catch(() => {
        console.log("El navegador bloqueó la reproducción automática.");
    });

   document.querySelectorAll(".transition-link").forEach(link => {
    link.addEventListener("click", function (e) {
        e.preventDefault();
        const destino = this.href;

        miAudio.pause();
        sound.currentTime = 0;
        sound.play();
        overlay.style.opacity = "1";

        setTimeout(() => {
            document.querySelector(".grandcontainer").style.display = "none";
            overlay.style.opacity = "0";

            video.style.display = "block";
            video.play();

            const cortarAntes = 0.5; // segundos antes de terminar
            setTimeout(() => {
                window.location.href = destino;
            }, (video.duration - cortarAntes) * 1000);

        }, 1500); // transición más larga
    });
});

});

</script>