<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\CursoService;

class CursoController
{
    private CursoService $cursoService;

    public function __construct(CursoService $cursoServiceDependency)
    {
        error_log("⬆️ CursoController::__construct()");
        $this->cursoService = $cursoServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 CursoController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoCurso = $this->cursoService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'cursos' => [
                    [
                        'id_curso' => $novoCurso->getid_curso(),
                        'nomeCurso' => $novoCurso->getnomeCurso()
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
        error_log("🔵 CursoController::findAllController()");

        $cursos = $this->cursoService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'cursos' => $cursos
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 CursoController::findByIdController()");

        $id_curso = (int) $args['id_curso'];
        $curso = $this->cursoService->findByIdService($id_curso);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'cursos' => $curso
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 CursoController::updateController()");

        $id_curso = (int) $args['id_curso'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nomeCurso = $objPHP->curso->nomeCurso;

        $this->cursoService->updateService($id_curso, $nomeCurso);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'cursos' => [
                    [
                        'id_curso' => $id_curso,
                        'nomeCurso' => $nomeCurso
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
        error_log("🔵 CursoController::deleteController()");

        $id_curso = (int) $args['id_curso'];

        $this->cursoService->deleteService($id_curso);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'cursos' => [
                    [
                        'id_curso' => $id_curso
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
        error_log("🔵 CursoController::countController()");

        $total = $this->cursoService->countService();

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