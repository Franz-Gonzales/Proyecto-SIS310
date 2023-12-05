document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formulario');

    form.onsubmit = function (e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        // Recoge los valores de los inputs del usuario
        const demanda = [
            parseInt(document.getElementById('enero').value, 10),
            parseInt(document.getElementById('febrero').value, 10),
            parseInt(document.getElementById('marzo').value, 10),
            parseInt(document.getElementById('abril').value, 10),
            parseInt(document.getElementById('mayo').value, 10),
            parseInt(document.getElementById('junio').value, 10),
        ];

        const dias_laborales = [
            parseInt(document.getElementById('diasLaboralesEnero').value, 10),
            parseInt(document.getElementById('diasLaboralesFebrero').value, 10),
            parseInt(document.getElementById('diasLaboralesMarzo').value, 10),
            parseInt(document.getElementById('diasLaboralesAbril').value, 10),
            parseInt(document.getElementById('diasLaboralesMayo').value, 10),
            parseInt(document.getElementById('diasLaboralesJunio').value, 10),
        ];

        const horas_por_unidad = parseFloat(document.getElementById('unidadHora').value);
        const produccionPromedio = parseFloat(document.getElementById('produccionPromedio').value);
        const costoManoObra = parseFloat(document.getElementById('costoManoObra').value);
        const costoContratar = parseFloat(document.getElementById('costoContratar').value);
        const costoDespedir = parseFloat(document.getElementById('costoDespedir').value);
        const costoAlmacenar = parseFloat(document.getElementById('costoAlmacenar').value);
        const costoFaltante = parseFloat(document.getElementById('costoFaltante').value);
        const horas_laborales_diarias = parseFloat(document.getElementById('horasJornadaL').value);
        let trabajadores_disponibles = [parseFloat(document.getElementById('trabajadores_disponibles').value)];


        let produccion_diaria_por_trabajador = [];
        let trabajadores_necesarios = [];

        //Producción diaria
        for (let i = 0; i < dias_laborales.length; i++) {
            let produccion = (horas_laborales_diarias * dias_laborales[i]) / horas_por_unidad;
            produccion_diaria_por_trabajador.push(produccion);
        }

        //Trabajadores Necesarios
        for (let i = 0; i < demanda.length; i++) {
            let trabajadores = Math.ceil(demanda[i] / produccion_diaria_por_trabajador[i]);
            trabajadores_necesarios.push(trabajadores);
        }

        //Promedio de trabajadores Necesarios:
        let sumaTrabajadores = trabajadores_necesarios.reduce((acumulador, valorActual) => acumulador + valorActual, 0);
        let promedio_trab_necesarios = Math.floor(sumaTrabajadores / trabajadores_necesarios.length);
        console.log('Promedio de trabajadores necesarios:', promedio_trab_necesarios);
        console.log('Producción diaria por trabajador:', produccion_diaria_por_trabajador);

        let trabajadores_contratados = [];
        let trabajadores_despedidos = [];
        let trabajadores_empleados = []; 
        let trab_necesarios = [];
        trab_necesarios[0] = promedio_trab_necesarios;

        for (let i = 0; i < demanda.length; i++) {
            console.log('trab_nece', trab_necesarios[i], 'trab_dispo', trabajadores_disponibles[i])
            if (trab_necesarios[i] > trabajadores_disponibles[i] && trab_necesarios[i] !== 0) {
                // Contratar trabajadores
                trabajadores_contratados[i] = trab_necesarios[i] - trabajadores_disponibles[i];
                trabajadores_despedidos[i] = 0;
            } else if (trab_necesarios[i] < trabajadores_disponibles[i] && trab_necesarios[i] !== 0) {
                // Despedir trabajadores
                console.log('trab_nece', trab_necesarios[i], 'trab_dispo', trabajadores_disponibles[i])
                trabajadores_despedidos[i] = trabajadores_disponibles[i] - trab_necesarios[i];
                console.log('trab_despedidos', trabajadores_despedidos[i])
                trabajadores_contratados[i] = 0;
            } else {
                // No hay cambios en el personal
                trabajadores_contratados[i] = 0;
                trabajadores_despedidos[i] = 0;
            }
            // Calcular el total de trabajadores empleados para el próximo mes
            trabajadores_empleados[i] = trabajadores_disponibles[i] + trabajadores_contratados[i] - trabajadores_despedidos[i];

            // Actualizar trabajadores disponibles para el próximo mes
            if (i < demanda.length - 1) {
                trabajadores_disponibles[i + 1] = trabajadores_empleados[i];
                trab_necesarios[i + 1] = 0;
            }
        }
        
        const meses=['Enero, Febrero, Marzo, Abril, Mayo, Junio']
        console.log('Periodo', meses);
        console.log('Demanda', demanda);
        console.log('Días Laborales', dias_laborales);
        console.log('Trabajadores disponibles por mes:', trabajadores_disponibles);
        console.log('Trabajadores necesarios por mes:', trab_necesarios);
        console.log('Trabajadores Contratados por mes:', trabajadores_contratados);
        console.log('Trabajadores Despedidos por mes:', trabajadores_despedidos);
        console.log('Trabajadores Empleados por mes:', trabajadores_empleados);
    };
});
