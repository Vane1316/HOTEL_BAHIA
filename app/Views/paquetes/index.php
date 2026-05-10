<?php if (!empty($msg)): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <h3><?= !empty($edit['id']) ? 'Editar paquete' : 'Nuevo paquete' ?></h3>
    <form method="POST" action="index.php?route=paquetes/guardar" class="form-grid">
      <input type="hidden" name="id" value="<?= e($edit['id']) ?>">
      <div><label>Nombre</label><input class="input" name="nombre" value="<?= e($edit['nombre']) ?>" required></div>
      <div><label>Precio</label><input class="input" type="number" step="0.01" name="precio" value="<?= e($edit['precio']) ?>" required></div>
      <div style="grid-column:1/-1"><label>Descripción</label><textarea class="input" name="descripcion"><?= e($edit['descripcion']) ?></textarea></div>
      <div style="grid-column:1/-1"><label>Incluye</label><textarea class="input" name="incluye"><?= e($edit['incluye']) ?></textarea></div>
      <div><label>Estado</label><select name="estado"><option value="activo" <?= $edit['estado']==='activo'?'selected':'' ?>>activo</option><option value="inactivo" <?= $edit['estado']==='inactivo'?'selected':'' ?>>inactivo</option></select></div>
      <div><button class="btn" type="submit">Guardar</button></div>
    </form>
  </div>
  <div class="card">
    <h3>Paquetes</h3>
    <table class="table">
      <tr><th>Nombre</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr>
      <?php foreach ($paquetes as $p): ?>
      <tr>
        <td><strong><?= e($p['nombre']) ?></strong><br><span class="muted"><?= e($p['incluye']) ?></span></td>
        <td><?= money($p['precio']) ?></td><td><?= e($p['estado']) ?></td>
        <td class="actions"><a href="index.php?route=paquetes&edit=<?= e($p['id']) ?>">Editar</a>
        <form style="display:inline" method="POST" action="index.php?route=paquetes/eliminar" onsubmit="return confirm('¿Eliminar paquete?');"><input type="hidden" name="id" value="<?= e($p['id']) ?>"><button class="btn danger" style="padding:6px 10px" type="submit">Eliminar</button></form></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
