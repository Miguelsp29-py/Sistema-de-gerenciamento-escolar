<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;

class Curso implements JsonSerializable
{
    private int $id_curso;

    private string $nomeCurso = "";

    public function __construct()
    {
    }

    public function getid_curso(): ?int
    {
        return $this->id_curso;
    }

    public function setid_curso(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_curso deve ser um número inteiro.");
        }

        if ($value < 0) {
            throw new InvalidArgumentException("id_curso deve ser maior que zero.");
        }

        $this->id_curso = $value;
    }

    public function getNomeCurso(): ?string
    {
        return $this->nomeCurso;
    }

    public function setNomeCurso(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeCurso não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeCurso deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeCurso deve ter no máximo 64 caracteres.");
        }

        $this->nomeCurso = $nome;
    }

    public function jsonSerialize(): array
    {
        return [
            'id_curso' => $this->getid_curso(),
            'nomeCurso' => $this->getNomeCurso()
        ];
    }
}
