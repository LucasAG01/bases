<?php $__env->startSection('contenido'); ?>
  <h1>Crear Jugador</h1>

  <div class="card">
    <form method="POST" action="crearJugador.php">
      <div class="row">
        <div class="col">
          <label>Nombre</label>
          <input type="text" name="nombre" placeholder="Nombre" required>
        </div>
        <div class="col">
          <label>Apellidos</label>
          <input type="text" name="apellidos" placeholder="Apellidos" required>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>Dorsal</label>
          <input type="number" name="dorsal" placeholder="Dorsal">
        </div>

        <div class="col">
          <label>Posición</label>
          <select name="posicion" required>
            <option value="Portero">Portero</option>
            <option value="Defensa">Defensa</option>
            <option value="Lateral Izquierdo">Lateral Izquierdo</option>
            <option value="Lateral Derecho">Lateral Derecho</option>
            <option value="Central">Central</option>
            <option value="Delantero">Delantero</option>
          </select>
        </div>

        <div class="col">
          <label>Código de Barras</label>
          <input type="text" name="barcode" placeholder="Código de Barras" value="<?php echo e($barcode ?? ''); ?>" readonly required>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-primary" type="submit">Crear</button>
        <button class="btn btn-success" type="reset">Limpiar</button>
        <a class="btn btn-info" href="jugadores.php">Volver</a>
        <a class="btn btn-gray" href="generarCode.php">|||| Generar Barcode</a>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantillas.plantilla1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>