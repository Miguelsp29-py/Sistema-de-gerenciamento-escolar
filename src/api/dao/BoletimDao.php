<?php

namespace Api\DAO;

use Api\Models\Boletim;
use Api\Database\MysqlDatabase;
use Exception;


class BoletimDAO
{
    
    private MysqlDatabase $database;

 
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ BoletimDAO::__construct()");
    }

    
    public function create(Boletim $objBoletim): Boletim
    {
        error_log("🟢 BoletimDAO::create()");

        $sql = "
            INSERT INTO boletim (
            id_boletim,
            nota,
            frequencia,
            situacao,
            id_aluno,
            id_disciplina
            )

            VALUES (
            :id_boletim,
            :nota,
            :frequencia,
            :situacao,
            :id_aluno,
            :id_disciplina
            )
        ";

        // getid_curso()

        $parametros = [
            ':id_boletim' => $objBoletim->getid_boletim(),
            ':nota' => $objBoletim->getNota(),
            ':frequencia' => $objBoletim->getFrequencia(),
            ':situacao' => $objBoletim->getSituacao(),
            ':id_aluno' => $objBoletim->getid_aluno(),
            ':id_disciplina' => $objBoletim->getid_disciplina()
        ];
                
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar boletim.");
        }

        return $objBoletim;
    }

   
    public function delete(Boletim $objBoletimModel): bool
    {
        error_log("🟢 BoletimDAO::delete()");

        $sql = "
            DELETE FROM boletim
            WHERE id_boletim = :id_boletim
        ";

        $parametros = [
            ':id_boletim' => $objBoletimModel->getid_boletim()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

 
    public function update(Boletim $objBoletimModel): bool
    {
        error_log("🟢 BoletimDAO::update()");

      
        $sql = "
            UPDATE boletim
            SET nota = :nota,
            frequencia = :frequencia,
            situacao = :situacao,
            id_aluno = :id_aluno,
            id_disciplina = :id_disciplina
            WHERE id_boletim = :id_boletim
        ";

        
        $parametros = [
            ':id_boletim' => $objBoletimModel->getid_boletim(),
            ':nota' => $objBoletimModel->getNota(),
            ':frequencia' => $objBoletimModel->getFrequencia(),
            ':situacao' => $objBoletimModel->getSituacao(),
            ':id_aluno' => $objBoletimModel->getid_aluno(),
            ':id_disciplina' => $objBoletimModel->getid_disciplina()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

    
    public function findAll(): array
    {
        error_log("🟢 BoletimDAO::findAll()");

        $sql = "SELECT * FROM boletim";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $boletins = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $boletim = new Boletim();

            $boletim->setid_boletim((int) $linhaMatriz['id_boletim']);
            $boletim->setNota($linhaMatriz['nota']);
            $boletim->setFrequencia($linhaMatriz['frequencia']);
            $boletim->setSituacao($linhaMatriz['situacao']);
            $boletim->setid_aluno($linhaMatriz['id_aluno']);
            $boletim->setid_disciplina($linhaMatriz['id_disciplina']);

            $boletins[] = $boletim;
        }


        return $boletins;
    }


    public function count(): int
    {
        error_log("🟢 BoletimDAO::count()");


        $sql = "SELECT COUNT(*) AS qtd FROM boletim";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    
    public function findById(int $id_boletim): ?Boletim
    {
        error_log("🟢 BoletimDAO::findById()");

        
        $resultado = $this->findByField('id_boletim', $id_boletim);

   
        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

 
    public function findByField(string $field, $value): array
    {
        error_log("🟢 BoletimDAO::findByField()");


        $camposPermitidos = [
             'id_boletim',
             'nota',
             'frequencia',
             'situacao',
             'id_aluno',
             'id_disciplina'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM boletim WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $boletins = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $boletim = new Boletim();

            $boletim->setid_boletim((int) $linhaMatriz['id_boletim']);
            $boletim->setNota($linhaMatriz['nota']);
            $boletim->setFrequencia($linhaMatriz['frequencia']);
            $boletim->setSituacao($linhaMatriz['situacao']);
            $boletim->setid_aluno($linhaMatriz['id_aluno']);
            $boletim->setid_disciplina($linhaMatriz['id_disciplina']);

            $boletins[] = $boletim;
        }

        return $boletins;
    }

}