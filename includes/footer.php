<footer class="footer">

<div class="container">

<div class="row">

<div class="col-md-4">

<img
src="/EcoSmart/assets/img/logo.png"
class="footer-logo">

<h3>
EcoSmart Solutions
</h3>

<p>
ODS 13 — Acción por el Clima
</p>

</div>

<div class="col-md-4">

<h4>
Enlaces
</h4>

<ul class="footer-links">

<li>
<a href="/EcoSmart/index.php">
Inicio
</a>
</li>

<li>
<a href="/EcoSmart/index.php#informacion">
Información
</a>
</li>

<li>
<a href="/EcoSmart/index.php#campanas">
Campañas
</a>
</li>

<li>
<a href="/EcoSmart/index.php#proyectos">
Proyectos
</a>
</li>

</ul>

</div>

<div class="col-md-4">

<h4>
Contacto
</h4>

<p>
📧 contacto@ecosmart.com
</p>

<p>
📍 México
</p>

</div>

</div>

<hr>

<div class="text-center">
© 2026 EcoSmart Solutions
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function toggleUserMenu() {

    const menu = document.getElementById("userMenu");

    if(menu){
        menu.classList.toggle("show");
    }

}

document.addEventListener("click", function(event){

    const menu = document.getElementById("userMenu");

    const button = document.querySelector(".user-btn");

    if(!menu || !button){
        return;
    }

    if(
        !button.contains(event.target) &&
        !menu.contains(event.target)
    ){
        menu.classList.remove("show");
    }

});

</script>

</body>
</html>