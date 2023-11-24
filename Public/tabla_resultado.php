
<?php

$mesInicio = $_POST['mes1'];
$mesFinal = $_POST['mes2'];
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

$aux = $mesInicio;
$aux2 = $mesFinal;
$primerPeriodo = ($aux - $mesInicio) + 1;
$ultimoPeriodo = $mesFinal - $mesInicio + 1;

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

$aux = $mesInicio;
$aux2 = $mesFinal;
$primerPeriodo = ($aux - $mesInicio) + 1;
$ultimoPeriodo = $mesFinal - $mesInicio + 1;

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
    <h1>Resulatos MPS</h1>
    <div class="datosEntrada">
        <h2>Inventario Inicial</h2>
        <p><?php echo $inventarioInicial; ?></p>
    </div>
    <div class="datosEntrada">
        <h2>Tamaño del Lote <br> Producción por periodo</h2>
        <p><?php echo $lote; ?></p>
    </div>
    <table border="1">
        <tr>
            <th>Mensual</th>
            <?php for ($i = $mesInicio; $i <= $mesFinal; $i++) { ?>
                <th><?php echo $meses[$i] ?></th>
            <?php } ?>
        </tr>
        <tr>
            <td>Inventario Inicial</td>
            <?php 
            // $invIni = $mesInicio;
            for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <td><?php echo ($i == $primerPeriodo) ? $inventarioInicial : $arrayInvFinal[$i - 2]; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Pronósticos</td>
            <?php for ($i = 0; $i < count($pronosticos); $i++) { ?>
                <td><?php echo $pronosticos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Pedidos</td>
            <?php for ($i = 0; $i < count($pedidos); $i++) { ?>
                <td><?php echo $pedidos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>MPS/PMP</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <td><?php echo $arrayMPS[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Inventario Final</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <td><?php echo $arrayInvFinal[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>DPP</td>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <td><?php echo $arrayDPP[$i - 1]; ?></td>
            <?php } ?>
        </tr>
    </table>



    <div class="pronosticos">Pronósticos</div>
    <table border="1">
    <tr>
        <th>Mensual</th> 
        <th>Cantidad</th>
        <th>Pedidos</th>  
    </tr>
    <?php for ($i = $mesInicio, $j = 0; $i <= $mesFinal; $i++, $j++) { ?>
        <tr>
            <td><?php echo $meses[$i] ?></td>
            <td><?php echo $pronosticos[$j] ?></td>
            <td><?php echo $pedidos[$j] ?></td>
        </tr>
    <?php } ?>
</table>

</div>