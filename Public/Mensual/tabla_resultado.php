
<?php

$periodoInicio = $_POST['periodoInicio'];
$periodoFinal = $_POST['periodoFinal'];
$inventarioInicial = $_POST['inventarioInicial'];
$lote = $_POST['lote'];

$pronosticos = $_POST['pronosticos'];
$pedidos = $_POST['pedidos'];
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

function calcularMPS($invenInicial, $pronostico, $pedido, $lote)
{
    if ($invenInicial >= max($pronostico, $pedido)) {
        return 0;
    } else {
        return $lote;
    }
}


//? CÁLCULO DE MPS Y INVENTARIO FINAL PARA CADA PERIODO
$arrayMPS = array();
$arrayInvFinal = array();

$aux = $periodoInicio;
$primerPeriodo = ($aux - $periodoInicio) + 1;
$ultimoPeriodo = $periodoFinal - $periodoInicio + 1;

for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) {

    $inventarioAnterior = ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2];
    $mps = calcularMPS($inventarioAnterior, $pronosticos[$i - 1], $pedidos[$i - 1], $lote);

    array_push($arrayMPS, $mps);

    $inventarioAnterior = ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2];
    $inventarioFinal = $inventarioAnterior + $arrayMPS[$i - 1] - max($pronosticos[$i - 1], $pedidos[$i - 1]);

    array_push($arrayInvFinal, $inventarioFinal);

}




//? CALCULO DE DPP PARA CADA PERIODO
$arrayDPP = array();

$aux = $periodoInicio;
$primerPeriodo = ($aux - $periodoInicio) + 1;
$ultimoPeriodo = $periodoFinal - $periodoInicio + 1;

for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) {

    $inventarioAnterior = ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2];

    if ($i < $ultimoPeriodo - 2 && $arrayMPS[$i] == 0 && $arrayMPS[$i + 1] == 0 && $arrayMPS[$i + 2] == 0) {

        $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - array_sum(array_slice($pedidos, $i - 1, 4));

    } else{
        if ($i < $ultimoPeriodo - 1 && $arrayMPS[$i] == 0 && $arrayMPS[$i + 1] == 0) {

            $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - array_sum(array_slice($pedidos, $i - 1, 3));
        } else{
            if ($i < $ultimoPeriodo && $arrayMPS[$i] == 0) {

                $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - $pedidos[$i - 1] - $pedidos[$i];
            } else {
                $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - $pedidos[$i - 1];
            }
        }
    }

    array_push($arrayDPP, $dpp);

    if ($arrayMPS[$i - 1] == 0) {
        $arrayDPP[$i - 1] = '';
    }
}



// for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) {

//     $inventarioAnterior = ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2];

//     if($i < $ultimoPeriodo - 2 && $arrayMPS[$i] == 0 && $arrayMPS[$i + 1] == 0 && $arrayMPS[$i + 2] == 0){

//         $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - ($pedidos[$i - 1] + $pedidos[$i] + $pedidos[$i + 1] + $pedidos[$i + 2]);
//     }else{

//         if ($i < $ultimoPeriodo - 1 && $arrayMPS[$i] == 0 && $arrayMPS[$i + 1] == 0) {
    
//             $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - ($pedidos[$i - 1] + $pedidos[$i] + $pedidos[$i + 1]);
//         } else {
//             if($i < $ultimoPeriodo && $arrayMPS[$i] == 0){
    
//                 $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - ($pedidos[$i - 1] + $pedidos[$i]);
//             }else{
    
//                 $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - $pedidos[$i - 1];
//             }
//         }
//     }

//     array_push($arrayDPP, $dpp);

//     if ($arrayMPS[$i - 1] == 0) {
//         $arrayDPP[$i - 1] = '';
//     }

// }

?>

<div class="tabla">
    <h1>Tabla de Resulatos (MPS)</h1>

    <div class="datosEntrada">
        <div class="inventario-inicial1">Inventario Inicial</div>
        <div class="inventario-inicial2"><?php echo $inventarioInicial; ?></div>
    </div>

    <div class="datosEntrada">
        <div class="lote1">Tamaño del Lote <br> Producción por periodo</div>
        <div class="lote2"><?php echo $lote; ?></div>
    </div>

    <table>
        <tr>
            <th>Mensual</th>
            <?php for ($i = $periodoInicio; $i <= $periodoFinal; $i++) { ?>
                <th class="tipo-periodo"><?php echo $meses[$i] ?></th>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">Inventario Inicial</td>
            <?php 
            for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { 
                $style1 = ($i == $primerPeriodo) ? 'invenInicial' : '';
                $inventario = ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2];
                ?>
                <td class="numeros" id="<?php echo $style1; ?>"><?php echo $inventario; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">Pronósticos</td>
            <?php for ($i = 0; $i < count($pronosticos); $i++) { ?>
                <td class="numeros"><?php echo $pronosticos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">Pedidos</td>
            <?php for ($i = 0; $i < count($pedidos); $i++) { ?>
                <td class="numeros"><?php echo $pedidos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">MPS/PMP</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { 
                $style = ($arrayMPS[$i - 1] == 0) ? 'mps0' : 'mps1';
                ?>
                <td class="numeros <?php echo $style; ?>"><?php echo $arrayMPS[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">Inventario Final</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <td class="numeros"><?php echo $arrayInvFinal[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td class="periodos">DPP</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { 
                $styleDpp = ($arrayDPP[$i - 1] == '')? 'mps0' : '';
                ?>
                <td class="numeros <?php echo $styleDpp; ?>"><?php echo $arrayDPP[$i - 1]; ?></td>
            <?php } ?>
        </tr>
    </table>
</div>


<div class="periodos-pedidos">
    <div class="pronosticos">Pronósticos</div>
    <table class="tabla-pronosticos">
        <tr>
            <th>Mensual</th> 
            <th>Cantidad</th>
            <th>Pedidos</th>  
        </tr>
        <?php for ($i = $periodoInicio, $j = 0; $i <= $periodoFinal; $i++, $j++) { ?>
            <tr>
                <td class="meses"><?php echo $meses[$i] ?></td>
                <td><?php echo $pronosticos[$j] ?></td>
                <td><?php echo $pedidos[$j] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="btn-inicio">
    <a href="javascript:cargarContenido('mps.php')"><button class="inicio">Nuevo Cálculo MPS</button></a>
</div>

