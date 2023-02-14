<?php

$datos = $datosParaVista['datos'];




echo <<<END
     <div class="alert alert-primary" role="alert">
       {$datos}
    </div>
    END;


echo <<<END
<p><a href="index.php?controlador=entrada&accion=lista" class="btn btn-primary btn-lg active" role="button">Volver </a> </p>

END;
