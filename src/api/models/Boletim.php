<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class Boletim implements JsonSerializable
{
   
    private int $id_boletim = 0; 
    
    private float $nota = 0.0;

    private float $frequencia = 0.0;

    private string $situacao = "";

    private int $id_aluno = 0;

    private int $id_disciplina = 0;




    public function __construct()
    {
    }

    public function getid_boletim(): ?int
    {
        return $this->id_boletim;
    }

   
    public function setid_boletim(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("id_boletim deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("id_boletim deve ser maior que zero.");
        }

        $this->id_boletim = $value;
    }


    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $value): void
    {
        if (!is_float($value)) {
            throw new InvalidArgumentException("nota deve ser um número.");
        }

        if ($value < 0 || $value > 10) {
            throw new InvalidArgumentException("nota deve estar entre 0 e 10.");
        }

        $this->nota = $value;
    }


    public function getFrequencia(): ?float
    {
        return $this->frequencia;
    }


    public function setFrequencia(float $value): void
    {
        if (!is_float($value)) {
            throw new InvalidArgumentException("frequencia deve ser um número.");
        }

        if ($value < 0 || $value > 100) {
            throw new InvalidArgumentException("frequencia deve estar entre 0 e 100.");
        }

        $this->frequencia = $value;
    }

    public function getSituacao(): ?string
    {
        return $this->situacao;
    }

    public function setSituacao(string $value): void
    {
        $situacao = trim($value);

        if ($situacao === '') {
            throw new InvalidArgumentException("situacao não pode ser vazio.");
        }

        $len = mb_strlen($situacao);

        if ($len < 3) {
            throw new InvalidArgumentException("situacao deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("situacao deve ter no máximo 64 caracteres.");
        }

        $this->situacao = $situacao;
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

        if ($value <= 0) {
            throw new InvalidArgumentException("id_aluno deve ser maior que zero.");
        }

        $this->id_aluno = $value;
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


    public function jsonSerialize(): array
    {
        return [
            'id_boletim' => $this->getid_boletim(),
            'nota' => $this->getNota(),
            'frequencia' => $this->getFrequencia(),
            'situacao' => $this->getSituacao(),
            'id_disciplina' => $this->getid_disciplina(),
            'id_aluno' => $this->getid_aluno()

        ];
    }
}
