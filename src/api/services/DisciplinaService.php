<?php

namespace Api\Services;

use Api\Models\Disciplina;
use Api\DAO\DisciplinaDAO;
use Api\Http\ErrorResponse;
use stdClass;

class DisciplinaService
{
    private DisciplinaDAO $disciplinaDAO;

    public function __construct(DisciplinaDAO $disciplinaDAODependency)
    {
        error_log("⬆️ DisciplinaService::__construct()");
        $this->disciplinaDAO = $disciplinaDAODependency;
    }

    public function createService(stdClass $objPHP): Disciplina
    {
        error_log("🟣 DisciplinaService::createService()");

        $disciplina = new Disciplina();
        $disciplina->setid_disciplina($objPHP->disciplina->id_disciplina);
        $disciplina->setNomeDisciplina($objPHP->disciplina->nomeDisciplina);
        $disciplina->setid_curso($objPHP->disciplina->id_curso);
        $disciplina->setid_professor($objPHP->disciplina->id_professor);
        $disciplina->setMediaDefinida($objPHP->disciplina->mediaDefinida);


        if ( $disciplina->getMediaDefinida() < 0 || $disciplina->getMediaDefinida() > 10 )
        {
            throw new ErrorResponse(
                400,
                "Média inválida",
                [
                    "message" =>
                        "A média deve estar entre 0 e 10"
                ]
            );
        }
        return $this->disciplinaDAO->create($disciplina);
    }


    public function countService(): int
    {
        error_log("🟣 DisciplinaService::countService()");
        return $this->disciplinaDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 DisciplinaService::findAllService()");
        return $this->disciplinaDAO->findAll();
    }

    public function findByIdService(int $id_disciplina): ?Disciplina
    {
        error_log("🟣 DisciplinaService::findByIdService()");

        $disciplina = new Disciplina();
        $disciplina->setid_disciplina($id_disciplina);

        $disciplinaEncontrada = $this->disciplinaDAO->findById($disciplina->getid_disciplina());

        if ($disciplinaEncontrada === null) {
        throw new \Api\Http\ErrorResponse(
            404, 
            "Disciplina não encontrada",
            ["message" => "Não existe disciplina com o id {$id_disciplina}"]    
        );

    }
        return $disciplinaEncontrada;

    }

    public function updateService(int $id_disciplina, string $nomeDisciplina, int $id_curso, int $id_professor, int $mediaDefinida): bool
    {
        error_log("🟣 DisciplinaService::updateService()");

        $disciplinaExistente = $this->disciplinaDAO->findById($id_disciplina);

        if (!$disciplinaExistente) {
            throw new ErrorResponse(
                404,
                "Disciplina não encontrada",
                [
                    "message" =>
                        "Não existe disciplina com id {$id_disciplina}"
                ]
            );
        }


        $disciplina = new Disciplina();
        $disciplina->setid_disciplina($id_disciplina);
        $disciplina->setNomeDisciplina($nomeDisciplina);
        $disciplina->setid_curso($id_curso);
        $disciplina->setid_professor($id_professor);
        $disciplina->setMediaDefinida($mediaDefinida);


        if ( $disciplina->getMediaDefinida() < 0 || $disciplina->getMediaDefinida() > 10) 
        {
            throw new ErrorResponse(
                400,
                "Média inválida",
                [
                    "message" =>
                        "A média deve estar entre 0 e 10"
                ]
            );
        }

        return $this->disciplinaDAO->update($disciplina);


    }

    public function deleteService(int $id_disciplina): bool
    {
        error_log("🟣 DisciplinaService::deleteService()");

        $disciplinaExistente = $this->disciplinaDAO->findById($id_disciplina);

        if (!$disciplinaExistente) {
            throw new ErrorResponse(
                404,
                "Disciplina não encontrada",
                [
                    "message" =>
                        "Não existe disciplina com id {$id_disciplina}"
                ]
            );
        }

        $disciplina = new Disciplina();
        $disciplina->setid_disciplina($id_disciplina);
        return $this->disciplinaDAO->delete($disciplina);


    }
}