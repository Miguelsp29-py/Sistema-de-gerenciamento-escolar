<?php

namespace Api\DAO;

use Api\Models\Curso;
use Api\Database\MysqlDatabase;
use Exception;

class CursoDAO
{
    private MysqlDatabase $database;

    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ CursoDAO::__construct()");
    }

    public function create(Curso $objCurso): Curso
    {
        error_log("🟢 CursoDAO::create()");

        $sql = "
            INSERT INTO curso (id_curso,nomeCurso)
            VALUES (:id_curso, :nomeCurso)
        ";

        $parametros = [
            ':id_curso' => $objCurso->getid_curso(),
            ':nomeCurso' => $objCurso->getNomeCurso()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar curso.");
        }

        return $objCurso;
    }

    public function delete(Curso $objCursoModel): bool
    {
        error_log("🟢 CursoDAO::delete()");

        $sql = "
            DELETE FROM curso
            WHERE id_curso = :id_curso
        ";

        $parametros = [
            ':id_curso' => $objCursoModel->getid_curso()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    public function update(Curso $objCursoModel): bool
    {
        error_log("🟢 CursoDAO::update()");

        $sql = "
            UPDATE curso
            SET nomeCurso = :nomeCurso
            WHERE id_curso = :id_curso
        ";

        $parametros = [
            ':nomeCurso' => $objCursoModel->getNomeCurso(),
            ':id_curso' => $objCursoModel->getid_curso()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    public function findAll(): array
    {
        error_log("🟢 CursoDAO::findAll()");

        $sql = "SELECT * FROM curso";

        $stmt = $this->database->getConnection()->query($sql);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $curso = new Curso();

            $curso->setid_curso((int) $linhaMatriz['id_curso']);
            $curso->setNomeCurso($linhaMatriz['nomeCurso']);

            $cursos[] = $curso;
        }

        return $cursos;
    }

    public function count(): int
    {
        error_log("🟢 CursoDAO::count()");

        $sql = "SELECT COUNT(*) AS qtd FROM curso";

        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $id_curso): ?Curso
    {
        error_log("🟢 CursoDAO::findById()");

        $resultado = $this->findByField('id_curso', $id_curso);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 CursoDAO::findByField()");

        $camposPermitidos = [
            'id_curso',
            'nomeCurso'
        ];

        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM curso WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);

        $stmt->execute([
            ':value' => $value
        ]);

        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $cursos = [];

        foreach ($matrizArrays as $linhaMatriz) {
            $curso = new Curso();

            $curso->setid_curso((int) $linhaMatriz['id_curso']);
            $curso->setNomeCurso($linhaMatriz['nomeCurso']);

            $cursos[] = $curso;
        }

        return $cursos;
    }
}