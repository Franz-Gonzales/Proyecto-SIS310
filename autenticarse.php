<?php session_start();

include('db.php');

$email = $_POST['email'];
$password = sha1($_POST['password']);

$sql = "SELECT nombre, email, rol FROM usuario WHERE email = '$email'";

echo $sql;

$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['email'] = $fila['email'];
    $_SESSION['rol'] = $fila['rol'];
    header('Location:mps.php');
} else { ?>
    <p>Usuario o Contraseña incorrectos</p>
    <meta http-equiv="refresh" content="3;url=login.html">
<?php }
?>