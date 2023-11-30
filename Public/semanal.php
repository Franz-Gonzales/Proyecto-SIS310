
<script src="../app.js"></script>

<?php

$semanas = $_GET['semanas'];

// echo $semanas;

$meses = [
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
    <h1>Periodo Semanas</h1>
    <form action="javascript:validar()" method="post" id="form-datos">
        <?php if($semanas <= 4){ 
            echo '<label for="mes">Selecciones el mes para las semanas:</label>';
            echo '<select name="semanas" id="semanas">
            <option value="">Seleccion el mes para las semanas</option>';
            foreach($meses as $key => $mes){
                echo '<option value="'.$key.'">'.$mes.'</option>';
            }
            echo '</select>';
        }else{
            echo '<label for="mesInicio">Selecciones el mes para el inicio de las semanas:</label>';
            echo '<select name="semanaInicio" id="semanas">
            <option value="">Seleccion el mes para las semanas</option>';
            foreach($meses as $key => $mes){
                echo '<option value="'.$key.'">'.$mes.'</option>';
            }
            echo '</select>';

            echo '<label for="mesFinal">Selecciones el mes para el mes final de las semanas:</label>';
            echo '<select name="semanaFinal" id="semanas">
            <option value="">Seleccion el mes para las semanas</option>';
            foreach($meses as $key => $mes){
                echo '<option value="'.$key.'">'.$mes.'</option>';
            }
            echo '</select>';
        }
        ?>
    
        <label for="inventarioInicial">Inventario Inicial:</label>
        <input type="number" id="inventarioInicial" name="inventarioInicial" placeholder="Inventario Inicial"/>

        <label for="lote">Tamaño del Lote: </label>
        <input type="number" id="lote" name="lote" placeholder="Tamaño del Lote"/>

        <input type="submit" value="Generar Peridos" class="btn_enviar">
    </form>
</div>

