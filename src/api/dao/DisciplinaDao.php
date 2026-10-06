<?php

namespace Api\DAO;

use Api\Models\Disciplina;
use Api\Database\MysqlDatabase;
use Exception;


class DisciplinaDAO
{
    
    private MysqlDatabase $database;

 
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ DisciplinaDAO::__construct()");
    }

    
    public function create(Disciplina $objDisciplina): Disciplina
    {
        error_log("🟢 DisciplinaDAO::create()");

        $sql = "
            INSERT INTO disciplina (
            id_disciplina,
            nomeDisciplina, 
            id_curso,
            id_professor,
            mediaDefinida
            )

            VALUES (
            :id_disciplina,
            :nomeDisciplina,
            :id_curso,
            :id_professor,
            :mediaDefinida
            )
        ";


        $parametros = [
            ':id_disciplina' => $objDisciplina->getid_disciplina(),
            ':nomeDisciplina' => $objDisciplina->getNomeDisciplina(),
            ':id_curso' => $objDisciplina->getid_curso(),
            ':id_professor' => $objDisciplina->getid_professor(),
            ':mediaDefinida' => $objDisciplina->getMediaDefinida()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar disciplina.");
        }

        return $objDisciplina;
    }

   
    public function delete(Disciplina $objDisciplinaModel): bool
    {
        error_log("🟢 DisciplinaDAO::delete()");

        $sql = "
            DELETE FROM disciplina
            WHERE id_disciplina = :id_disciplina
        ";

        $parametros = [
            ':id_disciplina' => $objDisciplinaModel->getid_disciplina()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

 
    public function update(Disciplina $objDisciplinaModel): bool
    {
        error_log("🟢 DisciplinaDAO::update()");

      
        $sql = "
            UPDATE disciplina
            SET nomeDisciplina = :nomeDisciplina,
            id_curso = :id_curso,
            id_professor = :id_professor, 
            mediaDefinida = :mediaDefinida
            WHERE id_disciplina = :id_disciplina
        ";

        
        $parametros = [
            ':id_disciplina' => $objDisciplinaModel->getid_disciplina(),
            ':nomeDisciplina' => $objDisciplinaModel->getNomeDisciplina(),
            ':id_curso' => $objDisciplinaModel->getid_curso(),
            ':id_professor' => $objDisciplinaModel->getid_professor(),
            ':mediaDefinida' => $objDisciplinaModel->getMediaDefinida(),
            ':id_disciplina' => $objDisciplinaModel->getid_disciplina()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

    
    public function findAll(): array
    {
        error_log("🟢 DisciplinaDAO::findAll()");

        $sql = "SELECT * FROM disciplina";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $disciplinas = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $disciplina = new Disciplina();

            $disciplina->setid_disciplina((int) $linhaMatriz['id_disciplina']);
            $disciplina->setNomeDisciplina($linhaMatriz['nomeDisciplina']);
            $disciplina->setid_Curso($linhaMatriz['id_curso']);
            $disciplina->setid_Professor($linhaMatriz['id_professor']);
            $disciplina->setMediaDefinida($linhaMatriz['mediaDefinida']);

            $disciplinas[] = $disciplina;
        }


        return $disciplinas;
    }


    public function count(): int
    {
        error_log("🟢 DisciplinaDAO::count()");


        $sql = "SELECT COUNT(*) AS qtd FROM disciplina";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    
    public function findById(int $id_disciplina): ?Disciplina
    {
        error_log("🟢 DisciplinaDAO::findById()");

        
        $resultado = $this->findByField('id_disciplina', $id_disciplina);

   
        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

 
    public function findByField(string $field, $value): array
    {
        error_log("🟢 DisciplinaDAO::findByField()");


        $camposPermitidos = [
             'id_disciplina',
             'nomeDisciplina',
             'id_curso',
             'id_professor',
             'mediaDefinida',
             'id_disciplina'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM disciplina WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $disciplinas = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $disciplina = new Disciplina();

            $disciplina->setid_disciplina((int) $linhaMatriz['id_disciplina']);
            $disciplina->setNomeDisciplina($linhaMatriz['nomeDisciplina']);
            $disciplina->setid_Curso($linhaMatriz['id_curso']);
            $disciplina->setid_Professor($linhaMatriz['id_professor']);
            $disciplina->setMediaDefinida($linhaMatriz['mediaDefinida']);

            $disciplinas[] = $disciplina;
        }

        return $disciplinas;
    }
}