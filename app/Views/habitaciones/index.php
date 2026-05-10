<?php if (!empty($msg)): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <h3><?= !empty($edit['id']) ? 'Editar habitación' : 'Nueva habitación' ?></h3>
    <form method="POST" action="index.php?route=habitaciones/guardar" class="form-grid">
      <input type="hidden" name="id" value="<?= e($edit['id']) ?>">
      <div><label>Número</label><input class="input" name="numero" value="<?= e($edit['numero']) ?>" required></div>
      <div><label>Tipo</label><input class="input" name="tipo" value="<?= e($edit['tipo']) ?>" required></div>
      <div><label>Capacidad</label><input class="input" type="number" min="1" name="capacidad" value="<?= e($edit['capacidad']) ?>" required></div>
      <div><label>Precio por noche</label><input class="input" type="number" step="0.01" name="precio_noche" value="<?= e($edit['precio_noche']) ?>" required></div>
      <div><label>Estado</label><select name="estado"><option value="disponible" <?= $edit['estado']==='disponible'?'selected':'' ?>>disponible</option><option value="ocupada" <?= $edit['estado']==='ocupada'?'selected':'' ?>>ocupada</option><option value="mantenimiento" <?= $edit['estado']==='mantenimiento'?'selected':'' ?>>mantenimiento</option><option value="limpieza" <?= $edit['estado']==='limpieza'?'selected':'' ?>>limpieza</option><option value="deshabilitada" <?= $edit['estado']==='deshabilitada'?'selected':'' ?>>deshabilitada</option></select></div>
      <div style="grid-column:1/-1"><label>Descripción</label><textarea class="input" name="descripcion"><?= e($edit['descripcion']) ?></textarea></div>
      <div><button class="btn" type="submit">Guardar</button></div>
    </form>
  </div>
  <div class="card">
    <h3>Habitaciones en tarjetas</h3>
    <div class="room-grid">
      <?php foreach ($habitaciones as $h): ?>
      <div class="room-card">
        <div style="display:flex;justify-content:space-between;align-items:center"><h4>Habitación <?= e($h['numero']) ?></h4><span class="<?= room_badge_class($h['estado']) ?>"><?= e($h['estado']) ?></span></div>
        <div class="muted"><?= e($h['tipo']) ?></div>
        <p>Capacidad: <?= e($h['capacidad']) ?> personas</p>
        <p>Precio: <?= money($h['precio_noche']) ?></p>
        <p class="muted"><?= e($h['descripcion']) ?></p>
        <div class="actions"><a href="index.php?route=habitaciones&edit=<?= e($h['id']) ?>">Editar</a>
        <form style="display:inline" method="POST" action="index.php?route=habitaciones/eliminar" onsubmit="return confirm('¿Eliminar habitación?');"><input type="hidden" name="id" value="<?= e($h['id']) ?>"><button class="btn danger" style="padding:6px 10px" type="submit">Eliminar</button></form></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
