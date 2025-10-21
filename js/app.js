document.addEventListener("DOMContentLoaded", function () {

  // Elementos
  const form = document.querySelector("form");

  let codigosExistentes = [];

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


  // Cargar todos los códigos desde el servidor
  fetch("php/obtener_codigos.php")
    .then(res => res.json())
    .then(data => {
      if (data.status === "ok") {
        codigosExistentes = data.codigos.map(c => c.toLowerCase()); // para comparar sin mayúsculas/minúsculas
        console.log("Códigos cargados:", codigosExistentes);
      } else {
        console.error("Error al obtener códigos:", data.message);
      }
    })
    .catch(err => console.error("Error de red:", err));

  inputBodega.addEventListener('focus', async function () {
      try {
        const res = await fetch("php/obtener_bodegas.php");
        console.log('ya hizo fetch');
        console.log(res);
        const data = await res.json();
        console.log('ya obtuvo la data');
    
        if (data.status === "ok") {
          // Limpia el select (para no duplicar opciones)
          inputBodega.innerHTML = '<option value="">Seleccione una bodega</option>';
          console.log(data.bodegas);
          // Recorre las bodegas recibidas y las agrega como opciones
          data.bodegas.forEach(bodega => {
            const option = document.createElement("option");
            option.value = bodega.id_bodega;   // o el campo correcto de tu tabla
            option.textContent = bodega.nombre_bodega; // o descripción, etc.
            inputBodega.appendChild(option);
            console.log('agregando bodega');
          });
        } else {
          console.error("Error al obtener bodegas:", data.message);
          // alert("No se pudieron cargar las bodegas.");
        }
    
      } catch (err) {
        console.error("Error de red:", err);
        // alert("Error al cargar las bodegas");
      }
    });

  
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
    if (val in codigosExistentes) {
      alert('El código del producto ya está registrado')
    }
    return true;
  }

  function validarBodega() {
    if (inputBodega.value.trim() === "") {
      //alert("Debe seleccionar una bodega");
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
  form.addEventListener("submit", async function (e) {
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
    const form = document.getElementById('formProducto');

    form.addEventListener('submit', async (e) => {
      e.preventDefault(); // Evita que el formulario se recargue
    
      // Crear FormData con todos los campos del formulario
      const formData = new FormData(form);
    
      try {
        const res = await fetch("php/guardar_producto.php", {
          method: "POST",
          body: formData // FormData se encarga de codificar correctamente
        });
    
        const data = await res.json();
    
        if (data.status === "ok") {
          alert("Producto guardado correctamente!");
          form.reset(); // limpia el formulario
        } else if (data.error) {
          alert("Error: " + data.error);
        } else {
          alert("Respuesta inesperada del servidor");
          console.log(data);
        }
    
      } catch (err) {
        alert('Error al guardar el producto');
        console.log(err);
      }
    });
    
  });
});
