<?php

namespace Api\DAO;

use Api\Models\Aluno;
use Api\Database\MysqlDatabase;
use Exception;

class AlunoDAO
{
    
    private MysqlDatabase $database;

 
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ AlunoDAO::__construct()");
    }

    
    public function create(Aluno $objAluno): Aluno
    {
        error_log("🟢 AlunoDAO::create()");

        $sql = "
            INSERT INTO aluno (id_aluno, nomeAluno, id_curso)
            VALUES (:id_aluno, :nomeAluno, :id_curso)
        ";

        $parametros = [
            ':id_aluno' => $objAluno->getid_aluno(),
            ':nomeAluno' => $objAluno->getNomeAluno(),
            ':id_curso' => $objAluno->getid_curso()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar aluno.");
        }

        return $objAluno;
    }

   
    public function delete(Aluno $objAlunoModel): bool
    {
        error_log("🟢 AlunoDAO::delete()");

        $sql = "
            DELETE FROM aluno
            WHERE id_aluno = :id_aluno
        ";

        $parametros = [
            ':id_aluno' => $objAlunoModel->getid_aluno()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

 
    public function update(Aluno $objAlunoModel): bool
    {
        error_log("🟢 AlunoDAO::update()");

      
        $sql = "
            UPDATE aluno
            SET nomeAluno = :nomeAluno, id_curso = :id_curso
            WHERE id_aluno = :id_aluno
        ";

        
        $parametros = [
            ':id_aluno' => $objAlunoModel->getid_aluno(),
            ':nomeAluno' => $objAlunoModel->getNomeAluno(),
            ':id_curso' => $objAlunoModel->getid_curso()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

    
    public function findAll(): array
    {
        error_log("🟢 AlunoDAO::findAll()");

        $sql = "SELECT * FROM aluno";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $alunos = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $aluno = new Aluno();

            $aluno->setid_aluno((int) $linhaMatriz['id_aluno']);
            $aluno->setNomeAluno($linhaMatriz['nomeAluno']);
            $aluno->setid_curso((int) $linhaMatriz['id_curso']);

            $alunos[] = $aluno;
        }


        return $alunos;
    }


    public function count(): int
    {
        error_log("🟢 AlunoDAO::count()");


        $sql = "SELECT COUNT(*) AS qtd FROM aluno";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    
    public function findById(int $id_aluno): ?Aluno
    {
        error_log("🟢 AlunoDAO::findById()");

        
        $resultado = $this->findByField('id_aluno', $id_aluno);

   
        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

 
    public function findByField(string $field, $value): array
    {
        error_log("🟢 AlunoDAO::findByField()");


        $camposPermitidos = [
             'id_aluno',
             'nomeAluno',
             'id_curso'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM aluno WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $alunos = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $aluno = new Aluno();

            $aluno->setid_aluno((int) $linhaMatriz['id_aluno']);
            $aluno->setNomeAluno($linhaMatriz['nomeAluno']);
            $aluno->setid_curso((int) $linhaMatriz['id_curso']);

            $alunos[] = $aluno;
        }

        return $alunos;
    }
}