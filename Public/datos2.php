<h1>Resulatos MPS</h1>
<?php

$mesInicio = $_POST['mes1'];
$mesFinal = $_POST['mes2'];
$inventarioInicial = $_POST['inventarioInicial'];
$lote = $_POST['lote'];

$pronosticos = $_POST['pronosticos'];
$pedidos = $_POST['pedidos'];
$meses = [1 => 'Enero',2 => 'Febrero',3 => 'Marzo',4 => 'Abril',5 => 'Mayo',6 => 'Junio',7 => 'Julio',8 => 'Agosto',9 => 'Septiembre',10 => 'Octubre',11 => 'Noviembre',12 => 'Diciembre'];

echo count($pronosticos);
echo count($pedidos);
echo 'mes final '.$mesFinal;


?>

<div class="tabla">
    <table border="1">
        <tr>
            <th>Periodo</th>
            <?php for($i = $mesInicio; $i <= $mesFinal; $i++){ ?>
                <th><?php echo $meses[$i] ?></th>
            <?php } ?>
        </tr>
        <tr>
            <td>Inventario Inicial</td>
            <?php for($i = $mesInicio; $i <= $mesFinal; $i++){
                 $aux = 0;
                 if($i == $mesInicio){
                     $aux = $inventarioInicial;
                 }else{
                     $aux = $arrayInvFinal[$i-1];
                 }
                 ?>
                <td><?php echo $aux ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Pronósticos</td>
            <?php for($i = 0; $i < count($pronosticos); $i++){ ?>
                <td><?php echo  $pronosticos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Pedidos</td>
            <?php for($i = 0; $i < count($pedidos); $i++){ ?>
                <td><?php echo  $pedidos[$i] ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>MPS/PMP</td>
            <?php 
            $arrayMPS = array();
            for($i = $mesInicio; $i <= $mesFinal; $i++){
                if($inventarioInicial >= max($pronosticos[$i], $pedidos[$i])){
                    $mps = 0;
                }else{
                    $mps = $lote;
                }
                array_push($arrayMPS, $mps)
                ?>
                <td><?php echo  $mps; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Inventario Final</td>
            <?php
            $arrayInvFinal = array();
            for($i = $mesInicio; $i <= $mesFinal; $i++){ 
                // $inveFinal = $inventarioInicial + $arrayMPS[$i] - max($pronosticos[$i], $pedidos[$i]); 
                $inveFinal = $arrayInvFinal[$i-1] + $arrayMPS[$i] - max($pronosticos[$i], $pedidos[$i]);

                array_push($arrayInvFinal, $inveFinal);
                ?>
                <td><?php echo  $inveFinal ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>DPP</td>
            <?php for($i = $mesInicio; $i <= $mesFinal; $i++){
                // $DPP = $arrayInvFinal[$i]+$arrayMPS[$i]-($pedidos[$i]);
                $DPP = $arrayInvFinal[$i] + $arrayMPS[$i] - ($pedidos[$i]);
                if ($arrayMPS[$i] == 0) {
                    $DPP += $pedidos[$i + 1]; // Agregar pedidos del periodo siguiente o futuro
                }
                ?>
                <td><?php echo  $DPP; ?></td>
            <?php } ?>
        </tr>
    </table>
</div>

<?php
  foreach($arrayMPS as $i){
    echo 'mpc->'.$i;
  }
?>
