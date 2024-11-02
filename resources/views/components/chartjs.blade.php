<div>
    <div wire:ignore>
        <canvas id="myChart"></canvas>
        {{ $slot }}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        data: @json($data),
                    }]
                },
            });
        </script>
    </div>
</div>
