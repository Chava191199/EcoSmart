<?php

/* =========================
   OBTENER RECOMENDACIONES
   (VERSIÓN MEJORADA)
========================= */
function obtenerRecomendaciones($conexion, $tipo, $consumo) {

    // Validación básica
    $tipo = mysqli_real_escape_string($conexion, $tipo);
    $consumo = floatval($consumo);

    // Query optimizada
    $sql = "SELECT id, titulo, descripcion, consumo_min, consumo_max
            FROM recomendaciones
            WHERE tipo = '$tipo'
            AND activa = 1
            AND $consumo BETWEEN consumo_min AND consumo_max
            ORDER BY consumo_min ASC";

    $resultado = mysqli_query($conexion, $sql);

    $recomendaciones = [];

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $recomendaciones[] = $row;
        }
    }

    return $recomendaciones;
}


/* =========================
   NIVEL DE CONSUMO
   (REUTILIZABLE)
========================= */
function obtenerNivelConsumo($tipo, $consumo) {

    $consumo = floatval($consumo);

    if ($tipo == "energia") {

        if ($consumo < 100) return "🟢 Bajo";
        if ($consumo < 200) return "🟡 Medio";
        return "🔴 Alto";
    }

    if ($tipo == "agua") {

        if ($consumo < 5000) return "🟢 Bajo";
        if ($consumo < 12000) return "🟡 Medio";
        return "🔴 Alto";
    }

    if ($tipo == "gas") {

        if ($consumo < 20) return "🟢 Bajo";
        if ($consumo < 40) return "🟡 Medio";
        return "🔴 Alto";
    }

    return "Sin datos";
}


/* =========================
   CALCULAR COSTO
   (EVITA REPETICIÓN)
========================= */
function calcularCosto($tipo, $consumo) {

    $consumo = floatval($consumo);

    switch ($tipo) {

        case "energia":
            return $consumo * 0.799;

        case "agua":
            return $consumo * 0.030;

        case "gas":
            return $consumo * 12.50;

        default:
            return 0;
    }
}

?>
