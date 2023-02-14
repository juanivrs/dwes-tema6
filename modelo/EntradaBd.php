<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Entrada;

class EntradaBd
{
    use BaseDatos;

    public static function insertar(Entrada $entrada): int|null
    {
        try {
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            $autor =   $entrada->getUsuario();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into entrada (texto,imagen,autor) values (?,?,?)");
            $sentencia->bind_param('ssi', $texto, $imagen, $autor);
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getEntrada(int $id): Entrada|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id,texto,imagen,autor from entrada where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                if ($fila['imagen'] === null) {
                    return new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        usuario: $fila['autor'],
                    );
                } else {
                    return new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        imagen: $fila['imagen'],
                        usuario: $fila['autor'],
                    );
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getAutorDeEntrada(int $id): String|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select autor from entrada where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return $fila['autor'];
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public static function getEntradas(): array
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $queryResultado = $conexion->query("select id, texto, imagen,autor from entrada order by creado");
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {
                    if ($fila['imagen'] === null) {
                        $entrada = new Entrada(
                            id: $fila['id'],
                            texto: $fila['texto'],
                            usuario: $fila['autor'],
                        );
                    } else {
                        $entrada = new Entrada(
                            id: $fila['id'],
                            texto: $fila['texto'],
                            imagen: $fila['imagen'],
                            usuario: $fila['autor'],
                        );
                    }
                    $resultado[] = $entrada;
                }
            }
            return $resultado;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public static function eliminar(int $id): bool|string|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from entrada where id=?");
            $sentencia->bind_param('i', $id);
            return $sentencia->execute();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}