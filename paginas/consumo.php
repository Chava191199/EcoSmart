<?php
session_start();

include __DIR__.'/../config/conexion.php';
include __DIR__.'/../includes/functions.php';

/* =========================
   VALIDAR LOGIN
========================= */
if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

/* =========================
   VARIABLES
========================= */
$consumo = 0;
$costo = 0;
$nivel = "";
$recomendaciones = [];

/* =========================
   PROCESO POST
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $consumo = floatval($_POST["consumo"]);

    mysqli_query(
        $conexion,
        "INSERT INTO consumo_energetico(usuario_id, consumo)
        VALUES('$usuario_id','$consumo')"
    );

    $precio_kwh = 0.799;
    $costo = $consumo * $precio_kwh;

    /* NIVEL */
    if ($consumo < 100) {
        $nivel = "🟢 Bajo";
    } elseif ($consumo < 200) {
        $nivel = "🟡 Medio";
    } else {
        $nivel = "🔴 Alto";
    }

    /* =========================
       RECOMENDACIONES BD
    ========================= */
    $recomendaciones = obtenerRecomendaciones($conexion, "energia", $consumo);
}

include __DIR__.'/../includes/header.php';
include __DIR__.'/../includes/navbar.php';
?>

<!-- ================= HEADER ================= -->
<section class="page-header">
    <div class="container text-center">
        <h1>⚡ Consumo Energético</h1>
        <p>Ingresa tu consumo eléctrico</p>
    </div>
</section>

<div class="container">

<!-- ================= FORMULARIO ================= -->
<div class="section-box">

    <h2>⚡ Registrar Consumo</h2>
    <hr>

    <form method="POST">

        <label>kWh consumidos</label>

        <input type="number"
               step="0.01"
               name="consumo"
               class="form-control"
               required>

        <button class="btn btn-success mt-4 w-100">
            Calcular
        </button>

    </form>

</div>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

<!-- ================= RESULTADO ================= -->
<div class="section-box">

    <h2>📊 Resultado</h2>
    <hr>

    <h3>Consumo: <?= number_format($consumo,2) ?> kWh</h3>
    <h3>Costo: $<?= number_format($costo,2) ?></h3>
    <h3><?= $nivel ?></h3>

</div>

<!-- ================= BOTÓN ================= -->
<div class="section-box text-center">

    <h2>💡 Recomendaciones Personalizadas</h2>
    <hr>

    <button type="button"
            class="btn btn-primary btn-lg"
            onclick="abrirRecomendaciones()">

        💡 Ver recomendaciones
    </button>

</div>

<!-- ================= MODAL ================= -->
<div id="ventanaReco"
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6);z-index:9999;">

    <div style="background:white;color:#333;width:90%;max-width:500px;margin:8% auto;padding:30px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,.3);">

        <h2 style="text-align:center;color:#222;">
            ⚡ Recomendaciones
        </h2>

        <hr>

        <?php if (count($recomendaciones) > 0): ?>

            <?php foreach($recomendaciones as $r): ?>

                <div style="background:#f1f1f1;padding:15px;margin:12px 0;border-radius:10px;">

                    <strong><?= htmlspecialchars($r['titulo']) ?></strong><br>
                    <?= htmlspecialchars($r['descripcion']) ?>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p style="text-align:center;">
                No hay recomendaciones para este consumo.
            </p>

        <?php endif; ?>

        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="cerrarRecomendaciones()">
                Cerrar
            </button>
        </div>

    </div>
</div>

<script>
function abrirRecomendaciones(){
    document.getElementById("ventanaReco").style.display="block";
}

function cerrarRecomendaciones(){
    document.getElementById("ventanaReco").style.display="none";
}

window.onclick = function(event){
    let modal = document.getElementById("ventanaReco");
    if(event.target == modal){
        modal.style.display = "none";
    }
}
</script>

<?php endif; ?>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>