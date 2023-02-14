<?php


$resultado = $datosParaVista['datos'];
if ($resultado === true) {
    echo '<div class="alert alert-primary" role="alert"> Entrada eliminada correctamente </div>';
} else {
    echo '<div class="alert alert-primary" role="alert"> La entrada no se ha podido eliminar </div>';
}

echo <<<END
<p><a href="index.php?controlador=entrada&accion=lista" class="btn btn-primary btn-lg active" role="button">Volver </a> </p>

END;