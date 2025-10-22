document.addEventListener("DOMContentLoaded", async () => {
  const inputBodega = document.getElementById("bodegaSelect");
  const inputSucursal = document.getElementById("sucursalSelect");
  const inputCodigo = document.getElementById("codigo");
  let codigosExistentes = [];

  // 1️⃣ Cargar los códigos existentes
  try {
    const res = await fetch("php/obtener_codigos.php");
    if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

    const data = await res.json();
    if (data.status === "ok") {
      codigosExistentes = data.codigos.map(c => c.codigo_producto);
    }
  } catch (error) {
    console.error("Error al obtener códigos:", error);
  }

  // 2️⃣ Cargar las bodegas
  try {
    const res = await fetch("php/obtener_bodegas.php");
    if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

    const data = await res.json();
    if (data.status === "ok") {
      inputBodega.innerHTML = '<option value="">Seleccione una bodega</option>';
      data.bodegas.forEach(nombre => {
        const option = document.createElement("option");
        option.value = nombre;
        option.textContent = nombre;
        inputBodega.appendChild(option);
      });
    } else {
      alert("No se pudieron cargar las bodegas.");
    }
  } catch (error) {
    console.error("Error al obtener bodegas:", error);
  }

  // 3️⃣ Cuando cambia la bodega, cargar las sucursales asociadas
  inputBodega.addEventListener("change", async function () {
    const bodegaSeleccionada = this.value;
    if (!bodegaSeleccionada) {
      inputSucursal.innerHTML = '<option value="">Seleccione una sucursal</option>';
      return;
    }

    try {
      const res = await fetch(`php/obtener_sucursales.php?bodega=${encodeURIComponent(bodegaSeleccionada)}`);
      if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

      const data = await res.json();
      if (data.status === "ok") {
        // inputSucursal.innerHTML = '<option value="">Seleccione una sucursal</option>';
        data.sucursales.forEach(nombre => {
          const option = document.createElement("option");
          option.value = nombre;
          option.textContent = nombre;
          inputSucursal.appendChild(option);
        });
      } else {
        alert("No se pudieron cargar las sucursales.");
      }
    } catch (error) {
      console.error("Error al obtener sucursales:", error);
    }
  });

  // 4️⃣ Validar código del producto
  inputCodigo.addEventListener("blur", function () {
    const val = this.value.trim();
    if (codigosExistentes.includes(val)) {
      alert("El código del producto ya está registrado");
      this.value = "";
    }
  });
});
