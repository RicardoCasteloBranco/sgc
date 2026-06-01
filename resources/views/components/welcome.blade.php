<div class="p-8 bg-white border-b border-gray-200 m-4 rounded-2xl">

    <!-- GRID DOS GRÁFICOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- GRÁFICO 1 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Cursos
            </h2>

            <canvas id="chart1"></canvas>
        </div>

        <!-- GRÁFICO 2 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Alunos
            </h2>

            <canvas id="chart2"></canvas>
        </div>

        <!-- GRÁFICO 3 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Projetos
            </h2>

            <canvas id="chart3"></canvas>
        </div>

        <!-- GRÁFICO 4 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Turmas
            </h2>

            <canvas id="chart4"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // GRÁFICO 1
    new Chart(document.getElementById('chart1'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar'],
            datasets: [{
                label: 'Cursos',
                data: [12, 19, 8],
                borderWidth: 1
            }]
        }
    });

    // GRÁFICO 2
    new Chart(document.getElementById('chart2'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar'],
            datasets: [{
                label: 'Alunos',
                data: [30, 45, 60],
                borderWidth: 2
            }]
        }
    });

    // GRÁFICO 3
    new Chart(document.getElementById('chart3'), {
        type: 'pie',
        data: {
            labels: ['Ativos', 'Concluídos'],
            datasets: [{
                data: [15, 9]
            }]
        }
    });

    // GRÁFICO 4 COM API
    async function carregarGraficoTurmas() {

        const response = await fetch('/api/turmas');

        const dados = await response.json();

        const labels = dados.map(item => item.status);
        const valores = dados.map(item => item.total);

        new Chart(document.getElementById('chart4'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: valores
                }]
            }
        });
    }

    carregarGraficoTurmas();

</script>