<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\AlunoService;

class AlunoController
{
    private AlunoService $alunoService;

    public function __construct(AlunoService $alunoServiceDependency)
    {
        error_log("⬆️ AlunoController::__construct()");
        $this->alunoService = $alunoServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 AlunoController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoAluno = $this->alunoService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'alunos' => [
                    [
                        'id_aluno' => $novoAluno->getid_aluno(),
                        'nomeAluno' => $novoAluno->getNomeAluno(),
                        'id_curso' => $novoAluno->getid_curso()
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
        error_log("🔵 AlunoController::findAllController()");

        $aluno = $this->alunoService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'alunos' => $aluno
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 AlunoController::findByIdController()");

        $id_aluno = (int) $args['id_aluno'];
        $aluno = $this->alunoService->findByIdService($id_aluno);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'alunos' => $aluno
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 AlunoController::updateController()");

        $id_aluno = (int) $args['id_aluno'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nomeAluno = $objPHP->aluno->nomeAluno;
        $id_curso = (int) $objPHP->aluno->id_curso;

        $this->alunoService->updateService($id_aluno, $nomeAluno, $id_curso);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'alunos' => [
                    [
                        'id_aluno' => $id_aluno,
                        'nomeAluno' => $nomeAluno,
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

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 AlunoController::deleteController()");

        $id_aluno = (int) $args['id_aluno'];

        $this->alunoService->deleteService($id_aluno);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'alunos' => [
                    [
                        'id_aluno' => $id_aluno
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
        error_log("🔵 AlunoController::countController()");

        $total = $this->alunoService->countService();

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