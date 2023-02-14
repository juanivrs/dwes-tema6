<?php

namespace dwesgram\controlador;

use dwesgram\controlador\Controlador;
use dwesgram\modelo\Entrada;
use dwesgram\modelo\EntradaBd;
use dwesgram\utility\Sesion;
use dwesgram\modelo\LikeBd;

class EntradaControlador extends Controlador
{

    public function lista(): array
    {
        $this->vista = "entrada/lista";

        return EntradaBd::getEntradas();
    }

    public function detalle(): Entrada|null
    {
        $this->vista = 'entrada/detalle';
        $id = htmlspecialchars($_GET['id']);
        return EntradaBd::getEntrada($id);
    }

    public function nuevo(): Entrada|null
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return null;
        }
        if (!$_POST) {
            $this->vista = "entrada/nuevo";
            return null;
        } else {

            $entrada = Entrada::crearEntradaDesdePost($_POST, $_FILES);
            if ($entrada->esValida()) {
                $this->vista = "entrada/detalle";
                $entradaid = EntradaBd::insertar($entrada);
                $entrada->setId($entradaid);
                return EntradaBd::getEntrada($entrada->getId());
            } else {
                $this->vista = "entrada/nuevo";
                return $entrada;
            }
        }
    }

    public function eliminar(): bool|null
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return null;
        }
        $this->vista = "entrada/eliminar";
        $id = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;

        $sesion = new Sesion();
        $userid = $sesion->getId();

        if ($id !== null && (intval(EntradaBd::getAutorDeEntrada($id)) === $userid)) {
            return EntradaBd::eliminar($id);
        } else {
            return false;
        }
    }

    public function like(): string|array|bool|null
    {
        if (!$this->autenticado()) {
            header('Location: index.php');
            return null;
        }
        $this->vista = "entrada/lista";
        $postid = $_GET && isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
        $postid = intval($postid);

        $sesion = new Sesion();
        $userid = $sesion->getId();

        if ($postid !== null && $userid !== intval(EntradaBd::getAutorDeEntrada($postid))) {
            $usuariolike = LikeBd::checkUserLike($postid, $userid);
            if ($usuariolike === true) {
                $like = LikeBd::addLike($postid, $userid);
                return EntradaBd::getEntradas();
            } else if (is_integer($usuariolike)) {
                $like = LikeBd::removeLike($usuariolike, $postid, $userid);
            }

            if ($like === true) {
                return EntradaBd::getEntradas();
            } else {
                $this->vista = 'usuario/mensaje';
                return 'Error al interactuar con el like.';
            }
        } else {
            $this->vista = 'usuario/mensaje';
            return 'Error al interactuar con el like.';
        }
    }
}