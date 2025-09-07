const audioFondo = document.getElementById("miAudio");

window.addEventListener("load", function () {
    audioFondo.volume = 0.03;
    audioFondo.loop = true;
    audioFondo.play().catch(error => {
        console.error("Error al reproducir la música de fondo:", error);
        alert("No se pudo reproducir la música de fondo. Por favor, revisa la consola para más detalles.");
    });
}); 


document.getElementById("miParrafo").addEventListener("click", function() {
    window.location.href = "website.php";

});
