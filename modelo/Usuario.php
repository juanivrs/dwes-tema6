<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;
use dwesgram\modelo\Entrada;


class Usuario extends Modelo
{
    private array $errores = [];

    public function __construct(
        public string|null $nombre,
        public string|null $clave,
        public string|null $email,
        public string|bool|null $avatar = null,
        public int|null $id = null
    ) {
    }

    public static function crearUsuarioDesdePost(array $post, array $files): Usuario
    {
        $nombreuser = $post && isset($post['nombre']) ? htmlspecialchars(trim($post['nombre'])) : null;
        $claveuser = $post && isset($post['clave']) ? htmlspecialchars(trim($post['clave'])) : null;
        $emailuser = $post && isset($post['email']) ? htmlspecialchars(trim($post['email'])) : null;
        $avatar = !empty($files['avatar']['name']) || $files['avatar']['error'] === 1 ?  Utils::validarImagen("avatar", $files, "./assets/avatar/") : null;
        $repiteClave = $post && isset($post['repiteclave']) ? htmlspecialchars(trim($post['repiteclave'])) : null;

        $usuario = new Usuario(
            nombre: $nombreuser,
            clave: $claveuser,
            email: $emailuser,
            avatar: $avatar,
        );


        $usuario = self::comprobarErrores($usuario, $repiteClave);

        return $usuario;
    }



    public function getErrores(): array
    {
        return $this->errores;
    }

    private static function comprobarErrores(Usuario $usuario, string $clave): Usuario
    {
        if ($usuario->clave !== $clave) {
            $usuario->errores['clave'] = "Las contraseñas son diferentes";
        };

        if (mb_strlen($usuario->email) <= 0) {
            $usuario->errores['email'] = "El campo email no puede estar vacío.";
        };

        if (mb_strlen($usuario->clave) < 8) {
            $usuario->errores['clave'] = "Las contraseñas deben tener , al menos , 8 caracteres";
        }

        $usuario->avatar === false ? $usuario->errores['imagen'] = 'Error en la subida,solo se pueden subir archivos con extension jpeg/png.' : '';

        if (mb_strlen($usuario->nombre) === 0) {
            $usuario->errores['nombre'] = "El nombre de usuario no puede estar vacio";
        } else {
            $otro = UsuarioBd::getUsuarioPorNombre($usuario->nombre);
            if ($otro !== null) {
                $usuario->errores['nombre'] = "El nombre de usuario no esta disponible";
            }
        }

        return $usuario;
    }

    public function esValido(): bool
    {
        return count($this->errores) == 0;
    }
}
