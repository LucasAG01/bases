<?php $__env->startSection('contenido'); ?>
  <h1>Listado de Jugadores</h1>

  <?php if(!empty($msg)): ?>
    <div class="msg-ok"><?php echo e($msg); ?></div>
  <?php endif; ?>

  <p>
    <a class="btn btn-success" href="fcrear.php">+ Nuevo Jugador</a>
  </p>

  <table>
    <thead>
      <tr>
        <th>Nombre Completo</th>
        <th>Posición</th>
        <th>Dorsal</th>
        <th>Código de Barras</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $jugadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="left"><?php echo e($j['apellidos']); ?>, <?php echo e($j['nombre']); ?></td>
          <td><?php echo e($j['posicion']); ?></td>
          <td><?php echo e($j['dorsal'] ?? 'Sin asignar'); ?></td>
          <td><?php echo e($j['barcode']); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantillas.plantilla1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>