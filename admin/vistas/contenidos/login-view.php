<?php
if (isset($_POST['usuario_login']) && isset($_POST['clave_login'])) {
  require_once "./controladores/loginControlador.php";

  $ins_login = new loginControlador();
  echo $ins_login->iniciar_sesion_controlador();
}
?>

   
    <link rel="stylesheet" href="vistas/css/login.css"> <!-- CSS personalizado -->
<div class="row no-gutters vh-100">
    <div class="col-md-6 position-relative">
        <img src="vistas/images/general/wave1.png" alt="Veterinaria" class="img-fluid clean-image">
        <img src="vistas/images/general/bg.svg" alt="Veterinaria" class="img-fluid clean-image overlay-image">
    </div>
    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
        <img src="vistas/images/general/avatar1.svg" alt="Logo" class="logo">
        <h1 class="welcome-title">BIENVENIDO</h1>
        <form action="" method="POST" class="w-100 px-4" style="max-width: 400px;">
            <div class="form-group">
                <label for="usuario_login">Usuario</label>
                <input type="text" name="usuario_login" class="form-control" maxlength="35" required>
            </div>
            <div class="form-group">
                <label for="clave_login">Clave</label>
                <div class="input-group">
                    <input type="password" name="clave_login" class="form-control" maxlength="100" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Iniciar Sesión</button>
        </form>
    </div>
</div>

<script src="vistas/js/login.js"></script>



