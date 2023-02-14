<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Entrada extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $texto,
        private int|null $id = null,
        private string|null $imagen = null,
        private int|null $usuario,
        private array|null $likelist = []
    ) {
        $this->errores = [
            'texto' => $texto === null || empty($texto) ? 'El texto no puede estar vacío' : null,
            'imagen' => null,
            'usuario' => $usuario === null || empty($usuario) ? 'La entrada debe tener usuario.' : null,
        ];
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getLikes(): int|null
    {
        $this->reloadLikes();
        return count($this->likelist);
    }

    public function reloadLikes(): void
    {
        $resultado = LikeBd::getLikesfromEntry($this->id);
        if ($resultado !== false && $resultado !== null) {
            $this->likelist = $resultado;
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexto(): string
    {
        return $this->texto ? $this->texto : '';
    }

    public function getUsuario(): int
    {
        return $this->usuario ? $this->usuario : -1;
    }

    public function getImagen(): string|null
    {
        return $this->imagen;
    }

    public function esValida(): bool
    {
        if (
            $this->errores['texto'] === null &&
            $this->errores['imagen'] === null
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function getErrores(): array
    {
        return $this->errores;
    }


    /**
     * To refactor.
     */
    public static function crearEntradaDesdePost(array $post, array $files): Entrada|null
    {
        $descripcion = $post && isset($post['texto']) ? htmlspecialchars(trim($post['texto'])) : '';
        $usuario = $post && isset($post['userid']) ? htmlspecialchars(trim($post['userid'])) : '';



        if (!empty($files['imagen']['name']) || $files['imagen']['error'] === 1) {
            $imagen = Utils::validarImagen("imagen", $files, "./assets/img/");

            if ($imagen === null || $imagen === false) {
                $entrada = new Entrada(
                    texto: $descripcion,
                    usuario: $usuario
                );
                $imagen === false ? $entrada->errores['imagen'] = 'Error en la subida ,solo se pueden subir archivos con extension jpeg/png..' : '';
                return $entrada;
            } else {
                $entrada = new Entrada(
                    texto: $descripcion,
                    imagen: $imagen,
                    usuario: $usuario
                );

                return $entrada;
            }
        } else {
            $entrada = new Entrada(
                texto: $descripcion,
                usuario: $usuario
            );
            return $entrada;
        }
    }
}