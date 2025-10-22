<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Formulario de Producto</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
      <h1>Formulario de Producto</h1>

      <form id="formProducto">
        <div class='fila'>
          <div class='grupo'>
            <h2>Código</h2>
            <input type="text" id="codigo" name="codigo" required placeholder="Ingrese código">
          </div>
          <div class='grupo'>
            <h2>Nombre</h2>
            <input type="text" id="nombre" name="nombre" required placeholder="Ingrese nombre">
          </div>
        </div>

        <div class='fila'>
          <div class='grupo'>
            <h2>Bodega</h2>
            <select id="bodegaSelect" name="bodega" required>
              <option value="" selected disabled>Seleccione una bodega</option>
            </select>
          </div>

          <div class='grupo'>
            <h2>Sucursal</h2>
            <select id="sucursalSelect" name="sucursal" required>
              <option value="" selected disabled>Seleccione una sucursal</option>
            </select>
          </div>

        </div>


        <div class='fila'>
          <div class='grupo'>
            <h2>Moneda</h2>
            <select id="moneda" name="moneda" required>
              <option value="" selected disabled>Seleccione una moneda</option>
            </select>
          </div>
          <div class='grupo'>
            <h2>Precio</h2>
            <input type="number" id="precio" name="precio" min="0" step="0.01" required placeholder="0.00">
          </div>
        </div>


        <div class='fila'>
          <div class='grupo'>
            <h2>Materiales</h2>
              <fieldset>
                <legend>Seleccione al menos un material</legend>
                <label><input type="checkbox" name="materiales" value="plastico"> Plástico</label><br>
                <label><input type="checkbox" name="materiales" value="metal"> Metal</label><br>
                <label><input type="checkbox" name="materiales" value="madera"> Madera</label><br>
                <label><input type="checkbox" name="materiales" value="vidrio"> Vidrio</label><br>
                <label><input type="checkbox" name="materiales" value="textil"> Textil</label>
              </fieldset>
          </div>
        </div>
        <div class='fila'>
          <div class='grupo'>
            <h2>Descripción</h2>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" required placeholder="Descripción del producto"></textarea>
          </div>
        </div>
        <br>
        <div class='botonera'>
          <button type="submit">Guardar producto</button>
        </div>
        
      </form>
    </div>
  <script src="js/app.js"></script>
</body>
</html>
