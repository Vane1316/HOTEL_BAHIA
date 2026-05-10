<?php if (!empty($msg)): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <h3><?= !empty($edit['id']) ? 'Editar reserva' : 'Nueva reserva' ?></h3>
    <form method="POST" action="index.php?route=reservas/guardar" class="form-grid">
      <input type="hidden" name="id" value="<?= e($edit['id']) ?>">
      <div><label>Usuario que registra</label><select name="usuario_id"><?php foreach ($usuarios as $u): ?><option value="<?= e($u['id']) ?>" <?= (int)$edit['usuario_id']===(int)$u['id']?'selected':'' ?>><?= e($u['nombre_completo']) ?></option><?php endforeach; ?></select></div>
      <div><label>Habitación</label><select name="habitacion_id"><?php foreach ($habitaciones as $h): ?><option value="<?= e($h['id']) ?>" <?= (int)$edit['habitacion_id']===(int)$h['id']?'selected':'' ?>><?= e($h['numero'].' - '.$h['tipo'].' - '.$h['estado']) ?></option><?php endforeach; ?></select></div>
      <div><label>Paquete</label><select name="paquete_id"><option value="">Sin paquete</option><?php foreach ($paquetes as $p): ?><option value="<?= e($p['id']) ?>" <?= (int)$edit['paquete_id']===(int)$p['id']?'selected':'' ?>><?= e($p['nombre']) ?></option><?php endforeach; ?></select></div>
      <div><label>Cliente</label><input class="input" name="cliente_nombre" value="<?= e($edit['cliente_nombre']) ?>" required></div>
      <div><label>Documento</label><input class="input" name="cliente_documento" value="<?= e($edit['cliente_documento']) ?>" required></div>
      <div><label>Teléfono</label><input class="input" name="cliente_telefono" value="<?= e($edit['cliente_telefono']) ?>" required></div>
      <div><label>Fecha entrada</label><input class="input" type="date" name="fecha_entrada" value="<?= e($edit['fecha_entrada']) ?>" required></div>
      <div><label>Fecha salida</label><input class="input" type="date" name="fecha_salida" value="<?= e($edit['fecha_salida']) ?>" required></div>
      <div><label>Cantidad personas</label><input class="input" type="number" min="1" name="cantidad_personas" value="<?= e($edit['cantidad_personas']) ?>" required></div>
      <div><label>Tipo de pago</label><select name="tipo_pago"><option value="efectivo" <?= $edit['tipo_pago']==='efectivo'?'selected':'' ?>>efectivo</option><option value="tarjeta" <?= $edit['tipo_pago']==='tarjeta'?'selected':'' ?>>tarjeta</option><option value="transferencia" <?= $edit['tipo_pago']==='transferencia'?'selected':'' ?>>transferencia</option></select></div>
      <div><label>Precio noche</label><input class="input" type="number" step="0.01" name="precio_noche" value="<?= e($edit['precio_noche']) ?>" required></div>
      <div><label>Precio paquete</label><input class="input" type="number" step="0.01" name="precio_paquete" value="<?= e($edit['precio_paquete']) ?>" required></div>
      <div><label>Total reserva</label><input class="input" type="number" step="0.01" name="total_reserva" value="<?= e($edit['total_reserva']) ?>" required></div>
      <div><label>Estado</label><select name="estado_reserva"><option value="pendiente" <?= $edit['estado_reserva']==='pendiente'?'selected':'' ?>>pendiente</option><option value="confirmada" <?= $edit['estado_reserva']==='confirmada'?'selected':'' ?>>confirmada</option><option value="cancelada" <?= $edit['estado_reserva']==='cancelada'?'selected':'' ?>>cancelada</option><option value="finalizada" <?= $edit['estado_reserva']==='finalizada'?'selected':'' ?>>finalizada</option></select></div>
      <div style="grid-column:1/-1"><label>Observaciones</label><textarea class="input" name="observaciones"><?= e($edit['observaciones']) ?></textarea></div>
      <div><button class="btn" type="submit">Guardar</button></div>
    </form>
  </div>
  <div class="card">
    <h3>Listado de reservas</h3>
    <table class="table">
      <tr><th>Cliente</th><th>Habitación</th><th>Usuario</th><th>Fechas</th><th>Total</th><th>Estado</th><th>Acciones</th></tr>
      <?php foreach ($reservas as $r): ?>
      <tr>
        <td><?= e($r['cliente_nombre']) ?><br><span class="muted"><?= e($r['cliente_documento']) ?></span></td>
        <td><?= e($r['numero']) ?><br><span class="muted"><?= e($r['paquete'] ?? 'Sin paquete') ?></span></td>
        <td><?= e($r['nombre_completo']) ?></td>
        <td><?= e($r['fecha_entrada']) ?><br><?= e($r['fecha_salida']) ?></td>
        <td><?= money($r['total_reserva']) ?><br><span class="muted"><?= e($r['tipo_pago']) ?></span></td>
        <td><span class="<?= reserva_badge_class($r['estado_reserva']) ?>"><?= e($r['estado_reserva']) ?></span></td>
        <td class="actions"><a href="index.php?route=reservas&edit=<?= e($r['id']) ?>">Editar</a>
        <form style="display:inline" method="POST" action="index.php?route=reservas/eliminar" onsubmit="return confirm('¿Eliminar reserva?');"><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn danger" style="padding:6px 10px" type="submit">Eliminar</button></form></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
