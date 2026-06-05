<div class="p-8 bg-white border-b border-gray-200 m-4 rounded-2xl">

    <!-- GRID DOS GRÁFICOS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- GRÁFICO 1 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Alunos
            </h2>

            <canvas id="chart1" style="max-height: 300px;"></canvas>
        </div>

        <!-- GRÁFICO 2 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Parecer Técnico
            </h2>

            <canvas id="chart2"></canvas>
        </div>

        <!-- GRÁFICO 3 -->
        <div class="bg-gray-50 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-bold mb-4">
                Turmas
            </h2>

            <canvas id="chart3"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

   // GRÁFICO 1 COM API
    async function carregarGraficoAlunos() {

        const response = await fetch('/api/alunos');

        const dados = await response.json();

        const labels = dados.map(item => item.mes);
        const valores = dados.map(item => item.total);

        new Chart(document.getElementById('chart1'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Alunos Concluintes',
                    data: valores
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // GRÁFICO 2 COM API
    async function carregarGraficoPT() {

        const response = await fetch('/api/projetos');

        const dados = await response.json();

        const labels = dados.map(item => item.status);
        const valores = dados.map(item => item.total);

        new Chart(document.getElementById('chart2'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: valores
                }]
            }
        });
    }

    // GRÁFICO 3 COM API
    async function carregarGraficoTurmas() {

        const response = await fetch('/api/turmas');

        const dados = await response.json();

        const labels = dados.map(item => item.status);
        const valores = dados.map(item => item.total);

        new Chart(document.getElementById('chart3'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: valores
                }]
            }
        });
    }

    carregarGraficoAlunos();

    carregarGraficoPT();

    carregarGraficoTurmas();

</script>