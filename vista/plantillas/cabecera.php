<?php
if ($sesion->haySesion()) {

  $avatar = $sesion->getAvatar();
  if ($avatar === null) {
    $avatar = "assets/avatar/default.png";
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWESgram</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
    .profile {
        display: flex;
        align-items: center;
        margin-left: auto;
    }

    .profile-picture {
        width: 40px;
        height: 40px;
        border-radius: 20px;
        overflow: hidden;
        margin-right: 10px;
    }

    .profile-picture img {
        width: 100%;
    }

    .profile-name {
        font-size: 18px;
    }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">DWESgram</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if ($sesion->haySesion()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controlador=entrada&accion=nuevo">Crear entrada</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if ($sesion->haySesion()) { ?>
            <div class="profile">
                <div class="profile-picture">
                    <img src="<?= $avatar ?>" />
                </div>
                <div class=" profile-name" style="margin-right:10px"><?= $sesion->getNombre() ?></div>
            </div>
            <a class="btn btn-outline-success" href="index.php?controlador=usuario&accion=logout  ">Log Out</a>

            <?php } else { ?>
            <a class="btn btn-outline-success" href="index.php?controlador=usuario&accion=login">Login</a>
            <a class="btn btn-outline-success" href="index.php?controlador=usuario&accion=registro">Register</a>
            <?php } ?>
        </div>
    </nav>