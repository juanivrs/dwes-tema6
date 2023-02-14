<?php

use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\LikeBd;
use dwesgram\modelo\EntradaBd;

if (!empty($datosParaVista['datos']) && $datosParaVista['datos'] != null) {
    $entrada = $datosParaVista['datos'];
    $usuarioid = $entrada->getUsuario();
    $usuarioname = UsuarioBd::getNombreUsuarioPorId($usuarioid);
    $texto = $entrada->getTexto();
    $img = $entrada->getImagen();
    $likes = $entrada->getLikes();
    echo "<h1>$usuarioname Escribió:</h1>";
    echo "<div style='margin-right:100px'>";
    if ($sesion->haySesion()) {

        if ($sesion->getId() === intval(EntradaBd::getAutorDeEntrada($entrada->getId()))) {
            echo "<a href='index.php?controlador=entrada&accion=eliminar&id={$entrada->getId()}' class='btn btn-danger'>Eliminar</a>";
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
            $likes
              </a>
            END;
        } else {
            echo <<<END
             <a href='index.php?controlador=entrada&accion=like&id={$entrada->getId()}' class="btn btn-outline-danger">
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heartbreak-fill" viewBox="0 0 16 16">
            <path d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586ZM7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77Z"></path>
            </svg>
            $likes
              </a>
            END;
        }
    } else {

        echo <<<END
        <button type="button" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
        </svg>
        $likes
            </button>
        END;
    }
    echo "</div>";
    echo <<<END
   
    <br/>
     <div class="alert alert-primary" role="alert">
       {$texto}
    </div>
    END;
    if ($img !== null) {

        echo " <div><img src='$img' style='width:30%';height:30%;> </div>";
    }
} else {
    echo "<p>No existe esta entrada</p>";
}
