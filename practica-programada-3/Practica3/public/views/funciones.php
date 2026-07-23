<?php
session_start();

if (!isset($_SESSION["transacciones"])) {
    $_SESSION["transacciones"] = [];
}

function agregarTransaccion($descripcion, $monto)
{
    $_SESSION["transacciones"][] = [
        "descripcion" => $descripcion,
        "monto" => $monto
    ];
}

function obtenerTotal()
{
    $total = 0;

    foreach ($_SESSION["transacciones"] as $t) {
        $total += $t["monto"];
    }

    return $total;
}

function calcularInteres($total)
{
    return $total * 0.026;
}

function calcularCashBack($total)
{
    return $total * 0.001;
}

function generarArchivo()
{
    $contenido = "";

    $contenido .= "========= ESTADO DE CUENTA =========\n\n";

    foreach ($_SESSION["transacciones"] as $t) {
        $contenido .= "Descripción: " . $t["descripcion"] .
            " | Monto: ₡" . number_format($t["monto"], 2) . "\n";
    }

    $total = obtenerTotal();
    $interes = calcularInteres($total);
    $cash = calcularCashBack($total);
    $totalFinal = ($total + $interes) - $cash;

    $contenido .= "\n";
    $contenido .= "---------------------------------\n";
    $contenido .= "Total de contado: ₡" . number_format($total,2)."\n";
    $contenido .= "Interés (2.6%): ₡".number_format($interes,2)."\n";
    $contenido .= "Total con interés: ₡".number_format($total+$interes,2)."\n";
    $contenido .= "Cash Back (0.1%): ₡".number_format($cash,2)."\n";
    $contenido .= "Monto Final: ₡".number_format($totalFinal,2)."\n";

    file_put_contents("estado_cuenta.txt", $contenido);
}
?>