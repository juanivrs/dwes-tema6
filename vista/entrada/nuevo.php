<?php

$entrada = $datosParaVista['datos'];

$errores = $entrada ? $entrada->getErrores() : [];

$texto = $entrada ? $entrada->getTexto() : '';
?>

<div class="container">
    <h1>Nueva entrada</h1>
    <form action="index.php?controlador=entrada&accion=nuevo" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="texto" class="form-label">
                ¿En qué estás pensando? Tienes 128 caracteres para plasmarlo... el resto se ignorará
            </label>
            <textarea class="form-control" name="texto" id="texto" rows="3" placeholder="Escribe aquí el texto"><?= $texto ?></textarea>
        </div>
        <?php
        if (isset($errores['texto']) && $errores !== null) {
            echo <<<END
            <div class="alert alert-danger" role="alert">
             {$errores['texto']}
            </div>
            END;
        }
        ?>
        <div class="mb-3">
            <label for="imagen">Selecciona una imagen para acompañar a tu entrada</label>
            <input class="form-control" type="file" name="imagen" id="imagen">
        </div>
        <?php
        if (isset($errores['imagen']) && $errores !== null) {
            echo <<<END
            <div class="alert alert-danger" role="alert">
             {$errores['imagen']}
            </div>
            END;
        }
        ?>
        <input type="hidden" value="<?= $sesion->getId() ?>" name="userid" id="userid" />
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
</div>