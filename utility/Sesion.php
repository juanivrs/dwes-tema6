<?php

namespace dwesgram\utility;

class Sesion
{
    public string|null $nombre;
    public string|null $avatar;
    public int|null $id;

    public function __construct()
    {
        $this->id = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
        $this->nombre = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre']) ? $_SESSION['usuario']['nombre'] : null;
        $this->avatar = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['avatar']) ? $_SESSION['usuario']['avatar'] : null;
    }


    public function haySesion(): bool
    {
        return $this->id !== null && $this->nombre !== null;
    }

    public function getNombre(): string
    {
        return $this->haySesion() ? $this->nombre : "";
    }

    public function getAvatar(): string|null
    {
        return $this->haySesion() ? $this->avatar : "";
    }

    public function getId(): int|null
    {
        return $this->haySesion() ? $this->id : "";
    }
}