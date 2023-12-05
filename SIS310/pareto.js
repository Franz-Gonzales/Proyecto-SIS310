let myChart;
let globalChartData = {
    sortedCategories: [],
    sortedValues: [],
    cumulativePercents: [],
    total: 0
};

function generateColors(base, count) {
    let colors = [];
    let currentHue = 0;
    let step = 360 / count;

    for (let i = 0; i < count; i++) {
        let color = `hsl(${currentHue}, 70%, 60%)`;
        colors.push(color);
        currentHue += step;
    }

    return colors;
}

  

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.chart-btn').forEach(button => {
        button.addEventListener('click', function () {
            changeChartType(this.getAttribute('data-charttype'));
        });
    });
});

function createInputFields() {
    const numberOfCategories = document.getElementById('categoryCount').value;
    const dataInputs = document.getElementById('dataInputs');
    dataInputs.innerHTML = '';

    for (let i = 0; i < numberOfCategories; i++) {
        const row = dataInputs.insertRow(-1);

        const cellName = row.insertCell(0);
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.className = 'form-control';
        nameInput.placeholder = `Categoría ${i + 1}`;
        cellName.appendChild(nameInput);

        const cellValue = row.insertCell(1);
        const valueInput = document.createElement('input');
        valueInput.type = 'number';
        valueInput.className = 'form-control';
        valueInput.placeholder = `Valor ${i + 1}`;
        cellValue.appendChild(valueInput);
    }
}

function generatePareto() {
    const rows = document.getElementById('dataInputs').rows;
    let categories = [];
    let values = [];

    for (let i = 0; i < rows.length; i++) {
        let categoryName = rows[i].cells[0].getElementsByTagName('input')[0].value;
        let categoryValue = Number(rows[i].cells[1].getElementsByTagName('input')[0].value);
        categories.push(categoryName);
        values.push(categoryValue);
    }

    let sortedIndices = values.map((value, index) => ({ value, index }))
                              .sort((a, b) => b.value - a.value)
                              .map(data => data.index);
    let sortedValues = sortedIndices.map(index => values[index]);
    let sortedCategories = sortedIndices.map(index => categories[index]);

    let total = sortedValues.reduce((acc, val) => acc + val, 0);
    let cumulativePercent = 0;
    let cumulativePercents = [];

    sortedValues.forEach(value => {
        let percent = (value / total) * 100;
        cumulativePercent += percent;
        cumulativePercents.push(cumulativePercent);
    });

    // Asignación al objeto global
    globalChartData.sortedCategories = sortedCategories;
    globalChartData.sortedValues = sortedValues;
    globalChartData.cumulativePercents = cumulativePercents;
    globalChartData.total = total;

    // Generar colores para cada categoría
    globalChartData.colors = generateColors('blue', sortedCategories.length);

    // Inicializar el gráfico con el tipo 'bar'
    changeChartType('bar');
}

function changeChartType(newType) {
    // Si ya existe un gráfico, lo destruimos
    if (myChart) {
        myChart.destroy();
    }

    const ctx = document.getElementById('paretoChart').getContext('2d');

    // Se asegura de que la línea esté al frente generando su conjunto de datos primero
    let datasets = [];
    if (newType === 'bar') {
        datasets.push({
            label: 'Porcentaje acumulado',
            data: globalChartData.cumulativePercents,
            type: 'line',
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: false,
            yAxisID: 'y-axis-2',
            order: 1 // Esto asegura que la línea se dibuje encima de las barras
        });
    }

    // Agregamos el conjunto de datos de las barras después
    datasets.push({
        label: 'Valor',
        data: globalChartData.sortedValues,
        backgroundColor: globalChartData.colors,
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        yAxisID: newType === 'bar' ? 'y-axis-1' : undefined,
        order: 2 // Las barras se dibujarán debajo de la línea
    });

    let chartData = {
        labels: globalChartData.sortedCategories,
        datasets: datasets
    };

    // Configuraciones comunes para todos los gráficos
    let chartOptions = {
        responsive: true,
        maintainAspectRatio: false
    };

    // Configuraciones para los gráficos de barras y líneas
    if (newType === 'bar' || newType === 'line') {
        chartOptions.scales = {
            'y-axis-1': {
                type: 'linear',
                position: 'left',
            },
            'y-axis-2': {
                type: 'linear',
                position: 'right',
                ticks: {
                    max: 100,
                    min: 0
                }
            }
        };
    }

    // Creamos el nuevo gráfico con la configuración seleccionada
    myChart = new Chart(ctx, {
        type: newType,
        data: chartData,
        options: chartOptions
    });

    // Llamamos a la función para generar la tabla de Pareto solo si el tipo es 'bar'
    if (newType === 'bar') {
        generateParetoTable(
            globalChartData.sortedCategories, 
            globalChartData.sortedValues, 
            globalChartData.sortedValues.map(value => value / globalChartData.total), 
            globalChartData.sortedValues, 
            globalChartData.cumulativePercents
        );
    }
}

function generateParetoTable(categories, absoluteFrequencies, relativeFrequencies, cumulativeAbsoluteFrequencies, cumulativeRelativeFrequencies) {
    const tableContainer = document.getElementById('paretoTableContainer');
    tableContainer.innerHTML = '';

    const table = document.createElement('table');
    table.className = 'table table-bordered';

    const thead = document.createElement('thead');
    table.appendChild(thead);
    const headerRow = thead.insertRow(-1);
    const headers = ['Categoría', 'Frecuencia Absoluta', 'Frecuencia Relativa', 'Frecuencia Abs. Acumulada', 'Frecuencia Rel. Acumulada'];
    headers.forEach(headerText => {
        const headerCell = document.createElement('th');
        headerCell.innerText = headerText;
        headerRow.appendChild(headerCell);
    });

    const tbody = document.createElement('tbody');
    table.appendChild(tbody);

    for (let i = 0; i < categories.length; i++) {
        const row = tbody.insertRow(-1);

        const categoryCell = row.insertCell(0);
        categoryCell.innerText = categories[i];

        const absFreqCell = row.insertCell(1);
        absFreqCell.innerText = absoluteFrequencies[i];

        const relFreqCell = row.insertCell(2);
        relFreqCell.innerText = (relativeFrequencies[i] * 100).toFixed(2) + '%';

        const cumAbsFreqCell = row.insertCell(3);
        cumAbsFreqCell.innerText = cumulativeAbsoluteFrequencies[i];

        const cumRelFreqCell = row.insertCell(4);
        cumRelFreqCell.innerText = (cumulativeRelativeFrequencies[i]).toFixed(2) + '%';
    }

    tableContainer.appendChild(table);
}
