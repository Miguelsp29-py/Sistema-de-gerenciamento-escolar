<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;

class Aluno implements JsonSerializable
{
    private int $id_aluno;

    private string $nomeAluno = "";

    private int $id_curso;

    public function __construct()
    {
    }

    public function getid_aluno(): ?int
    {
        return $this->id_aluno;
    }

   
    public function setid_aluno(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_aluno deve ser um número inteiro.");
        }

        if ($value < 0) {
            throw new InvalidArgumentException("id_aluno deve ser maior que zero.");
        }

        $this->id_aluno = $value;
    }

    
    public function getNomeAluno(): ?string
    {
        return $this->nomeAluno;
    }


    public function setNomeAluno(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeAluno não pode ser vazio.");
        }

        $this->nomeAluno = $nome;
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

        if ($value <= 0) {
            throw new InvalidArgumentException("id_curso deve ser maior que zero.");
        }

        $this->id_curso = $value;


    }

    public function jsonSerialize(): array
    {

        return [
            'id_aluno' => $this->getid_aluno(),
            'nomeAluno' => $this->getNomeAluno(),
            'id_curso' => $this->getid_curso()
         ];

    }

    
}
