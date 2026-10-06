<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\BoletimService;

class BoletimController
{
    private BoletimService $boletimService;

    public function __construct(BoletimService $boletimServiceDependency)
    {
        error_log("⬆️ BoletimController::__construct()");
        $this->boletimService = $boletimServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 BoletimController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoBoletim = $this->boletimService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'boletins' => [
                    [
                        'id_boletim' => $novoBoletim->getid_boletim(),
                        'nota' => $novoBoletim->getNota(),
                        'frequencia' => $novoBoletim->getFrequencia(),
                        'situacao' => $novoBoletim->getSituacao(),
                        'id_aluno' => $novoBoletim->getid_aluno(),
                        'id_disciplina' => $novoBoletim->getid_disciplina()
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
        error_log("🔵 BoletimController::findAllController()");

        $boletins = $this->boletimService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'boletins' => $boletins
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 BoletimController::findByIdController()");

        $id_boletim = (int) $args['id_boletim'];
        $boletim = $this->boletimService->findByIdService($id_boletim);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'boletins' => $boletim
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 BoletimController::updateController()");

        $id_boletim = (int) $args['id_boletim'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nota = (float) $objPHP->boletim->nota;
        $frequencia = (float) $objPHP->boletim->frequencia;
        $situacao = (string) $objPHP->boletim->situacao;
        $id_aluno = (int) $objPHP->boletim->id_aluno;
        $id_disciplina = (int) $objPHP->boletim->id_disciplina;

        $this->boletimService->updateService($id_boletim, $nota, $frequencia, $situacao, $id_aluno, $id_disciplina);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'boletins' => [
                    [
                        'id_boletim' => $id_boletim,
                        'nota' => $nota,
                        'frequencia' => $frequencia,
                        'situacao' => $situacao,
                        'id_aluno' => $id_aluno,
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

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 BoletimController::deleteController()");

        $id_boletim = (int) $args['id_boletim'];

        $this->boletimService->deleteService($id_boletim);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'boletins' => [
                    [
                        'id_boletim' => $id_boletim
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
        error_log("🔵 BoletimController::countController()");

        $total = $this->boletimService->countService();

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