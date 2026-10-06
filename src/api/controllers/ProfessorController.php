<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\ProfessorService;

class ProfessorController
{
    private ProfessorService $professorService;

    public function __construct(ProfessorService $professorServiceDependency)
    {
        error_log("⬆️ ProfessorController::__construct()");
        $this->professorService = $professorServiceDependency;
    }

    public function loginController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProfessorController::loginController()");

        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body, true);

        $resultado = $this->professorService->loginService($objPHP['professor']);

        $professor = $resultado['professor'];

        $token = $resultado['token'];

        $resposta = [
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'data' => [
                'professor' => [
                    'id_professor' => $professor->getid_professor(),
                    'nomeProfessor' => $professor->getNomeProfessor(),
                    'email' => $professor->getEmail()
                ],
                'token' => $token
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProfessorController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoProfessor = $this->professorService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'professores' => [
                    [
                        'id_professor' => $novoProfessor->getid_professor(),
                        'nomeProfessor' => $novoProfessor->getnomeProfessor(),
                        'email' => $novoProfessor->getEmail()
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
        error_log("🔵 ProfessorController::findAllController()");

        $professores = $this->professorService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'professores' => $professores
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProfessorController::findByIdController()");

        $id_professor = (int) $args['id_professor'];
        $professor = $this->professorService->findByIdService($id_professor);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'professores' => $professor
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProfessorController::updateController()");

        $id_professor = (int) $args['id_professor'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nomeProfessor = $objPHP->professor->nomeProfessor;
        $email = $objPHP->professor->email;
        $senha = $objPHP->professor->senha;

        $this->professorService->updateService($id_professor, $nomeProfessor, $email, $senha);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'professores' => [
                    [
                        'id_professor' => $id_professor,
                        'nomeProfessor' => $nomeProfessor,
                        'email' => $email
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
        error_log("🔵 ProfessorController::deleteController()");

        $id_professor = (int) $args['id_professor'];

        $this->professorService->deleteService($id_professor);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'professores' => [
                    [
                        'id_professor' => $id_professor
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
        error_log("🔵 ProfessorController::countController()");

        $total = $this->professorService->countService();

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