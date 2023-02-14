<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Usuario;
use dwesgram\modelo\BaseDatos;

class UsuarioBd
{
    use BaseDatos;

    public static function insertar(Usuario $usuario)
    { {
            try {
                $username = $usuario->nombre;
                $clave = $usuario->clave;
                $email = $usuario->email;
                $avatar = $usuario->avatar;
                $clavehash = password_hash($clave, PASSWORD_BCRYPT);
                $conexion = BaseDatos::getConexion();
                $sentencia = $conexion->prepare("insert into usuario (nombre,clave,email,avatar) values (?,?,?,?)");
                $sentencia->bind_param('ssss', $username, $clavehash, $email, $avatar);
                $sentencia->execute();
                return $conexion->insert_id;
            } catch (\Exception $e) {
                echo $e->getMessage();
                return null;
            }
        }
    }

    public static function getNombreUsuarioPorId(int $id)
    { {
            try {
                $userid = $id;
                $conexion = BaseDatos::getConexion();
                $sentencia = $conexion->prepare("select nombre from usuario where id=?");
                $sentencia->bind_param('i', $userid);
                $sentencia->execute();
                $resultado = $sentencia->get_result();
                $fila = $resultado->fetch_assoc();
                if ($fila == null) {
                    return null;
                } else {
                    return $fila['nombre'];
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                return null;
            }
        }
    }

    public static function getUsuarioPorNombre(string $nombre): Usuario|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,nombre,clave,email,avatar from usuario where nombre=?");
            $sentencia->bind_param('s', $nombre);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Usuario(
                    nombre: $fila['nombre'],
                    clave: $fila['clave'],
                    email: $fila['email'],
                    avatar: $fila['avatar'],
                    id: $fila['id'],
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
