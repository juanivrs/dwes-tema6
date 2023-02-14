<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\Usuario as UsuarioModelo;

use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;

class UsuarioControlador extends Controlador
{


    public function login(): array|string|null
    {
        if ($this->autenticado()) {
            header('Location: index.php');
            return null;
        }

        if (!$_POST) {
            $this->vista = 'usuario/login';
            return null;
        }


        $nombreuser = $_POST && isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';

        $claveuser = $_POST && isset($_POST['clave']) ? htmlspecialchars(trim($_POST['clave'])) : '';

        $usertoverify = UsuarioBd::getUsuarioPorNombre($nombreuser);


        if ($usertoverify === null || password_verify($claveuser, $usertoverify->clave) === false) {
            $this->vista = 'usuario/login';
            return [
                'nombre' => $nombreuser,
                'error' => 'Usuario y/o contraseña incorrectos'
            ];
        } else {
            $_SESSION['usuario'] = [
                'id' => $usertoverify->id,
                'nombre' => $usertoverify->nombre,
                'avatar' => $usertoverify->avatar
            ];
            header('Location: index.php');
            return null;
        }
    }

    public function registro(): UsuarioModelo|array|string|null
    {
        if ($this->autenticado()) {
            header('Location: index.php');
            return null;
        }
        //Si no llega post cargamos formulario vacio
        if (!$_POST) {
            $this->vista = 'usuario/registro';
            return null;
        }

        //si llega post creamos modelo usuario con post
        $usuario = UsuarioModelo::crearUsuarioDesdePost($_POST, $_FILES);

        if (!$usuario->esValido()) {
            $this->vista = 'usuario/registro';
            return $usuario;
        }

        //Insertamos el usuario en la base de datos
        $id = UsuarioBd::insertar($usuario);
        if ($id !== null) {
            $this->vista = 'usuario/mensaje';
            return 'Te has registrado correctamente ... Ya puedes iniciar sesion';
        } else {
            $this->vista = 'usuario/mensaje';
            return 'No se ha podido llevar a cabo el registro, prueba mas tarde';
        }
    }

    public function logout(): void
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return;
        }

        session_destroy();
        header('Location: index.php');
    }
}
