<?php

namespace Api\Middlewares\Curso;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Api\Http\ErrorResponse;

class ValidateCursoBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body);

        if (!isset($objPHP->curso)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'curso' é obrigatório!"
                ]
            );
        }

        $curso = $objPHP->curso;

        if (!isset($curso->nomeCurso) || trim((string) $curso->nomeCurso) === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'nomeCurso' é obrigatório!"
                ]
            );
        }

        return $handler->handle($request);
    }
}