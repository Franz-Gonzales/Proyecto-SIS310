

<?php
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
$semanas = $_POST['semanas'];
$periodoInicio = $_POST['periodoInicio'];
$periodoFinal = $_POST['periodoFinal'];
$inventarioInicial = $_POST['inventarioInicial'];
$lote = $_POST['lote'];

$pronostico_mensual = isset($_POST['pronostico-mensual']) ? $_POST['pronostico-mensual'] : '';


//Para semanas mayor a 5
$mesInicio = isset($_POST['mesInicio']) ? $_POST['mesInicio'] : '';
$mesConcluir = isset($_GET['mesConcluir']) ? $_GET['mesConcluir'] : '';

echo 'Mes o mesInicio = '. $mes.$mesInicio. '<br>';
echo 'Periodo Inicio = '. $periodoInicio. '<br>';
echo 'Periodo Final = '. $periodoFinal. '<br>';
echo 'Semanas = '. $semanas. '<br>';
echo 'Inventario Inicial = '. $inventarioInicial. '<br>';
echo 'Lote = '. $lote. '<br>';
echo 'mesConcluir = '. $mesConcluir. '<br>';

$mensual = [1 => 'Enero',2 => 'Febrero',3 => 'Marzo',4 => 'Abril',5 => 'Mayo',6 => 'Junio',7 => 'Julio',8 => 'Agosto',9 => 'Septiembre',10 => 'Octubre',11 => 'Noviembre',12 => 'Diciembre'];

?>


<?php
    if($semanas == 4){ ?>

        <div class="datos-container">
                <h1>Ingrese los Pronósticos y Pedidos para los Periodos</h1>
                <form action="javascript:calcularResultadoSemanal()" method="post" id="formulario-datos">
                    <h2>Introducir los datos para mes de: <?php echo $mensual[$mes] ?></h2>
                    <table>
                        <tr>
                            <th>Periodo</th>
                            <th>Pronósticos</th>
                            <th>Pedidos</th>
                        </tr>
                        <?php for($i = $periodoInicio; $i <= $periodoFinal; $i++){ ?>
                            <tr>
                                <td class="meses"><?php echo 'Semana '.$i; ?></td>
                                <td><input type="number" value="<?php echo $pronostico_mensual ?>" name="pronosticos[]"></td>
                                <td><input type="number" name="pedidos[]"></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <input type="submit" value="Calcular Resultado" class="resultados">

                    <input type="hidden" name="inventarioInicial" value="<?php echo $inventarioInicial; ?>">
                    <input type="hidden" name="lote" value="<?php echo $lote; ?>">
                    <input type="hidden" name="periodoInicio" value="<?php echo $periodoInicio; ?>">
                    <input type="hidden" name="periodoFinal" value="<?php echo $periodoFinal; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    <input type="hidden" name="semanas" value="<?php echo $semanas; ?>">
                </form>
        </div>

<?php }else{

    if($semanas <= 3){ ?>

        <div class="datos-container">
            <h1>Ingrese los Pronósticos y Pedidos para los Periodos</h1>
            <form action="javascript:calcularResultadoSemanal2()" method="post" id="formulario-datos">
                <h2>Introducir los datos para mes de: <?php echo $mensual[$mes] ?></h2>
                <table>
                    <tr>
                        <th>Periodo</th>
                        <th>Pronósticos</th>
                        <th>Pedidos</th>
                    </tr>
                    <?php for($i = $periodoInicio; $i <= $periodoFinal; $i++){ ?>
                        <tr>
                            <td class="meses"><?php echo 'Semana '.$i; ?></td>
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
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                <input type="hidden" name="semanas" value="<?php echo $semanas; ?>">
            </form>
        </div>

   <?php }else{

    if($semanas >= 5){ ?>

        <div class="datos-container">
            <h1>Ingrese los Pronósticos y Pedidos para los Periodos</h1>
            <form action="javascript:calcularResultadoSemanal3()" method="post" id="formulario-datos">
                <h2>Introducir los datos para los  periodos semanales</h2>
                <h3>Entre el mes de <?php echo $mensual[$mesInicio] ?> y <?php echo $mensual[$mesConcluir] ?></h3>
                <table>
                    <tr>
                        <th>Meses</th>
                        <th>Periodo</th>
                        <th>Pronósticos</th>
                        <th>Pedidos</th>
                    </tr>
                    <?php
                    $semaInicio = ($periodoInicio - $periodoInicio) + 1; 
                    for($i = $semaInicio; $i <= $periodoFinal; $i++){ 

                        $sm = 5 - $periodoInicio;
                        if($i <= $sm){
                            $meses = $mesInicio;
                        }else{
                            $sm2 = $sm + 4;
                            if($mesInicio < $mesInicio + 1 &&  $i > $sm && $i <= $sm2){
                                $meses = $mesInicio + 1;
                            }else{
                                if($mesConcluir > $mesInicio + 2 && $i > $sm2 && $i <= $sm2 + 4){
                                    $meses = $mesConcluir - 1;
                                }else{
                                    $meses = $mesConcluir;
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo $mensual[$meses] ?></td>
                            <td class="meses"><?php echo 'Semana '.$i; ?></td>
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
                <input type="hidden" name="mesInicio" value="<?php echo $mesInicio; ?>">
                <input type="hidden" name="semanas" value="<?php echo $semanas; ?>">
                <input type="hidden" name="mesConcluir" value="<?php echo $mesConcluir; ?>">
            </form>
        </div>

    <?php }

   }

}

?>