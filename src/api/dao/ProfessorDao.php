<?php

namespace Api\DAO;

use Api\Models\Professor;
use Api\Database\MysqlDatabase;
use Exception;

class ProfessorDAO
{
    private MysqlDatabase $database;

    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ CursoDAO::__construct()");
    }

    public function verificarLogin(Professor $professor): ?Professor
    {
        error_log("🟢 ProfessorDAO::verificarLogin()");

        $sql = "
            SELECT *
            FROM professor
            WHERE email = :email
            LIMIT 1
        ";

        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $professor->getEmail()
        ]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        if (!password_verify($professor->getSenha(), $row['senha'])) {
            return null;
        }

        $professorAutenticado = new Professor();

        $professorAutenticado->setid_professor((int) $row['id_professor']);
        $professorAutenticado->setNomeProfessor($row['nomeProfessor']);
        $professorAutenticado->setEmail($row['email']);

        return $professorAutenticado;
    }

    public function create(Professor $objProfessor): Professor
    {
        error_log("🟢 CursoDAO::create()");

        $sql = "
            INSERT INTO professor (id_professor, nomeProfessor,email,senha)
            VALUES (:id_professor, :nomeProfessor, :email, :senha)
        ";

        $parametros = [
            ':id_professor' => $objProfessor->getid_professor(),
            ':nomeProfessor' => $objProfessor->getNomeProfessor(),
            ':email' => $objProfessor->getEmail(),
            ':senha' => password_hash($objProfessor->getSenha(), PASSWORD_BCRYPT, ['cost' => 12])
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar professor.");
        }

        return $objProfessor;
    }

    public function delete(Professor $objProfessorModel): bool
    {
        error_log("🟢 ProfessorDAO::delete()");

        $sql = "
            DELETE FROM professor
            WHERE id_professor = :id_professor
        ";

        $parametros = [
            ':id_professor' => $objProfessorModel->getid_professor()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    public function update(Professor $objProfessorModel): bool
    {
        error_log("🟢 ProfessorDAO::update()");

        $sql = "
            UPDATE professor
            SET nomeProfessor = :nomeProfessor,
            email = :email,
            senha = :senha
            WHERE id_professor = :id_professor
        ";

        $parametros = [
            ':nomeProfessor' => $objProfessorModel->getNomeProfessor(),
            ':email' => $objProfessorModel->getEmail(),
            ':senha' => $objProfessorModel->getSenha(),
            ':id_professor' => $objProfessorModel->getid_professor()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    public function findAll(): array
    {
        error_log("🟢 ProfessorDAO::findAll()");

        $sql = "SELECT * FROM professor";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $professores = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $professor = new Professor();

            $professor->setid_professor((int) $linhaMatriz['id_professor']);
            $professor->setNomeProfessor($linhaMatriz['nomeProfessor']);
            $professor->setEmail($linhaMatriz['email']);

            $professores[] = $professor;
        }

        return $professores;
    }

    public function count(): int
    {
        error_log("🟢 ProfessorDAO::count()");

        $sql = "SELECT COUNT(*) AS qtd FROM professor";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $id_professor): ?Professor
    {
        error_log("🟢 ProfessorDAO::findById()");

        $resultado = $this->findByField('id_professor', $id_professor);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 ProfessorDAO::findByField()");

        $camposPermitidos = [
            'id_professor',
            'nomeProfessor',
            'email'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM professor WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $professores = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $professor = new Professor();

            $professor->setid_professor((int) $linhaMatriz['id_professor']);
            $professor->setNomeProfessor($linhaMatriz['nomeProfessor']);
            $professor->setEmail($linhaMatriz['email']);

            $professores[] = $professor;
        }

        return $professores;
    }
}