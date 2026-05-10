<div class="cards">
  <div class="card"><h3><?= e($totalHabitaciones) ?></h3><div class="muted">Habitaciones registradas</div></div>
  <div class="card"><h3><?= e($disponibles) ?></h3><div class="muted">Habitaciones disponibles</div></div>
  <div class="card"><h3><?= e($reservasMes) ?></h3><div class="muted">Reservas del mes</div></div>
  <div class="card"><h3><?= money($ingresos) ?></h3><div class="muted">Ingresos reservados</div></div>
  <div class="card"><h3><?= e($totalUsuarios) ?></h3><div class="muted">Usuarios del sistema</div></div>
</div>

<div class="grid-2" style="margin-top:18px">
  <div class="card">
    <h3>Últimas reservas</h3>
    <table class="table">
      <tr><th>Cliente</th><th>Hab.</th><th>Usuario</th><th>Total</th><th>Estado</th></tr>
      <?php if ($ultimas): ?>
        <?php foreach ($ultimas as $row): ?>
        <tr>
          <td><?= e($row['cliente_nombre']) ?></td>
          <td><?= e($row['numero']) ?><br><span class="muted"><?= e($row['paquete'] ?? 'Sin paquete') ?></span></td>
          <td><?= e($row['nombre_completo']) ?></td>
          <td><?= money($row['total_reserva']) ?></td>
          <td><span class="<?= reserva_badge_class($row['estado_reserva']) ?>"><?= e($row['estado_reserva']) ?></span></td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5">No hay reservas registradas.</td></tr>
      <?php endif; ?>
    </table>
  </div>
  <div class="card">
    <h3>Estructura MVC</h3>
    <p><strong>Modelos:</strong> gestionan consultas y persistencia de datos.</p>
    <p><strong>Controladores:</strong> procesan acciones y preparan los datos.</p>
    <p><strong>Vistas:</strong> muestran formularios, tablas y tarjetas.</p>
  </div>
</div>
