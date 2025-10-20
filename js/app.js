document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const mensaje = document.querySelector("#mensaje");
  const lista = document.querySelector("#lista-usuarios");

  // Elementos
  const inputNombre = document.getElementById("nombre");
  const inputCodigo = document.getElementById("codigo");
  const inputBodega = document.getElementById("bodega");
  const inputSucursal = document.getElementById("sucursal");
  const inputMoneda = document.getElementById("moneda");
  const inputPrecio = document.getElementById("precio");
  const descripcionTextarea = document.getElementById("descripcion");
  const fieldsetMateriales = document.querySelector("fieldset");
  const checkboxesMateriales = fieldsetMateriales.querySelectorAll('input[name="materiales"]');

  const regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
  const regexPrecio = /^\d+(\.\d{1,2})?$/;

  // -------------------- FUNCIONES DE VALIDACION --------------------
  function validarNombre() {
    const val = inputNombre.value.trim();
    if (val === "") {
      alert("El nombre del producto no puede estar vacío");
      return false;
    }
    if (val.length < 2 || val.length > 50) {
      alert("El nombre del producto debe estar entre 2 y 50 caracteres");
      return false;
    }
    return true;
  }

  function validarCodigo() {
    const val = inputCodigo.value.trim();
    if (val === "") {
      alert("El código del producto no puede estar vacío");
      return false;
    }
    if (val.length < 5 || val.length > 15) {
      alert("El código del producto debe estar entre 5 y 15 caracteres");
      return false;
    }
    if (!regexCodigo.test(val)) {
      alert("El código del producto debe contener letras y números.");
      return false;
    }
    return true;
  }

  function validarBodega() {
    if (inputBodega.value.trim() === "") {
      alert("Debe seleccionar una bodega");
      return false;
    }
    return true;
  }

  function validarSucursal() {
    if (inputSucursal.value.trim() === "") {
      alert("Debe seleccionar una sucursal para la bodega seleccionada");
      return false;
    }
    return true;
  }

  function validarMoneda() {
    if (inputMoneda.value.trim() === "") {
      alert("Debe seleccionar una moneda para el producto");
      return false;
    }
    return true;
  }

  function validarPrecio() {
    const val = inputPrecio.value.trim();
    if (val === "") {
      alert("El precio del producto no puede estar en blanco");
      return false;
    }
    if (!regexPrecio.test(val)) {
      alert("El precio debe ser un número positivo de hasta dos decimales.");
      return false;
    }
    return true;
  }

  function validarMateriales() {
    const seleccionadas = Array.from(checkboxesMateriales).filter(c => c.checked);
    if (seleccionadas.length < 2) {
      alert("Debe seleccionar al menos dos materiales antes de continuar.");
      return false;
    }
    return true;
  }

  function validarDescripcion() {
    const val = descripcionTextarea.value.trim();
    if (val.length < 10 || val.length > 1000) {
      alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
      return false;
    }
    return true;
  }

  // -------------------- EVENTOS EN TIEMPO REAL --------------------
  inputNombre.addEventListener("blur", validarNombre);
  inputCodigo.addEventListener("blur", validarCodigo);
  inputBodega.addEventListener("blur", validarBodega);
  inputSucursal.addEventListener("blur", validarSucursal);
  inputMoneda.addEventListener("blur", validarMoneda);
  inputPrecio.addEventListener("blur", validarPrecio);
  descripcionTextarea.addEventListener("blur", validarDescripcion);
  // checkboxesMateriales.forEach(chk => chk.addEventListener("change", validarMateriales));

  // -------------------- VALIDACIÓN AL ENVIAR FORM --------------------
  form.addEventListener("submit", function (e) {
    e.preventDefault(); // evita recarga de página

    // Ejecutar todas las validaciones
    if (
      !validarNombre() ||
      !validarCodigo() ||
      !validarBodega() ||
      !validarSucursal() ||
      !validarMoneda() ||
      !validarPrecio() ||
      !validarMateriales() ||
      !validarDescripcion()
    ) {
      return; // si alguna falla, no enviar
    }

    // Si todo pasa, enviar mediante AJAX
    const nombre = inputNombre.value.trim();
    fetch("php/guardar_usuario.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "nombre=" + encodeURIComponent(nombre),
    })
      .then(res => res.json())
      .then(data => {
        mensaje.textContent = "¡Nombre guardado!";
        inputNombre.value = "";
        lista.innerHTML = data.map(u => `<li>${u.nombre}</li>`).join("");
      })
      .catch(err => {
        mensaje.textContent = "Error al guardar el nombre.";
        console.error(err);
      });
  });
});
