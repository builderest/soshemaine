<?php
require_once __DIR__ . '/includes/header.php';
?>
<div class="container-fluid">
    <div class="row g-4">
        <div class="col-12 col-lg-3">
            <div class="card-glass p-4">
                <span class="badge badge-soft">Visitas</span>
                <h3 class="display-6 fw-semibold mt-3"><?= number_format($metrics['visits']) ?></h3>
                <p class="text-secondary">Actividad de los últimos 30 días</p>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card-glass p-4">
                <span class="badge badge-soft">Contactos</span>
                <h3 class="display-6 fw-semibold mt-3"><?= number_format($metrics['contacts']) ?></h3>
                <p class="text-secondary">Leads generados</p>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card-glass p-4">
                <span class="badge badge-soft">Productos</span>
                <h3 class="display-6 fw-semibold mt-3"><?= number_format($metrics['products']) ?></h3>
                <p class="text-secondary">Soluciones publicadas</p>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card-glass p-4">
                <span class="badge badge-soft">Posts</span>
                <h3 class="display-6 fw-semibold mt-3"><?= number_format($metrics['posts']) ?></h3>
                <p class="text-secondary">Artículos activos</p>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-1">
        <div class="col-12 col-xl-8">
            <div class="card-glass p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Tráfico estimado</h2>
                    <span class="badge bg-primary-subtle text-primary">Simulado</span>
                </div>
                <canvas id="trafficChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card-glass p-4 h-100">
                <h2 class="h5">Estado del sitio</h2>
                <ul class="list-unstyled mt-3 small">
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Sitio público online</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> SSL activo</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Base de datos optimizada</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Modo mantenimiento desactivado</li>
                </ul>
                <a href="maintenance.php" class="btn btn-outline-light btn-sm">Gestionar mantenimiento</a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('trafficChart');
        if (!ctx) return;
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(14,165,233,0.6)');
        gradient.addColorStop(1, 'rgba(14,165,233,0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Visitas',
                    data: [420, 520, 680, 720, 760, 820, 840, 900, 960, 1020, 1100, 1180],
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#0EA5E9',
                    tension: 0.4,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.1)' } }, x: { grid: { display: false } } },
            }
        });
    });
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
