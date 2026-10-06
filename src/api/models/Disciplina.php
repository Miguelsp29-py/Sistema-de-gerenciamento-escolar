<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;

class Disciplina implements JsonSerializable
{
   
    private int $id_disciplina = 0; 
    
    private string $nomeDisciplina = "";

    private int $id_curso = 0;

    private int $id_professor = 0;

    public int $mediaDefinida = 0;




    public function __construct()
    {
    }

    public function getid_disciplina(): ?int
    {
        return $this->id_disciplina;
    }

   
    public function setid_disciplina(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_disciplina deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("id_disciplina deve ser maior que zero.");
        }

        $this->id_disciplina = $value;
    }


    public function getNomeDisciplina(): ?string
    {
        return $this->nomeDisciplina;
    }


    public function setNomeDisciplina(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeDisciplina não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeDisciplina deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeDisciplina deve ter no máximo 64 caracteres.");
        }

        $this->nomeDisciplina = $nome;
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

    public function getid_professor(): ?int
    {
        return $this->id_professor; 
    }

    public function setid_professor(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_professor deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("id_professor deve ser maior que zero.");
        }

        $this->id_professor = $value;
    }

    public function getMediaDefinida(): int
    {
        return $this->mediaDefinida;
    }

    public function setMediaDefinida(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("mediaDefinida deve ser um número inteiro.");
        }

        if ($value < 0) {
            throw new InvalidArgumentException("mediaDefinida deve ser maior ou igual a zero.");
        }

        $this->mediaDefinida = $value;
    }   


    public function jsonSerialize(): array
    {
        return [
            'id_disciplina' => $this->getid_disciplina(),
            'nomeDisciplina' => $this->getNomeDisciplina(),
            'id_curso' => $this->getid_curso(),
            'id_professor' => $this->getid_professor(),
            'mediaDefinida' => $this->getMediaDefinida()
        ];
    }
}
