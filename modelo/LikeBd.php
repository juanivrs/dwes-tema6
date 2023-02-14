<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Entrada;
use dwesgram\modelo\Like;

class LikeBd
{
    use BaseDatos;


    public static function checkUserLike(int $entradaid, int $usuarioid): int | bool | null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id from megusta where entrada=? AND usuario=? ");
            $sentencia->bind_param('ii', $entradaid, $usuarioid);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila === null) {
                return true;
            } else {
                return $fila['id'];
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function addLike(int $entradaid, int $usuarioid): bool | null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into megusta (entrada,usuario) values (?,?)");
            $sentencia->bind_param('ii', $entradaid, $usuarioid);
            $sentencia->execute();
            if ($sentencia !== false) {
                return true;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function removeLike(int $id, int $entradaid, int $usuarioid)
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from megusta where id=? AND entrada=? AND usuario = ?");
            $sentencia->bind_param('iii', $id, $entradaid, $usuarioid);
            return $sentencia->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getLikesfromEntry($entradaid): array | bool | null
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, usuario,entrada from megusta where entrada = ? ");
            $sentencia->bind_param('i', $entradaid);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $likelist = [];
            if ($resultado !== false) {
                while (($fila = $resultado->fetch_assoc()) != null) {
                    $like = new Like(
                        id: $fila['id'],
                        usuarioid: $fila['usuario'],
                        entradaid: $fila['entrada'],
                    );
                    $likelist[] = $like;
                }
            }
            return $likelist;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
}