<?php
include("funciones.php");

if(isset($_POST["agregar"]))
{

    $descripcion=$_POST["descripcion"];
    $monto=$_POST["monto"];

    if($descripcion!="" && $monto>0)
    {
        agregarTransaccion($descripcion,$monto);
    }
}

if(isset($_POST["limpiar"]))
{
    $_SESSION["transacciones"]=[];
}

generarArchivo();

$total=obtenerTotal();
$interes=calcularInteres($total);
$cash=calcularCashBack($total);
$totalConInteres=$total+$interes;
$totalFinal=$totalConInteres-$cash;

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<title>Sistema Tarjeta de Crédito</title>

<link rel="stylesheet" href="../assets/styles/styles.css">

</head>

<body>

<div class="contenedor">

<h1>Estado de Cuenta</h1>

<form method="POST">

<label>Descripción</label>

<input
type="text"
name="descripcion"
required>

<label>Monto</label>

<input
type="number"
step="0.01"
name="monto"
required>

<button
type="submit"
name="agregar">
Agregar Transacción
</button>

<button
type="submit"
name="limpiar">
Limpiar Todo
</button>

</form>

<table>

<tr>

<th>#</th>

<th>Descripción</th>

<th>Monto</th>

</tr>

<?php

$contador=1;

foreach($_SESSION["transacciones"] as $t)
{

echo "<tr>";

echo "<td>".$contador."</td>";

echo "<td>".$t["descripcion"]."</td>";

echo "<td>₡".number_format($t["monto"],2)."</td>";

echo "</tr>";

$contador++;

}

?>

</table>

<div class="resumen">

<h2>Resumen</h2>

<p><strong>Total de Contado:</strong>
₡<?php echo number_format($total,2); ?>
</p>

<p><strong>Interés (2.6%):</strong>
₡<?php echo number_format($interes,2); ?>
</p>

<p><strong>Total con Interés:</strong>
₡<?php echo number_format($totalConInteres,2); ?>
</p>

<p><strong>Cash Back (0.1%):</strong>
₡<?php echo number_format($cash,2); ?>
</p>

<h3>

Monto Final a Pagar:

₡<?php echo number_format($totalFinal,2); ?>

</h3>

</div>

<p>

El archivo
<strong>estado_cuenta.txt</strong>
se genera automáticamente en la carpeta del proyecto.

</p>

</div>

</body>

</html>