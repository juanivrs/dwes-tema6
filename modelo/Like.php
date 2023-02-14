<?php

namespace dwesgram\modelo;


class Like
{
    private int|null $id = null;
    private int|null $usuarioid;
    private int|null $entradaid;

    public function __construct(
        int|null $id = null,
        int|null $usuarioid,
        int|null $entradaid,
    ) {
        $this->id = $id;
        $this->usuarioid = $usuarioid;
        $this->entradaid = $entradaid;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsuarioId(): int|null
    {
        return $this->usuarioid;
    }

    public function setUsuarioId(int $id): void
    {
        $this->usuarioid = $id;
    }

    public function getEntradaId(): int|null
    {
        return $this->entradaid;
    }

    public function setEntradaId(int $id): void
    {
        $this->entradaid = $id;
    }
}
