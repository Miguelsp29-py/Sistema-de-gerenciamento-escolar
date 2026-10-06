<?php

namespace Api\Services;

use Api\Models\Curso;
use Api\DAO\CursoDAO;
use Api\Http\ErrorResponse;
use stdClass;

class CursoService
{
    private CursoDAO $cursoDAO;

    public function __construct(CursoDAO $cursoDAODependency)
    {
        error_log("⬆️ CursoService::__construct()");
        $this->cursoDAO = $cursoDAODependency;
    }

    public function createService(stdClass $objPHP): Curso
    {
        error_log("🟣 CursoService::createService()");

        $curso = new Curso();
        $curso->setid_curso((int) $objPHP->curso->id_curso);
        $curso->setNomeCurso($objPHP->curso->nomeCurso);

        $resultado = $this->cursoDAO->findByField(
            'nomeCurso',
            $curso->getNomeCurso()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Curso já existe",
                [
                    "message" =>
                        "O curso {$curso->getNomeCurso()} já existe"
                ]
            );
        }

        return $this->cursoDAO->create($curso);
    }

    public function countService(): int
    {
        error_log("🟣 CursoService::countService()");
        return $this->cursoDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 CursoService::findAllService()");
        return $this->cursoDAO->findAll();
    }

    public function findByIdService(int $id_curso): ?Curso
    {
        error_log("🟣 CursoService::findByIdService()");

        $curso = new Curso();
        $curso->setid_curso($id_curso);

        $cursoEncontrado = $this->cursoDAO->findById($curso->getid_curso());

        if ($cursoEncontrado === null) {
        throw new \Api\Http\ErrorResponse(
            404, 
            "Curso não encontrado", 
            ["message" => "Não existe curso com o id {$id_curso}"]
        );
    }
        return $cursoEncontrado;
    }

    public function updateService(int $id_curso, string $nomeCurso): bool
    {
        error_log("🟣 CursoService::updateService()");

        $cursoExistente = $this->cursoDAO->findById($id_curso);

        if (!$cursoExistente) {
            throw new ErrorResponse(
                404,
                "Curso não encontrado",
                [
                    "message" =>
                        "Não existe curso com id {$id_curso}"
                ]
            );
        }

        $curso = new Curso();
        $curso->setid_curso($id_curso);
        $curso->setNomeCurso($nomeCurso);

        return $this->cursoDAO->update($curso);
    }

    public function deleteService(int $id_curso): bool
    {
        error_log("🟣 CursoService::deleteService()");

        $cursoExistente = $this->cursoDAO->findById($id_curso);

        if (!$cursoExistente) {
            throw new ErrorResponse(
                404,
                "Curso não encontrado",
                [
                    "message" =>
                        "Não existe curso com id {$id_curso}"
                ]
            );
        }

        $curso = new Curso();
        $curso->setid_curso($id_curso);

        return $this->cursoDAO->delete($curso);
    }
}