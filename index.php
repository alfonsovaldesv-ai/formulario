<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Formulario de Producto</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <h1>Formulario de Producto</h1>

  <!-- novalidate no está puesto: usamos validación nativa del navegador -->
  <form id="formProducto">
    <h2>Nombre</h2>
    <input type="text" id="nombre" name="nombre" required placeholder="Ingrese nombre">
    <div class="error" id="error-nombre" aria-live="polite"></div>

    <h2>Código</h2>
    <input type="text" id="codigo" name="codigo" required placeholder="Ingrese código">
    <div class="error" id="error-codigo" aria-live="polite"></div>

    <h2>Bodega</h2>
    <select id="bodega" name="bodega" required>
      <option value="" selected disabled>Seleccione una bodega</option>
      <option value="AKIKB">AKIKB</option>
    </select>
    <div class="error" id="error-bodega" aria-live="polite"></div>

    <h2>Sucursal</h2>
    <select id="sucursal" name="sucursal" required>
      <option value="" selected disabled>Seleccione una sucursal</option>
      <option value="quilicura">Quilicura</option>
      <option value="colina">Colina</option>
      <option value="san bernardo">San Bernardo</option>
      <option value="cerrillos">Cerrillos</option>
    </select>
    <div class="error" id="error-sucursal" aria-live="polite"></div>

    <h2>Precio</h2>
    <input type="number" id="precio" name="precio" min="0" step="0.01" required placeholder="0.00">
    <div class="error" id="error-precio" aria-live="polite"></div>

    <h2>Moneda</h2>
    <select id="moneda" name="moneda" required>
      <option value="" selected disabled>Seleccione una moneda</option>
      <option value="dolar americano">Dólar americano</option>
      <option value="peso chileno">Peso chileno</option>
      <option value="peso mexicano">Peso mexicano</option>
      <option value="sol">Sol</option>
      <option value="peso colombiano">Peso colombiano</option>
    </select>
    <div class="error" id="error-moneda" aria-live="polite"></div>

    <h2>Descripción</h2>
    <textarea id="descripcion" name="descripcion" rows="4" cols="50" required placeholder="Descripción del producto"></textarea>
    <div class="error" id="error-descripcion" aria-live="polite"></div>

    <h2>Materiales</h2>
    <fieldset>
      <legend>Seleccione al menos un material</legend>

      <label><input type="checkbox" name="materiales" value="plastico"> Plástico</label><br>
      <label><input type="checkbox" name="materiales" value="metal"> Metal</label><br>
      <label><input type="checkbox" name="materiales" value="madera"> Madera</label><br>
      <label><input type="checkbox" name="materiales" value="vidrio"> Vidrio</label><br>
      <label><input type="checkbox" name="materiales" value="textil"> Textil</label>
    </fieldset>
    <div class="error" id="error-materiales" aria-live="polite"></div>

    <br>
    <button type="submit">Guardar producto</button>
  </form>
</body>
</html>
