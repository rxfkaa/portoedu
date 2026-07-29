<div class="glass-card h-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Statistik Prestasi</h5>
            <small class="text-muted">Perkembangan prestasi tahun 2026</small>
        </div>

        <span class="badge text-bg-primary">2026</span>
    </div>

    <canvas id="achievementChart" height="130"></canvas>
</div>

@push('scripts')
    <script>
        const achievementChart = document.getElementById('achievementChart');

        if (achievementChart && window.Chart) {
            new Chart(achievementChart, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Prestasi',
                        data: [2, 4, 5, 6, 9, 12],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, .12)',
                        borderWidth: 3,
                        tension: .4,
                        fill: true,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                },
            });
        }
    </script>
@endpush
