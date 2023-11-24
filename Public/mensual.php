
    <script src="../app.js"></script>

    <?php

    $mensual = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];
    ?>

    <div class="periodos">
        <h1>Periodo Mensual</h1>
        <form action="javascript:llenarDatos()" method="post" id="form-datos">
            <label for="mes1">Selecciones rango de periodos mensuales:</label>
            <select name="mes1" id="mes1">
                <option value="">Inicio de Mes</option>
                <?php
                foreach ($mensual as $key => $mes) {
                    echo '<option value="' . $key . '">' . $mes . '</option>';
                }
                ?>
            </select>

            <select name="mes2" id="mes2">
                <option value="">Mes Final</option>
                <?php
                foreach ($mensual as $key => $mes) {
                    echo '<option value="' . $key . '">' . $mes . '</option>';
                }
                ?>
            </select>
        
            <label for="inventarioInicial">Inventario Inicial:</label>
            <input type="number" id="inventarioInicial" name="inventarioInicial" placeholder="Inventario Inicial"/>

            <label for="lote">Tamaño del Lote: </label>
            <input type="number" id="lote" name="lote" placeholder="Tamaño del Lote"/>

            <input type="submit" value="Llenar Datos" class="btn_enviar">
        </form>
    </div>
