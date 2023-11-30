

<?php

$periodoInicio = $_POST['periodoInicio'];
$periodoFinal = $_POST['periodoFinal'];
$inventarioInicial = $_POST['inventarioInicial'];
$lote = $_POST['lote'];

$mensual = [1 => 'Enero',2 => 'Febrero',3 => 'Marzo',4 => 'Abril',5 => 'Mayo',6 => 'Junio',7 => 'Julio',8 => 'Agosto',9 => 'Septiembre',10 => 'Octubre',11 => 'Noviembre',12 => 'Diciembre'];

?>

<div class="datos-container">
    <h1>Ingrese los Pronósticos y Pedidos para los Periodos</h1>
    <form action="javascript:calcularResultado()" method="post" id="formulario-datos">
        <table>
            <tr>
                <th>Periodo</th>
                <th>Pronósticos</th>
                <th>Pedidos</th>
            </tr>
            <?php for($i = $periodoInicio; $i <= $periodoFinal; $i++){ ?>
                <tr>
                    <td class="meses"><?php echo $mensual[$i]; ?></td>
                    <td><input type="number" name="pronosticos[]"></td>
                    <td><input type="number" name="pedidos[]"></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" value="Calcular Resultado" class="resultados">
        <input type="hidden" name="inventarioInicial" value="<?php echo $inventarioInicial; ?>">
        <input type="hidden" name="lote" value="<?php echo $lote; ?>">
        <input type="hidden" name="periodoInicio" value="<?php echo $periodoInicio; ?>">
        <input type="hidden" name="periodoFinal" value="<?php echo $periodoFinal; ?>">
    </form>
</div>
