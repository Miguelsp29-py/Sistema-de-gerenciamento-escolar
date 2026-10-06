<?php

namespace Api\Services;

use Api\Models\Aluno;
use Api\DAO\AlunoDAO;
use Api\Http\ErrorResponse;
use stdClass;

class AlunoService
{
    private AlunoDAO $alunoDAO;

    public function __construct(AlunoDAO $alunoDAODependency)
    {
        error_log("⬆️ AlunoService::__construct()");
        $this->alunoDAO = $alunoDAODependency;
    }

    public function createService(stdClass $objPHP): Aluno
    {
        error_log("🟣 AlunoService::createService()");

        $nomeAluno = $objPHP->aluno->nomeAluno;
        $id_curso = $objPHP->aluno->id_curso;

        if (strlen($nomeAluno) < 3) {
            throw new ErrorResponse(
                400,
                "Nome inválido",
                ["message" => "O nome do aluno deve conter pelo menos 3 caracteres."]
            );

        }

        $aluno = new Aluno();
        $aluno->setid_aluno((int) $objPHP->aluno->id_aluno);
        $aluno->setNomeAluno($objPHP->aluno->nomeAluno);
        $aluno->setid_curso($objPHP->aluno->id_curso);


        return $this->alunoDAO->create($aluno);
    }


    public function countService(): int
    {
        error_log("🟣 AlunoService::countService()");
        return $this->alunoDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 AlunoService::findAllService()");
        return $this->alunoDAO->findAll();
    }

    public function findByIdService(int $id_aluno): ?Aluno
    {
        error_log("🟣 AlunoService::findByIdService()");

        $aluno = new Aluno();
        $aluno->setid_aluno($id_aluno);

        $alunoEncontrado = $this->alunoDAO->findById($aluno->getid_aluno());

        if ($alunoEncontrado === null) {
        throw new \Api\Http\ErrorResponse(
            404, 
            "Aluno não encontrado", 
            ["message" => "Não existe aluno com o id {$id_aluno}"]
        );
    }
        return $alunoEncontrado;
    }

    public function updateService(int $id_aluno, string $nomeAluno, int $id_curso): bool
    {
        error_log("🟣 AlunoService::updateService()");

       
        $alunoExistente = $this->alunoDAO->findById($id_aluno);

        if (!$alunoExistente) {
            throw new ErrorResponse(
                404,
                "Aluno não encontrado",
                [
                    "message" =>
                        "Não existe aluno com id {$id_aluno}"
                ]
            );
        }

        $aluno = new Aluno();
        $aluno->setid_aluno($id_aluno);
        $aluno->setNomeAluno($nomeAluno);
        $aluno->setid_curso($id_curso);
      
        return $this->alunoDAO->update($aluno);


    }

    public function deleteService(int $id_aluno): bool
    {
        error_log("🟣 AlunoService::deleteService()");

        $alunoExistente = $this->alunoDAO->findById($id_aluno);

        if (!$alunoExistente) {
            throw new ErrorResponse(
                404,
                "Aluno não encontrado",
                [
                    "message" =>
                        "Não existe aluno com id {$id_aluno}"
                ]
            );
        }

        $alunoParaDeletar = new Aluno();
        $alunoParaDeletar->setid_aluno($id_aluno);
        return $this->alunoDAO->delete($alunoParaDeletar); 

    }
}