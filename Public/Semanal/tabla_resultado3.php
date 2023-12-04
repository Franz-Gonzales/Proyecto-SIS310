
<?php
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
$semanas = $_POST['semanas'];
$periodoInicio = $_POST['periodoInicio'];
$periodoFinal = $_POST['periodoFinal'];
$inventarioInicial = $_POST['inventarioInicial'];
$lote = $_POST['lote'];

//Para semanas mayor a 5
$mesInicio = isset($_POST['mesInicio']) ? $_POST['mesInicio'] : '';
$mesConcluir = isset($_POST['mesConcluir']) ? $_POST['mesConcluir'] : '';


$pronosticos = $_POST['pronosticos'];
$pedidos = $_POST['pedidos'];

echo 'Mes o mesInicio = '. $mes.$mesInicio. '<br>';
echo 'Periodo Inicio = '. $periodoInicio. '<br>';
echo 'Periodo Final = '. $periodoFinal. '<br>';
echo 'Semanas = '. $semanas. '<br>';
echo 'Inventario Inicial = '. $inventarioInicial. '<br>';
echo 'Lote = '. $lote. '<br>';
echo 'mesConcluir = '. $mesConcluir. '<br>';


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
// $ultimoPeriodo = $periodoFinal - $periodoInicio + 1;
$ultimoPeriodo = $semanas;

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
// $ultimoPeriodo = $periodoFinal - $periodoInicio + 1;
$ultimoPeriodo = $semanas;

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
    <div class="mes">Periodos semanales del mes <?php echo $meses[$mesInicio] ?> a <?php echo $meses[$mesConcluir] ?></div>
        <tr>
            <th>Semanas</th>
            <?php for ($i = $primerPeriodo; $i <= $ultimoPeriodo; $i++) { ?>
                <th class="tipo-periodo"><?php echo 'Semana ' .$i ?></th>
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
            <th>Meses-semanales</th>
            <th>Semanas</th> 
            <th>Cantidad/Semanal</th>
            <th>Pedidos/Semanales</th> 
        </tr>
        <?php 
        $semaInicio = ($periodoInicio - $periodoInicio) + 1; 
        for($i = $semaInicio; $i <= $periodoFinal; $i++){ 

            $sm = 5 - $periodoInicio;
            if($i <= $sm){
                $mes = $mesInicio;
            }else{
                $sm2 = $sm + 4;
                if($mesInicio < $mesInicio + 1 &&  $i > $sm && $i <= $sm2){
                    $mes = $mesInicio + 1;
                }else{
                    if($mesConcluir > $mesInicio + 2 && $i > $sm2 && $i <= $sm2 + 4){
                        $mes = $mesConcluir - 1;
                    }else{
                        $mes = $mesConcluir;
                    }
                }
            }
            ?>
            <tr>
                <td class="meses"><?php echo $meses[$mes] ?></td>
                <td class="semana"><?php echo 'Semana '. $i ?></td>
                <td><?php echo $pronosticos[$i - 1] ?></td>
                <td><?php echo $pedidos[$i - 1] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="btn-inicio">
    <a href="javascript:cargarContenido('mps.html')"><button class="inicio">Nuevo Cálculo MPS</button></a>
</div>

