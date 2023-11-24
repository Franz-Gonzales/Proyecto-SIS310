<?php
$arrayMPS = array();
$arrayInvFinal = array();
for ($i = $mesInicio; $i <= $mesFinal; $i++) {

    $inventarioAnterior = ($i == $mesInicio) ? $inventarioInicial : $arrayInvFinal[$i - 2];
    $mps = calcularMPS($inventarioAnterior, $pronosticos[$i - 1], $pedidos[$i - 1], $lote);

    array_push($arrayMPS, $mps);

    $inventarioAnterior = ($i == $mesInicio) ? $inventarioInicial : $arrayInvFinal[$i - 2];
    $inventarioFinal = $inventarioAnterior + $arrayMPS[$i - 1] - max($pronosticos[$i - 1], $pedidos[$i - 1]);

    array_push($arrayInvFinal, $inventarioFinal);

}


$arrayDPP = array();
for ($i = $mesInicio; $i <= $mesFinal; $i++) {

    $inventarioAnterior = ($i == $mesInicio) ? $inventarioInicial : $arrayInvFinal[$i - 2];

    if ($i < $mesFinal && $arrayMPS[$i] == 0) {
        // Si el MPS del siguiente periodo es cero
        $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - ($pedidos[$i - 1] + $pedidos[$i]);
    } else {
        // Si el MPS del siguiente periodo no es cero
        $dpp = $inventarioAnterior + $arrayMPS[$i - 1] - $pedidos[$i - 1];
    }

    array_push($arrayDPP, $dpp);

    if ($arrayMPS[$i - 1] == 0) {

        $arrayDPP[$i - 1] = 0;
    }

}
?>


<div class="tabla">
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
            <?php for ($i = $mesInicio; $i <= $mesFinal; $i++) { ?>
                <td><?php echo ($i == $mesInicio) ? $inventarioInicial : $arrayInvFinal[$i - 2]; ?></td>
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
            <?php for ($i = $mesInicio; $i <= $mesFinal; $i++) { ?>
                <td><?php echo $arrayMPS[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Inventario Final</td>
            <?php for ($i = $mesInicio; $i <= $mesFinal; $i++) { ?>
                <td><?php echo $arrayInvFinal[$i - 1] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>DPP</td>
            <?php for ($i = $mesInicio; $i <= $mesFinal; $i++) { ?>
                <td><?php echo $arrayDPP[$i - 1]; ?></td>
            <?php } ?>
        </tr>
    </table>
</div>