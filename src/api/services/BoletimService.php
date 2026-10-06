<?php

namespace Api\Services;

use Api\Models\Boletim;
use Api\DAO\BoletimDAO;
use Api\Http\ErrorResponse;
use stdClass;

class BoletimService
{
    private BoletimDAO $boletimDAO;

    public function __construct(BoletimDAO $boletimDAODependency)
    {
        error_log("⬆️ BoletimService::__construct()");
        $this->boletimDAO = $boletimDAODependency;
    }

    public function createService(stdClass $objPHP): Boletim
    {
        error_log("🟣 BoletimService::createService()");

        $boletim = new Boletim();
        $boletim->setid_boletim($objPHP->boletim->id_boletim);
        $boletim->setNota($objPHP->boletim->nota);
        $boletim->setFrequencia($objPHP->boletim->frequencia);
        $boletim->setSituacao($objPHP->boletim->situacao);
        $boletim->setid_aluno($objPHP->boletim->id_aluno);
        $boletim->setid_disciplina($objPHP->boletim->id_disciplina);


        if ( $boletim->getNota() < 0 || $boletim->getNota() > 10 )
        {
            throw new ErrorResponse(
                400,
                "Nota inválida",
                [
                    "message" =>
                        "A nota deve estar entre 0 e 10"
                ]
            );

        }
        if ($boletim->getFrequencia() < 0 || $boletim->getFrequencia() > 100) {
            throw new ErrorResponse(
                400,
                "Frequência inválida",
                ["message" => "A frequência deve estar entre 0 e 100%."]
            );
        }
        return $this->boletimDAO->create($boletim);
    }


    public function countService(): int
    {
        error_log("🟣 BoletimService::countService()");
        return $this->boletimDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 BoletimService::findAllService()");
        return $this->boletimDAO->findAll();
    }

    public function findByIdService(int $id_boletim): ?Boletim
    {
        error_log("🟣 BoletimService::findByIdService()");

        $boletim = new Boletim();
        $boletim->setid_boletim($id_boletim);

        $boletimEncontrado = $this->boletimDAO->findById($boletim->getid_boletim());

        if ($boletimEncontrado === null) {
        throw new \Api\Http\ErrorResponse(
            404, 
            "Boletim não encontrado",
            ["message" => "Não existe boletim com o id {$id_boletim}"]    
        );

     }
        return $boletimEncontrado;
    }
        


    public function updateService(int $id_boletim, float $nota, float $frequencia, string $situacao, int $id_aluno, int $id_disciplina): bool
    {
        error_log("🟣 BoletimService::updateService()");

        $boletimExistente = $this->boletimDAO->findById($id_boletim);

        if (!$boletimExistente) {
            throw new ErrorResponse(
                404,
                "Boletim não encontrado",
                [
                    "message" =>
                        "Não existe boletim com id {$id_boletim}"
                ]
            );
        }
        if ($boletim->getFrequencia() < 0 || $boletim->getFrequencia() > 100) {
            throw new ErrorResponse(
                400,
                "Frequência inválida",
                ["message" => "A frequência deve estar entre 0 e 100%."]
            );
        }
        $boletim = new Boletim();
        $boletim->setid_boletim($id_boletim);
        $boletim->setNota($nota);
        $boletim->setFrequencia($frequencia);
        $boletim->setSituacao($situacao);
        $boletim->setid_aluno($id_aluno);
        $boletim->setid_disciplina($id_disciplina);


        if ( $boletim->getNota() < 0 || $boletim->getNota() > 10) 
        {
            throw new ErrorResponse(
                400,
                "Nota inválida",
                [
                    "message" =>
                        "A nota deve estar entre 0 e 10"
                ]
            );
        }

        return $this->boletimDAO->update($boletim);


    }

    public function deleteService(int $id_boletim): bool
    {
        error_log("🟣 BoletimService::deleteService()");

        $boletimExistente = $this->boletimDAO->findById($id_boletim);

        if (!$boletimExistente) {
            throw new ErrorResponse(
                404,
                "Boletim não encontrado",
                [
                    "message" =>
                        "Não existe boletim com id {$id_boletim}"
                ]
            );
        }

        $boletim = new Boletim();
        $boletim->setid_boletim($id_boletim);
        return $this->boletimDAO->delete($boletim);


    }
}