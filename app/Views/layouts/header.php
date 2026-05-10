<?php /** @var string $appName */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($appName) ?></title>
  <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand-wrap">
      <div class="brand-mark">BA</div>
      <div>
        <div class="brand"><?= e($appName) ?></div>
        <div class="brand-sub">Sistema MVC de reservas hoteleras</div>
      </div>
    </div>
    <nav class="menu">
      <a class="<?= ($page ?? '')==='dashboard'?'active':'' ?>" href="index.php?route=dashboard">Inicio</a>
      <a class="<?= ($page ?? '')==='usuarios'?'active':'' ?>" href="index.php?route=usuarios">Usuarios</a>
      <a class="<?= ($page ?? '')==='habitaciones'?'active':'' ?>" href="index.php?route=habitaciones">Habitaciones</a>
      <a class="<?= ($page ?? '')==='paquetes'?'active':'' ?>" href="index.php?route=paquetes">Paquetes</a>
      <a class="<?= ($page ?? '')==='reservas'?'active':'' ?>" href="index.php?route=reservas">Reservas</a>
    </nav>
  </aside>
  <main class="content">
    <div class="topbar">
      <div>
        <span class="eyebrow">Arquitectura MVC</span>
        <h2 style="margin:6px 0 0 0"><?= e($titulo ?? 'Panel') ?></h2>
        <div class="muted">Proyecto organizado en modelos, controladores y vistas</div>
      </div>
      <div class="topbar-chip">Hotel Bahia Azul</div>
    </div>
