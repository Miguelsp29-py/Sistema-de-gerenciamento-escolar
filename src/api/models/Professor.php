<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;

class Professor implements JsonSerializable
{
    private int $id_professor;

    private string $nomeProfessor = "";
    private string $email = "";
    private string $senha = "";

    public function __construct()
    {
    }

    public function getid_professor(): ?int
    {
        return $this->id_professor;
    }

    public function setid_professor(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_professor deve ser um número inteiro.");
        }

        if ($value < 0) {
            throw new InvalidArgumentException("id_professor deve ser maior que zero.");
        }

        $this->id_professor = $value;
    }

    public function getNomeProfessor(): ?string
    {
        return $this->nomeProfessor;
    }

    public function setNomeProfessor(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeProfessor não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeProfessor deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeProfessor deve ter no máximo 64 caracteres.");
        }

        $this->nomeProfessor = $nome;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $value): void
    {
        $email = trim($value);

        if ($email === '') {
            throw new InvalidArgumentException("email não pode ser vazio.");
        }

        $this->email = $email;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $value): void
    {
        if ($value === '') {
            throw new InvalidArgumentException("senha não pode ser vazia.");
        }

        $this->senha = $value;
    }


    public function jsonSerialize(): array
    {
        return [
            'id_professor' => $this->getid_professor(),
            'nomeProfessor' => $this->getNomeProfessor(),
            'email' => $this->getEmail()
        ];
    }
}
