
<script src="../../app.js"></script>

<?php

// $semanas = $_GET['semanas'];
$semanas = isset($_GET['semanas']) ? $_GET['semanas'] : '';


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
    <form action="javascript:validarSemanal()" method="post" id="form-datos">
        <?php 
        
        echo '<p id="nro_semanas">'.$semanas.'Semanas</p>';
        if($semanas <= 4){ 

            //? PARA SOLO UN MES
            echo '<label for="mes">Selecciones el mes para las semanas:</label>';
            echo '<select name="mes" id="mes">
            <option value="">Seleccion el mes para las semanas.</option>';
            foreach($meses as $key => $mes){
                echo '<option value="'.$key.'">'.$mes.'</option>';
            }
            echo '</select>';

            if($semanas <= 3){
                echo '<label for="semanaInicio">Introduce el numero de semana a iniciar: </label>
                <input type="number" id="semanaInicio" name="periodoInicio" placeholder="Semana"/>';

                echo '<label for="semanaFinal">Introduce el periodo final de la semana: </label>
                <input type="number" id="semanaFinal" name="periodoFinal" placeholder="Semana"/>';

            }else{
                echo '<label for="mes">Introduce el Pronostico mensual: </label>
                <input type="number" id="pronostico-mensual" name="pronostico-mensual" placeholder="Pronoctico Inicial"/>';

                echo '<input type="hidden" id="semanaInicio" name="periodoInicio" value="'. 1 .'">';
                echo '<input type="hidden" id="semanaFinal" name="periodoFinal" value="'. 4 .'">';
            }
            echo '<input type="hidden" id="semanas" name="semanas" value="'.$semanas.'">';
        }else{

            //? PARA CANTIDAD DE SEMANAS EN MESES
            // echo '<p id="nro_semanas">'.$semanas.'Semanas</p>';
            echo '<label for="mesInicio">Selecciones el mes para el inicio de las semanas:</label>';
            echo '<select name="mesInicio" id="mesInicio" onchange="mostrarMesFinal()">
            <option value="">Selecciona el mes para las semanas.</option>';
            foreach($meses as $key => $mes){
                echo '<option value="'.$key.'">'.$mes.'</option>';
            }
            echo '</select>';
    
            echo '<select name="periodoInicio" id="semanaInicio" onchange="mostrarMesAConcluir()">
                </select>';

            echo '<div id="mesCulminada"></div>';
            
            echo '<input type="hidden" id="semanaFinal" name="periodoFinal" value="'. $semanas .'">';
            echo '<input type="hidden" name="semanas" value="'.$semanas.'">';
        }
        ?>
    
        <label for="inventarioInicial">Inventario Inicial:</label>
        <input type="number" id="inventarioInicial" name="inventarioInicial" placeholder="Inventario Inicial"/>

        <label for="lote">Tamaño del Lote: </label>
        <input type="number" id="lote" name="lote" placeholder="Tamaño del Lote"/>

        <input type="submit" value="Generar Peridos" class="btn_enviar">

    
    </form>

</div>

