<?php if (!empty($msg)): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <h3><?= !empty($edit['id']) ? 'Editar usuario' : 'Nuevo usuario' ?></h3>
    <form method="POST" action="index.php?route=usuarios/guardar" class="form-grid">
      <input type="hidden" name="id" value="<?= e($edit['id']) ?>">
      <div><label>Nombre completo</label><input class="input" name="nombre_completo" value="<?= e($edit['nombre_completo']) ?>" required></div>
      <div><label>Usuario</label><input class="input" name="usuario" value="<?= e($edit['usuario']) ?>" required></div>
      <div><label>Correo</label><input class="input" type="email" name="email" value="<?= e($edit['email']) ?>" required></div>
      <div><label>Contraseña <?= !empty($edit['id']) ? '(opcional)' : '' ?></label><input class="input" type="text" name="password"></div>
      <div><label>Rol</label><select name="rol"><option value="administrador" <?= $edit['rol']==='administrador'?'selected':'' ?>>administrador</option><option value="recepcion" <?= $edit['rol']==='recepcion'?'selected':'' ?>>recepción</option><option value="ventas" <?= $edit['rol']==='ventas'?'selected':'' ?>>ventas</option></select></div>
      <div><label>Estado</label><select name="estado"><option value="activo" <?= $edit['estado']==='activo'?'selected':'' ?>>activo</option><option value="inactivo" <?= $edit['estado']==='inactivo'?'selected':'' ?>>inactivo</option></select></div>
      <div><button class="btn" type="submit">Guardar</button></div>
    </form>
  </div>
  <div class="card">
    <h3>Usuarios registrados</h3>
    <table class="table">
      <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
      <?php foreach ($usuarios as $u): ?>
      <tr>
        <td><?= e($u['id']) ?></td><td><?= e($u['nombre_completo']) ?></td><td><?= e($u['usuario']) ?></td><td><?= e($u['rol']) ?></td><td><?= e($u['estado']) ?></td>
        <td class="actions"><a href="index.php?route=usuarios&edit=<?= e($u['id']) ?>">Editar</a>
        <form style="display:inline" method="POST" action="index.php?route=usuarios/eliminar" onsubmit="return confirm('¿Eliminar usuario?');"><input type="hidden" name="id" value="<?= e($u['id']) ?>"><button class="btn danger" style="padding:6px 10px" type="submit">Eliminar</button></form></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
