<?php

namespace Api\Middlewares\Professor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Api\Http\ErrorResponse;

class ValidateProfessorBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body);

        if (!isset($objPHP->professor)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'professor' é obrigatório!"
                ]
            );
        }

        $professor = $objPHP->professor;

        if (!isset($professor->nomeProfessor) || trim((string) $professor->nomeProfessor) === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'nomeProfessor' é obrigatório!"
                ]
            );
        }
        if (!isset($professor->email) || trim((string) $professor->email) === "") {
            throw new ErrorResponse(
                400,
                "Erro na validação de dados",
                [
                    "message" => "O campo 'email' é obrigatório!"
                ]
            );
        }

        if (!isset($professor->senha) || trim((string) $professor->senha) === "") {
            throw new ErrorResponse(
                400,
                "Erro na validação de dados",
                [
                    "message" => "O campo 'senha' é obrigatório!"
                ]
            );
        }

        return $handler->handle($request);
    }
}