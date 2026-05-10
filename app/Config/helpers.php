<?php
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function money($value): string { return '$' . number_format((float)$value, 0, ',', '.'); }
function room_badge_class(string $estado): string {
    return match ($estado) {
        'disponible' => 'badge green',
        'ocupada' => 'badge red',
        'mantenimiento' => 'badge orange',
        'limpieza' => 'badge blue',
        default => 'badge gray',
    };
}
function reserva_badge_class(string $estado): string {
    return match ($estado) {
        'confirmada', 'finalizada' => 'badge green',
        'pendiente' => 'badge orange',
        'cancelada' => 'badge red',
        default => 'badge gray',
    };
}
