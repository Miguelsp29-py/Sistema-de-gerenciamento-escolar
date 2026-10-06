<?php

namespace Api\Services;

use Api\Models\Professor;
use Api\DAO\ProfessorDAO;
use Api\Http\ErrorResponse;
use Api\Http\MeuTokenJWT;
use stdClass;

class ProfessorService
{
    private ProfessorDAO $professorDAO;

    public function __construct(ProfessorDAO $professorDAODependency)
    {
        error_log("⬆️ ProfessorService::__construct()");
        $this->professorDAO = $professorDAODependency;
    }

    public function loginService(array $jsonProfessor): array
    {
        error_log("🟣 ProfessorService::loginService()");

        $professor = new Professor();
        $professor->setEmail($jsonProfessor['email']);
        $professor->setSenha($jsonProfessor['senha']);

        $professor = $this->professorDAO->verificarLogin($professor);

        if (!$professor) {
            throw new ErrorResponse(
                401,
                "Usuário ou senha inválidos",
                ["message" => "Não foi possível autenticar o professor"]
            );
        }

        $jwt = new MeuTokenJWT();

        $claims = new \stdClass();
        $claims->idProfessor = $professor->getid_professor();
        $claims->name = $professor->getNomeProfessor();
        $claims->email = $professor->getEmail();

        $token = $jwt->gerarToken($claims);

        return [
            'professor' => $professor,
            'token' => $token
        ];
    }

    public function createService(stdClass $objPHP): Professor
    {
        error_log("🟣 ProfessorService::createService()");

        $professor = new Professor();
        $professor->setid_professor((int) $objPHP->professor->id_professor); 
        $professor->setNomeProfessor($objPHP->professor->nomeProfessor);
        $professor->setEmail($objPHP->professor->email);
        $professor->setSenha($objPHP->professor->senha);

        $resultado = $this->professorDAO->findByField(
            'nomeProfessor',
            $professor->getNomeProfessor()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Professor já existe",
                [
                    "message" =>
                        "O professor {$professor->getNomeProfessor()} já existe"
                ]
            );
        }

        return $this->professorDAO->create($professor);
    }

    public function countService(): int
    {
        error_log("🟣 ProfessorService::countService()");
        return $this->professorDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 ProfessorService::findAllService()");
        return $this->professorDAO->findAll();
    }

    public function findByIdService(int $id_professor): ?Professor
    {
        error_log("🟣 ProfessorService::findByIdService()");

        $professor = new Professor();
        $professor->setid_professor($id_professor);

        $professorEncontrado = $this->professorDAO->findById($professor->getid_professor());

        if ($professorEncontrado === null) {
        throw new \Api\Http\ErrorResponse(
            404, 
            "Professor não encontrado", 
            ["message" => "Não existe professor com o id {$id_professor}"]
        );
    }
        return $professorEncontrado;
    }

    public function updateService(int $id_professor, string $nomeProfessor, string $email, string $senha): bool
    {
        error_log("🟣 ProfessorService::updateService()");

        $professorExistente = $this->professorDAO->findById($id_professor);

        if (!$professorExistente) {
            throw new ErrorResponse(
                404,
                "Professor não encontrado",
                [
                    "message" =>
                        "Não existe professor com id {$id_professor}"
                ]
            );
        }

        $professor = new Professor();
        $professor->setid_professor($id_professor);
        $professor->setNomeProfessor($nomeProfessor);
        $professor->setEmail($email);
        $professor->setSenha(password_hash($senha, PASSWORD_DEFAULT));


        return $this->professorDAO->update($professor);
    }

    public function deleteService(int $id_professor): bool
    {
        error_log("🟣 ProfessorService::deleteService()");

        $professorExistente = $this->professorDAO->findById($id_professor);

        if (!$professorExistente) {
            throw new ErrorResponse(
                404,
                "Professor não encontrado",
                [
                    "message" =>
                        "Não existe professor com id {$id_professor}"
                ]
            );
        }

        $professor = new Professor();
        $professor->setid_professor($id_professor);

        return $this->professorDAO->delete($professor);
    }
}