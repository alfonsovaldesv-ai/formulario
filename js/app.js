document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const input = document.querySelector("input[name='nombre']");
    const mensaje = document.querySelector("#mensaje");
    const lista = document.querySelector("#lista-usuarios");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // evita que la página recargue
  
      const nombre = input.value.trim();
      if (nombre === "") {
        mensaje.textContent = "Por favor ingresa tu nombre.";
        return;
      }
  
      // AJAX
      fetch("php/guardar_usuario.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "nombre=" + encodeURIComponent(nombre),
      })
        .then((res) => res.json())
        .then((data) => {
          mensaje.textContent = "¡Nombre guardado!";
          input.value = "";
          lista.innerHTML = data
            .map((u) => `<li>${u.nombre}</li>`)
            .join("");
        })
        .catch((err) => {
          mensaje.textContent = "Error al guardar el nombre.";
          console.error(err);
        });
    });
  });
  