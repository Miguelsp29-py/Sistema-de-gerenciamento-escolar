<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\DisciplinaService;

class DisciplinaController
{
    private DisciplinaService $disciplinaService;

    public function __construct(DisciplinaService $disciplinaServiceDependency)
    {
        error_log("⬆️ DisciplinaController::__construct()");
        $this->disciplinaService = $disciplinaServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novaDisciplina = $this->disciplinaService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'disciplinas' => [
                    [
                        'id_disciplina' => $novaDisciplina->getid_disciplina(),
                        'nomeDisciplina' => $novaDisciplina->getNomeDisciplina(),
                        'id_curso' => $novaDisciplina->getid_curso(),
                        'id_professor' => $novaDisciplina->getid_professor(),
                        'mediaDefinida' => $novaDisciplina->getMediaDefinida()
                    ]
                ]
            ]
        ];
    

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function findAllController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::findAllController()");

        $disciplinas = $this->disciplinaService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'disciplinas' => $disciplinas
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::findByIdController()");

        $id_disciplina = (int) $args['id_disciplina'];
        $disciplina = $this->disciplinaService->findByIdService($id_disciplina);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'disciplinas' => $disciplina
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::updateController()");

        $id_disciplina = (int) $args['id_disciplina'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nomeDisciplina = $objPHP->disciplina->nomeDisciplina;
        $id_curso = (int) $objPHP->disciplina->id_curso;
        $id_professor = (int) $objPHP->disciplina->id_professor;
        $mediaDefinida = (float) $objPHP->disciplina->mediaDefinida;

        $this->disciplinaService->updateService($id_disciplina, $nomeDisciplina, $id_curso, $id_professor, $mediaDefinida);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'disciplinas' => [
                    [
                        'id_disciplina' => $id_disciplina,
                        'nomeDisciplina' => $nomeDisciplina,
                        'id_curso' => $id_curso,
                        'id_professor' => $id_professor,
                        'mediaDefinida' => $mediaDefinida
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::deleteController()");

        $id_disciplina = (int) $args['id_disciplina'];

        $this->disciplinaService->deleteService($id_disciplina);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'disciplinas' => [
                    [
                        'id_disciplina' => $id_disciplina
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 DisciplinaController::countController()");

        $total = $this->disciplinaService->countService();

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'count' => $total
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}