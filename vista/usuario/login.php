<?php


$us = $datosParaVista['datos'];

$name = isset($us['nombre']) ? $us['nombre'] : "";

?>

<div class="container">
    <h1>Inicia sesión</h1>

    <form action="index.php?controlador=usuario&accion=login" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de usuario</label><br>
            <input type="text" id="nombre" name="nombre" value="<?= $name ?>">
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label><br>
            <input type="password" id="clave" name="clave">
        </div>
        <?php
        if (isset($us['error'])) {
            echo <<<END
             <div class="alert alert-danger" role="alert">
             {$us['error']}
            </div>
            END;
        }
        ?>

        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>