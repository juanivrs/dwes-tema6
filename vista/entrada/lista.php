<?php

use dwesgram\modelo\EntradaBd;
use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\LikeBd;

if (!empty($datosParaVista['datos'])) {
    echo "<div class='container'>";
    foreach ($datosParaVista['datos'] as $iterador => $entrada) {
        echo "<div class='container' style='width:250px;'>";
        $nombreusuario = UsuarioBD::getNombreUsuarioPorId($entrada->getUsuario());
        echo $entrada->getImagen() != null ?  "<img style='width:100%;height:70%; border-radius: 30px;' src={$entrada->getImagen()} alt='Image 1'/>" : '';
        echo "<p style=''> $nombreusuario Escribió:</p>";
        echo "<p> {$entrada->getTexto()}</p>";
        echo "<a class='btn btn-dark' style='margin:2px;' href='index.php?controlador=entrada&accion=detalle&id={$entrada->getId()}'>Ver </a>";
        if ($sesion->haySesion()) {

            if ($sesion->getId() === intval(EntradaBd::getAutorDeEntrada($entrada->getId()))) {
                echo "<a class='btn btn-warning' style='margin:2px;' href='index.php?controlador=entrada&accion=eliminar&id={$entrada->getId()}'>Eliminar </a>";
                echo <<<END
                    <button type="button" class="btn btn-secondary" style="pointer-events: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
                    </svg>
                    {$entrada->getLikes()}
                    </button>
                  END;
            } else if (LikeBd::checkUserLike($entrada->getId(), $sesion->getId()) === true) {

                echo <<<END
            <a href='index.php?controlador=entrada&accion=like&id={$entrada->getId()}' class="btn btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
            </svg>
              {$entrada->getLikes()}
              </a>
            END;
            } else {
                echo <<<END
             <a href='index.php?controlador=entrada&accion=like&id={$entrada->getId()}' class="btn btn-outline-danger">
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heartbreak-fill" viewBox="0 0 16 16">
            <path d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586ZM7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77Z"></path>
            </svg>
              {$entrada->getLikes()}
              </a>
            END;
            }
        } else {

            echo <<<END
        <button type="button" class="btn btn-secondary" style="pointer-events: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
        </svg>
        {$entrada->getLikes()}
            </button>
        END;
        }
        echo " </div>";
        echo "<hr/>";
    }
    echo " </div>";
} else { ?>

<div class="alert alert-primary" role="alert">
    No tienes ninguna entrada
</div>
<?php } ?>